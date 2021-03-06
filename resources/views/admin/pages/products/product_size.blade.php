@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Size</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Size</li>
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
            <button type="button" onclick="openModal()" class="btn btn-light ml-2 py-2" data-toggle="modal" data-target="#size_modal"><i class="fas fa-plus mr-1"></i>Add</button>
            <div class="col-md-12 my-3">
                <div id="jsGrid"></div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->

    @include('admin.modals.size_modal')

@endsection


@push('js')
<script>
    $(function() {
        $('#category_id').select2({
            theme: 'bootstrap4'
        });

        $('.select2bs4').select2({
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
            deleteConfirm: "Do you really want to delete size?",
            controller: {
                loadData: function(filter) {
                    var d = $.Deferred();
                    $.ajax({
                        url: "{{ route('products.size') }}",
                        method: "GET"
                    }).done(function(result) {
                        result = $.grep(result, function(item) {
                            return (!filter.size || item.size.indexOf(filter.size) > -1)
                                && (!filter.status || item.status.indexOf(filter.status) > -1)
                        });
                        d.resolve(result);
                    });
                    return d.promise();
                },
            },
            fields: [
                { name: "category.category", type: "text", title: "Category", width: 100},
                { name: "size", type: "text", title: "Size", width: 150,
                    itemTemplate: function(item, value) {
                        let size = [], sizes = "";
                        if(value.size !== "") {
                            size = value.size.split(",");
                            for(x of size) {
                                sizes += `<span class="badge badge-pill badge-primary ml-2">${x}</span>`
                            }
                        }
                        return sizes;
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
                        return `<button type="button"  onclick="editsize(${value.id})" class="btn btn-info text-white"><i class="fas fa-pen"></i></button><button type="button"  onclick="deletesize(${value.id})" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>`
                    }
                }
            ],
        });

        $("#size_form").validate();
        storesize = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#size_form_submit").attr("disabled", "disabled");
            $("#loader").css("display", "block");
            // Submit Form data using ajax
            $.ajax({
                url: "{{ route('products.size') }}",
                method: "POST",
                data: $("#size_form").serialize(),
                success: function(response) {
                    toastr.success(response.msg);
                    $("#jsGrid").jsGrid({
                        autoload: true
                    });
                    $("#loader").css("display", "none")
                    $("#size_form").trigger("reset");
                    $("#size_modal").modal("hide");
                    $("#size_id").val(undefined);
                    $("#modal_title").text("Add Size");
                    $("#size_form_submit").removeAttr("disabled")
                },
                error: function(reject) {
                    $.each(reject.responseJSON.errors, function (key, item)
                    {
                        toastr.error(item);
                    });
                    $("#loader").css("display", "none")
                    $("#size_form_submit").removeAttr("disabled")
                }
            });
        }

        $("#size_form").submit(function(e) {
            e.preventDefault();
            if($("#size_form").valid()) {
                e.preventDefault();
                storesize();
            }
        });

        updateStatus = (id, status) => {
            $("#loader").css("display", "block")
            $.ajax({
                url: "{{ route('products.size') }}",
                method: "GET",
                data: {size_id: id, status: status},
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

        editsize = (id) => {
            $.ajax({
                url: "{{ route('products.size') }}",
                method: "GET",
                data: {size_id: id},
                success: function(response) {
                    let sizes,option='';
                    $("#size_form").trigger("reset");
                    $("#size_id").val(response.id);
                    $("#category_id option").removeAttr("selected");
                    $.each($("#category_id option"), function(i, o) {
                        if((Number($(o).val()) === response.category_id)) {
                            $(o).attr("selected", "selected");
                        }
                    });
                    $("#category_id").select2({
                        theme: 'bootstrap4'
                    });
                    if(response.size !== "") {
                        sizes = response.size.split(',');
                        $.each($("#size option"), function(i, o) {
                            for(size of sizes) {
                                if(($(o).val() === size)) {
                                    $(o).attr("selected", "selected");
                                }
                            }
                        });
                        $('.select2bs4').select2({
                            theme: 'bootstrap4'
                        });
                    }
                    $("#modal_title").text("Update Size");
                    $("#size_modal").modal("show");
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        }

        deletesize = (id) => {
            if(confirm("Are you sure you want to delete this item ?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#loader").css("display", "block")
                $.ajax({
                    url: "{{ route('products.size') }}",
                    method: "DELETE",
                    data: {size_id: id},
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
            $("#modal_title").text("Add Size");
            $("#size_form").trigger("reset");
            $("#category_id option").removeAttr("selected");
            $('#size option').removeAttr("selected");
            $('#category_id').select2({
                theme: 'bootstrap4'
            });

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
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
    </style>
@endpush
