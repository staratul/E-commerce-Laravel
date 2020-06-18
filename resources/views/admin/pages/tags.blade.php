@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Tags</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("home") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Tags</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <button type="button" onclick="openModal()" class="btn btn-light ml-2 py-2" data-toggle="modal" data-target="#tags_modal"><i class="fas fa-plus mr-1"></i>Add</button>
            <div class="col-md-12 my-3">
                <div id="jsGrid"></div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->

    @include('admin.modals.tags_modal')

@endsection


@push('js')
<script>
    // Global variable
    let counter = 1;
    $(function() {
        $("#category_id").select2({
            theme: 'bootstrap4'
        });
        $("#jsGrid").jsGrid({
            height: "auto",
            width: "100%",
            filtering: true,
            inserting: false,
            editing: false,
            sorting: true,
            paging: true,
            autoload: true,
            pageSize: 10,
            pageButtonCount: 5,
            deleteConfirm: "Do you really want to delete tags?",
            controller: {
                loadData: function(filter) {
                    var d = $.Deferred();
                    $.ajax({
                        url: "{{ route('admin.tags') }}",
                        method: "GET",
                        data: filter
                    }).done(function(result) {
                        result = $.grep(result, function(item) {
                            return (!filter.tags || item.tags.indexOf(filter.tags) > -1)
                                && (!filter.status || item.status.indexOf(filter.status) > -1)
                        });
                        d.resolve(result);
                    });
                    return d.promise();
                },
            },
            fields: [
                { name: "category.category", type: "text", title: "Category", width: 100},
                { name: "tags", type: "text", title: "Tag", width: 150, 
                    itemTemplate: function(item, value) {
                        let tags = [], tag = "";
                        if(value.tags !== "") {
                            tags = value.tags.split(",");
                            for(x of tags) {
                                tag += `<span class="badge badge-pill badge-primary ml-2">${x}</span>`
                            }
                        }
                        return tag;
                    }
                },
                { name: "status", type: "text", width: 50, title: "Status", align: "center",
                    itemTemplate: function(item, value) {
                        let button = '';
                        if(value.status == 0) {
                            button = `<button type="button" onclick="updateStatus(${value.id},${value.status})" class="btn btn-secondary text-white"><i class="fas fa-toggle-off"></i></button>`;
                        }else if(value.status == 1) {
                            button = `<button type="button"  onclick="updateStatus(${value.id},${value.status})" class="btn btn-success"><i class="fas fa-toggle-on"></i></button>`;
                        }
                        return button;
                    }
                },
                { type: "control", width: 80, editButton: false, deleteButton: false,
                    itemTemplate: function(item, value) {
                        return `<button type="button"  onclick="editTags(${value.id})" class="btn btn-info text-white"><i class="fas fa-pen"></i></button><button type="button"  onclick="deleteTags(${value.id})" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>`
                    }
                }
            ],
        });

        $("#tags_form").validate();
        storetags = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#tags_form_submit").attr("disabled", "disabled");
            $("#loader").css("display", "block");
            // Submit Form data using ajax
            $.ajax({
                url: "{{ route('admin.tags') }}",
                method: "POST",
                data: $("#tags_form").serialize(),
                success: function(response) {
                    toastr.success(response.msg);
                    $("#jsGrid").jsGrid({
                        autoload: true
                    });
                    $("#loader").css("display", "none")
                    $("#tags_form").trigger("reset");
                    $("#tags_modal").modal("hide");
                    $("#tags_id").val(undefined);
                    $('#tags').tagsinput('removeAll');
                    $("#modal_title").text("Add tags");
                    $("#tags_form_submit").removeAttr("disabled")
                },
                error: function(reject) {
                    $.each(reject.responseJSON.errors, function (key, item)
                    {
                        toastr.error(item);
                    });
                    $("#loader").css("display", "none")
                    $("#tags_form_submit").removeAttr("disabled")
                }
            });
        }

        $("#tags_form").submit(function(e) {
            e.preventDefault();
            if($("#tags_form").valid()) {
                e.preventDefault();
                storetags();
            }
        });

        updateStatus = (id, status) => {
            $("#loader").css("display", "block")
            $.ajax({
                url: "{{ route('admin.tags') }}",
                method: "GET",
                data: {tags_id: id, status: status},
                success: function(response) {
                    toastr.success(response.msg);
                    $("#jsGrid").jsGrid({
                        autoload: true
                    });
                    $("#loader").css("display", "none")
                },
                error: function(reject) {
                    $("#loader").css("display", "none")
                    console.log(reject);
                }
            })
        }

        editTags = (id) => {
            $.ajax({
                url: "{{ route('admin.tags') }}",
                method: "GET",
                data: {tags_id: id},
                success: function(response) {
                    let tags;
                    $("#tags_form").trigger("reset");
                    $('#tags').tagsinput('removeAll');
                    $("#tags_id").val(response.id);
                    $("#category_id option").removeAttr("selected");
                    $.each($("#category_id option"), function(i, o) {
                        if((Number($(o).val()) === response.category_id)) {
                            $(o).attr("selected", "selected");
                        }
                    });
                    $("#category_id").select2({
                        theme: 'bootstrap4'
                    });
                    if(response.tags !== "") {
                        tags = response.tags.split(',');
                        for(x of tags) {
                            $("#tags").tagsinput('add', x);
                        }
                    }
                    $("#modal_title").text("Update Tag");
                    $("#tags_modal").modal("show");
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        }

        deleteTags = (id) => {
            if(confirm("Are you sure you want to delete this item ?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#loader").css("display", "block")
                $.ajax({
                    url: "{{ route('admin.tags') }}",
                    method: "DELETE",
                    data: {tags_id: id},
                    success: function(response) {
                        toastr.success(response.msg);
                        $("#jsGrid").jsGrid({
                            autoload: true
                        });
                        $("#loader").css("display", "none")
                    },
                    error: function(reject) {
                        $("#loader").css("display", "none")
                        console.log(reject);
                    }
                })
            } else {
                return false;
            }
        }

        openModal = () => {
            $("#tags_form").trigger("reset");
            $('#tags').tagsinput('removeAll');
            $("#category_id option").removeAttr("selected");
        }
    });
</script>
@endpush

@push('css')
    <style>
        #loader {display: none;position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;
            z-index: 9999;
            background: url('/img/loader3.gif') 50% 50% no-repeat rgb(10,10,10);
            opacity: .8;
        }
        .bootstrap-tagsinput .badge {margin: 2px 2px;}
        }
    </style>
@endpush
