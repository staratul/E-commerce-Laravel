@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Color</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Color</li>
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
            <button type="button" onclick="openModal()" class="btn btn-light ml-2 py-2" data-toggle="modal" data-target="#color_modal"><i class="fas fa-plus mr-1"></i>Add</button>
            <div class="col-md-12 my-3">
                <div id="jsGrid"></div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->

    @include('admin.modals.color_modal')

@endsection


@push('js')
<script>
    $(function() {
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
            deleteConfirm: "Do you really want to delete color?",
            controller: {
                loadData: function(filter) {
                    var d = $.Deferred();
                    $.ajax({
                        url: "{{ route('products.color') }}",
                        method: "GET"
                    }).done(function(result) {
                        result = $.grep(result, function(item) {
                            return (!filter.color || item.color.indexOf(filter.color) > -1)
                                && (!filter.status || item.status.indexOf(filter.status) > -1)
                        });
                        d.resolve(result);
                    });
                    return d.promise();
                },
            },
            fields: [
                { name: "color", type: "text", title: "Color", width: 100},
                { name: "code", type: "text", title: "Code", width: 100,
                    itemTemplate: function(item, value) {
                        let color = `<i style="color:${value.code}" class="fas fa-circle"></i>
                                        <span class="ml-2">${value.code}</span>`;

                        return color;
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
                        return `<button type="button"  onclick="editcolor(${value.id})" class="btn btn-info text-white"><i class="fas fa-pen"></i></button><button type="button"  onclick="deletecolor(${value.id})" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>`
                    }
                }
            ],
        });

        $("#jsGrid :input").keydown(function () {
            var self = this;
            if (self.timeout)
                clearTimeout(self.timeout);
            if (self.value.length == 0)
                $("#jsGrid").jsGrid('loadData');
            self.timeout = setTimeout(function() {
                $("#jsGrid").jsGrid('loadData');
            }, 1);
        });

        $("#color_form").validate();
        storecolor = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#color_form_submit").attr("disabled", "disabled");
            $("#loader").css("display", "block");
            // Submit Form data using ajax
            $.ajax({
                url: "{{ route('products.color') }}",
                method: "POST",
                data: $("#color_form").serialize(),
                success: function(response) {
                    toastr.success(response.msg);
                    $("#jsGrid").jsGrid({
                        autoload: true
                    });
                    $("#loader").css("display", "none")
                    $("#color_form").trigger("reset");
                    $("#color_modal").modal("hide");
                    $("#color_id").val(undefined);
                    $("#modal_title").text("Add Color");
                    $("#color_form_submit").removeAttr("disabled")
                },
                error: function(reject) {
                    $.each(reject.responseJSON.errors, function (key, item)
                    {
                        toastr.error(item);
                    });
                    $("#loader").css("display", "none")
                    $("#color_form_submit").removeAttr("disabled")
                }
            });
        }

        $("#color_form").submit(function(e) {
            e.preventDefault();
            if($("#color_form").valid()) {
                e.preventDefault();
                storecolor();
            }
        });

        updateStatus = (id, status) => {
            $("#loader").css("display", "block")
            $.ajax({
                url: "{{ route('products.color') }}",
                method: "GET",
                data: {color_id: id, status: status},
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

        editcolor = (id) => {
            $.ajax({
                url: "{{ route('products.color') }}",
                method: "GET",
                data: {color_id: id},
                success: function(response) {
                    let color;
                    $("#color_form").trigger("reset");
                    $("#color_id").val(response.id);
                    $("#color").val(response.color);
                    $("#code").val(response.code);
                    $("#modal_title").text("Update Color");
                    $("#color_modal").modal("show");
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        }

        deletecolor = (id) => {
            if(confirm("Are you sure you want to delete this item ?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#loader").css("display", "block")
                $.ajax({
                    url: "{{ route('products.color') }}",
                    method: "DELETE",
                    data: {color_id: id},
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
            $("#modal_title").text("Add Color");
            $("#color_form").trigger("reset");
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
