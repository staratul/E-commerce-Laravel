@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Categories</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Categories</li>
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
            <button type="button" class="btn btn-light ml-2 py-2" data-toggle="modal" data-target="#category_modal" onclick="addCategoryModal()"><i class="fas fa-plus mr-1"></i>Add</button>
            <div class="col-md-12 my-3">
                <div id="jsGrid"></div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->

    @include('admin.modals.categories_modal')

@endsection


@push('js')
<script>
    // global variable
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
            deleteConfirm: "Do you really want to delete category?",
            controller: {
                loadData: function(filter) {
                    var d = $.Deferred();
                    $.ajax({
                        url: "{{ route('admin.categories') }}",
                        method: "GET",
                        data: filter
                    }).done(function(result) {
                        result = $.grep(result, function(item) {
                            return (!filter.category || item.category.indexOf(filter.category) > -1)
                                && (!filter.category_url || item.category_url.indexOf(filter.category_url) > -1)
                                && (!filter.status || item.status.indexOf(filter.status) > -1)
                        });
                        d.resolve(result);
                    });
                    return d.promise();
                },
            },
            fields: [
                { name: "category", type: "text", title: "Category", width: 150},
                { name: "category_url", type: "text", title: "Sub Category URL", width: 150},
                { name: "sub_categories", type: "text", title: "Sub Categories", width: 150,
                    itemTemplate: function(item, value) {
                        let submenu = "";
                        if(value.sub_categories.length > 0) {
                            for(e of value.sub_categories) {
                                submenu += `<span class="badge badge-pill badge-info ml-2">${e.sub_category}</span>`;
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
                        return `<button type="button"  onclick="editCategory(${value.id})" class="btn btn-info text-white"><i class="fas fa-pen"></i></button><button type="button"  onclick="deleteCategory(${value.id})" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>`
                    }
                }
            ],
        });

        $("#categories_form").validate();
        storeCategories = (formData) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#category_form_submit").attr("disabled", "disabled");
            $("#loader").css("display", "block");
            // Submit Form data using ajax
            $.ajax({
                url: "{{ route('admin.categories') }}",
                method: "POST",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.msg);
                    $("#jsGrid").jsGrid({
                        autoload: true
                    });
                    $("#loader").css("display", "none")
                    $("#categories_form").trigger("reset");
                    $("#sub_category_div").html("");
                    $("#category_modal").modal("hide");
                    $("#categories_id").val(undefined);
                    $("#modal_title").text("Add Category");
                    $("#category_form_submit").removeAttr("disabled")
                },
                error: function(reject) {
                    $.each(reject.responseJSON.errors, function (key, item)
                    {
                        toastr.error(item);
                    });
                    $("#loader").css("display", "none")
                    $("#category_form_submit").removeAttr("disabled")
                }
            });
        }
        $("#categories_form").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            console.log(formData);
            if($("#categories_form").valid()) {
                e.preventDefault();
                storeCategories(formData);
            }
        });

        updateStatus = (id, status) => {
            $("#loader").css("display", "block")
            $.ajax({
                url: "{{ route('admin.categories') }}",
                method: "GET",
                data: {category_id: id, status: status},
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

        editCategory = (id) => {
            $.ajax({
                url: "{{ route('admin.categories') }}",
                method: "GET",
                data: {category_id: id},
                success: function(response) {
                    console.log(response);
                    $("#categories_form").trigger("reset");
                    $("#sub_category_div").html("");
                    $("#categories_id").val(response[0].id);
                    $("#category").val(response[0].category);
                    $("#category_url").val(response[0].category_url);
                    if(response[0].sub_categories.length > 0 ) {
                        let subCategories = response[0].sub_categories;
                        for(e of subCategories){
                            let subCategory = `<div class="row" id="sub_category_div${counter}">
                                                <div class="col-md-6"><div class="form-group"><label for="sub_category">Sub Category</label><input type="text" name="sub_category[]" id="sub_category" class="form-control" value="${e.sub_category}" placeholder="Sub Category" /></div></div><div class="col-md-6"><div class="form-group"><label for="sub_category_url">Sub Category URL</label>
                                                <input type="text" name="sub_category_url[]" id="sub_category_url" value="${e.sub_category_url}" class="form-control" placeholder="Sub Category URL" /></div></div><div class="col-md-10"><div class="form-group"><input class="btn btn-info" type="file" accept="image/jpg, image/jpeg, image/png, image/gif" name="images[]" id="images" multiple /></div></div><div class="col-md-2">
                                                <a href="javascript:;" id="delete_sub_category" onclick="deleteSubCategory(${counter})" class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                </div></div>`;
                            ++counter;
                            $("#sub_category_div").append(subCategory);
                        }
                    }
                    $("#modal_title").text("Update Category");
                    $("#category_modal").modal("show");
                },
                error: function(reject) {
                    console.log(reject);
                }
            })
        }

        deleteCategory = (id) => {
            if(confirm("Are you sure you want to delete this item ?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#loader").css("display", "block")
                $.ajax({
                    url: "{{ route('admin.categories') }}",
                    method: "DELETE",
                    data: {category_id: id},
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

        $("#add_sub_category").on("click", () => {
            let subCategory = `<div class="row" id="sub_category_div${counter}"><div class="col-md-6">
                                <div class="form-group"><label for="sub_category">Sub Category</label><input type="text" name="sub_category[]" id="sub_category" class="form-control" placeholder="Sub Category" /></div></div><div class="col-md-6"><div class="form-group"><label for="sub_category_url">Sub Category URL</label>
                                <input type="text" name="sub_category_url[]" id="sub_category_url" class="form-control" placeholder="Sub Category URL" /></div></div><div class="col-md-10"><div class="form-group">
                                <input class="btn btn-info" type="file" accept="image/jpg, image/jpeg, image/png, image/gif" name="images[]" id="images" multiple /></div></div><div class="col-md-2">
                                <a href="javascript:;" id="delete_sub_category" onclick="deleteSubCategory(${counter})" class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                </div></div>`;

            ++counter;
            $("#sub_category_div").append(subCategory);
        });

        deleteSubCategory = (id) => {
            $(`#sub_category_div${id}`).remove();
        }

        addCategoryModal = () => {
            $("#categories_form").trigger("reset");
            $("#sub_category_div").html("");
            $("#categories_id").val(undefined);
            $("#modal_title").text("Add Category");
            $("#category_form_submit").removeAttr("disabled")
        }
    });
</script>
@endpush

@push('css')
    <style>
        #loader {
            display: none;
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('/img/loader3.gif') 50% 50% no-repeat rgb(10,10,10);
            opacity: .8;
        }
        .bootstrap-tagsinput .badge {
            margin: 2px 2px;
        }
        #delete_sub_category {
            height: 38px;
            width: 50px;
            margin-top: 0px;
            margin-left: 5px;
        }
    </style>
@endpush

