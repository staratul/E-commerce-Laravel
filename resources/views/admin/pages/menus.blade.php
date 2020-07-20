@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Menus</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Menus</li>
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
            <button type="button" class="btn btn-light ml-2 py-2" data-toggle="modal" data-target="#menu_modal"><i class="fas fa-plus mr-1"></i>Add</button>
            <div class="col-md-12 my-3">
                <div id="jsGrid"></div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->

    @include('admin.modals.menus_modal')

@endsection


@push('js')
<script>
    // Global variable
    let counter = 1;
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
            deleteConfirm: "Do you really want to delete menu?",
            controller: {
                loadData: function(filter) {
                    var d = $.Deferred();
                    $.ajax({
                        url: "{{ route('admin.menus') }}",
                        method: "GET",
                        data: filter
                    }).done(function(result) {
                        result = $.grep(result, function(item) {
                            return (!filter.menu || item.menu.indexOf(filter.menu) > -1)
                                && (!filter.submenu || item.submenu.indexOf(filter.submenu) > -1)
                                && (!filter.status || item.status.indexOf(filter.status) > -1)
                        });
                        d.resolve(result);
                    });
                    return d.promise();
                },
            },
            fields: [
                { name: "menu", type: "text", title: "menu", width: 100},
                { name: "menu_url", type: "text", title: "Menu URL", width: 100},
                { name: "sub_menus", type: "text", title: "Sub Menu", width: 150,
                    itemTemplate: function(item, value) {
                        let submenu = "";
                        if(value.sub_menus.length > 0) {
                            for(e of value.sub_menus) {
                                submenu += `<span class="badge badge-pill badge-info ml-2">${e.sub_menu}</span>`;
                            }
                        }
                        return submenu;
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
                        return `<button type="button"  onclick="editmenu(${value.id})" class="btn btn-info text-white"><i class="fas fa-pen"></i></button><button type="button"  onclick="deletemenu(${value.id})" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>`
                    }
                }
            ],
        });

        $("#menus_form").validate();
        storemenus = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#menu_form_submit").attr("disabled", "disabled");
            $("#loader").css("display", "block");
            // Submit Form data using ajax
            $.ajax({
                url: "{{ route('admin.menus') }}",
                method: "POST",
                data: $("#menus_form").serialize(),
                success: function(response) {
                    toastr.success(response.msg);
                    $("#jsGrid").jsGrid({
                        autoload: true
                    });
                    $("#loader").css("display", "none")
                    $("#menus_form").trigger("reset");
                    $("#sub_menu_div").html("");
                    $("#menu_modal").modal("hide");
                    $("#menus_id").val(undefined);
                    $("#modal_title").text("Add menu");
                    $("#menu_form_submit").removeAttr("disabled")
                },
                error: function(reject) {
                    $.each(reject.responseJSON.errors, function (key, item)
                    {
                        toastr.error(item);
                    });
                    $("#loader").css("display", "none")
                    $("#menu_form_submit").removeAttr("disabled")
                }
            });
        }

        $("#menus_form").submit(function(e) {
            e.preventDefault();
            if($("#menus_form").valid()) {
                e.preventDefault();
                storemenus();
            }
        });

        updateStatus = (id, status) => {
            $("#loader").css("display", "block")
            $.ajax({
                url: "{{ route('admin.menus') }}",
                method: "GET",
                data: {menu_id: id, status: status},
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

        editmenu = (id) => {
            $.ajax({
                url: "{{ route('admin.menus') }}",
                method: "GET",
                data: {menu_id: id},
                success: function(response) {
                    let submenu;
                    $("#menus_form").trigger("reset");
                    $("#sub_menu_div").html("");
                    $("#menus_id").val(response[0].id);
                    $("#menu").val(response[0].menu);
                    $("#menu_url").val(response[0].menu_url);
                    if(response[0].sub_menus.length > 0 ) {
                        let subMenu = response[0].sub_menus;
                        for(e of subMenu){
                            let subMenu = `<div class="form-row" id="sub_menu_div${counter}">
                                <div class="form-group ml-1">
                                <label for="sub_menu">Sub Menu</label>
                                <input type="text" name="sub_menu[]" id="sub_menu" class="form-control" value="${e.sub_menu}" placeholder="Sub Menu"></div><div class="form-group ml-3">
                                <label for="sub_menu_url">Sub Menu URL</label>
                                <input type="text" name="sub_menu_url[]" id="sub_menu_url" class="form-control" value="${e.sub_menu_url}" placeholder="Sub Menu URL"></div><a href="javascript:;"id="delete_sub_menu" onclick="deleteSubMenu(${counter})" class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                </div>`;
                            ++counter;
                            $("#sub_menu_div").append(subMenu);
                        }
                    }
                    $("#modal_title").text("Update menu");
                    $("#menu_modal").modal("show");
                },
                error: function(reject) {
                    console.log(reject);
                }
            })
        }

        deletemenu = (id) => {
            if(confirm("Are you sure you want to delete this item ?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#loader").css("display", "block")
                $.ajax({
                    url: "{{ route('admin.menus') }}",
                    method: "DELETE",
                    data: {menu_id: id},
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

        $("#add_sub_menu").on("click", () => {
            let submenu = `<div class="form-row" id="sub_menu_div${counter}">
                                <div class="form-group ml-1">
                                <label for="sub_menu">Sub Menu</label>
                                <input type="text" name="sub_menu[]" id="sub_menu" class="form-control" placeholder="Sub Menu"></div>
                                <div class="form-group ml-3">
                                <label for="sub_menu_url">Sub menu URL</label>
                                <input type="text" name="sub_menu_url[]" id="sub_menu_url" class="form-control" placeholder="Sub Menu URL"></div>
                                <a href="javascript:;"id="delete_sub_menu" onclick="deleteSubMenu(${counter})" class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                </div>`;
            ++counter;
            $("#sub_menu_div").append(submenu);
        });

        deleteSubMenu = (id) => {
            $(`#sub_menu_div${id}`).remove();
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
        #delete_sub_menu {height: 38px;width: 50px;margin-top: 30px;margin-left: 20px;
        }
    </style>
@endpush
