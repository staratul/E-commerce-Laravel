@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Menus</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Menus</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      

      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <button type="button" class="btn btn-light ml-2 py-2" data-toggle="modal" data-target="#weekdeal_modal" onclick="openModal()"><i class="fas fa-plus mr-1"></i>Add</button>
            <div class="col-md-12 my-3">
                <div id="jsGrid"></div>
            </div>
          </div>
        </div>
      </div>

    @include('admin.modals.weekdeal_modal')

@endsection


@push('js')
<script>
    // Global variable
    let counter = 1;
    $(function() {
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
            deleteConfirm: "Do you really want to delete menu?",
            controller: {
                loadData: function(filter) {
                    var d = $.Deferred();
                    $.ajax({
                        url: "{{ route('admin.weekdeal.data') }}",
                        method: "GET"
                    }).done(function(result) {
                        result = $.grep(result, function(item) {
                            return (!filter.category.category || item.category.category.indexOf(filter.category.category) > -1)
                                && (!filter.deal_type || item.deal_type.indexOf(filter.deal_type) > -1)
                                && (!filter.deal_on || item.deal_on.indexOf(filter.deal_on) > -1)
                                && (!filter.price || item.price.indexOf(filter.price) > -1)
                        });
                        d.resolve(result);
                    });
                    return d.promise();
                },
            },
            fields: [
                { name: "image.url", type: "text", title: "Imge", width: 100, 
                    itemTemplate: function(item, value) {
                        return `<img src="${value.image.url}" alt="image" height="50" width="180">`;
                    }
                },
                { name: "category.category", type: "text", title: "Category", width: 100},
                { name: "deal_type", type: "text", title: "Deal Type", width: 50, 
                    itemTemplate: function(item, value) {
                        switch(value.deal_type) {
                            case "D":
                                return "Day";
                                break;
                            case "W":
                                return "Week";
                                break;
                            case "M":
                                return "Month";
                                break;
                            default:
                                return "";
                        }
                    }
                },
                { name: "deal_on", type: "text", title: "Deal On", width: 50},
                { name: "price", type: "text", title: "Price", width: 50},
                { name: "active", type: "text", width: 50, title: "Active", align: "center",
                    itemTemplate: function(item, value) {
                        let button = '';
                        if(value.active == 0) {
                            button = `<button type="button" onclick="updateStatus(${value.id},${value.active})" class="btn btn-secondary text-white"><i class="fas fa-toggle-off"></i></button>`;
                        }else if(value.active == 1) {
                            button = `<button type="button"  onclick="updateStatus(${value.id},${value.active})" class="btn btn-success"><i class="fas fa-toggle-on"></i></button>`;
                        }
                        return button;
                    }
                },
                { type: "control", width: 80, editButton: false, deleteButton: false,
                    itemTemplate: function(item, value) {
                        return `<button type="button"  onclick="editWeekdeal(${value.id})" class="btn btn-info text-white"><i class="fas fa-pen"></i></button><button type="button"  onclick="deleteWeekdeal(${value.id})" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>`
                    }
                }
            ],
        });

        $("#weekdeal_form").validate({ 
            errorPlacement: function(error, element) { 
                if (element.attr("name") == "category_id")
                    error.appendTo('#category_id_error');
                if  (element.attr("name") == "deal_type" )
                    error.appendTo('#deal_type_error');
                if  (element.attr("name") == "deal_on" )
                    error.appendTo('#deal_on_error');
                if  (element.attr("name") == "price" )
                    error.appendTo('#price_error');
                if  (element.attr("name") == "content" )
                    error.appendTo('#content_error');
                // else
                //     error.insertAfter(element);
            }
        });

        $("#category_id").on("change", () => {
            let categories,category_id,category,tags,tagOption="",isMatch='';
            $("#deal_on").html(tagOption);
            categories = {!! isset($categories) ? $categories : [] !!};
            category_id = $("#category_id").val();
            category = categories.filter(cat => cat.id === Number(category_id));
            if(category.length > 0) {
                if(category[0].tag) {
                    tags = category[0].tag.tags.split(",");
                    tagOption += `<option value=''>Select</option>`;
                    for(tag of tags) {
                        tagOption += `<option ${isMatch} value="${tag}">${tag}</option>`;
                    }
                }
            }
            $("#deal_on").append(tagOption);
        }).change();

        $("#category_id").on("change", () => {$("#category_id").valid();});
        $("#deal_on").on("change", () => {$("#deal_on").valid();});
        $("#deal_type").on("change", () => {$("#deal_type").valid();});

        storeWeekdeal = (formData) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#weekdeal_form_submit").attr("disabled", "disabled");
            $("#loader").css("display", "block");
            // Submit Form data using ajax
            $.ajax({
                url: "{{ route('admin.weekdeal') }}",
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
                    $("#weekdeal_modal").modal("hide");
                    $("#weekdeal_form").trigger("reset");
                    $("#weekdeal_id").val(undefined);
                    $("#modal_title").text("Add A Deal");
                    $("#weekdeal_form_submit").removeAttr("disabled")
                },
                error: function(reject) {
                    $.each(reject.responseJSON.errors, function (key, item)
                    {
                        toastr.error(item);
                    });
                    $("#loader").css("display", "none")
                    $("#weekdeal_form_submit").removeAttr("disabled")
                }
            });
        }

        $("#weekdeal_form").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            if($("#weekdeal_form").valid()) {
                e.preventDefault();
                storeWeekdeal(formData);
            }
        });
    });

    editWeekdeal = (id) => {
        $("#loader").css("display", "block");
        let url = "{{ route('admin.weekdeal.edit', ':id') }}";
        url = url.replace(":id", id);
        $.ajax({
            url,
            method: "GET",
            data: {category_id: id},
            success: function(response) {
                let categories,category,tags,tagOption="",isMatch='';
                $("#weekdeal_form").trigger("reset");
                $("#category_id").val(response.category_id);
                $("#content").val(response.content);
                $("#deal_type").val(response.deal_type);
                $("#price").val(response.price);   

                $("#deal_on").html(tagOption);
                categories = {!! isset($categories) ? $categories : [] !!};
                category = categories.filter(cat => cat.id === Number(response.category_id));
                if(category.length > 0) {
                    if(category[0].tag) {
                        tags = category[0].tag.tags.split(",");
                        tagOption += `<option value=''>Select</option>`;
                        for(tag of tags) {
                            if(tag == response.deal_on) {
                                isMatch = "selected";
                            }
                            tagOption += `<option ${isMatch} value="${tag}">${tag}</option>`;
                            isMatch = "";
                        }
                    }
                }
                $("#deal_on").append(tagOption);
                $("#weekdeal_id").val(response.id);
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });
                $("#modal_title").text("Update Deal");
                $("#loader").css("display", "none");
                $("#weekdeal_modal").modal("show");
            },
            error: function(reject) {
                $("#loader").css("display", "none");
                console.log(reject);
            }
        })
    }

    updateStatus = (id, status) => {
        $("#loader").css("display", "block");
        let url = "{{ route('admin.weekdeal.active', ':id') }}";
        url = url.replace(":id", id);
        $.ajax({
            url,
            method: "GET",
            data: {status},
            success: function(response) {
                $("#loader").css("display", "none");
                toastr.success(response.msg);
                $("#jsGrid").jsGrid({
                    autoload: true
                });
            },
            error: function(reject) {
                $("#loader").css("display", "none");
                console.log(reject);
            }
        })
    }

    openModal = () => {
        $("#weekdeal_form").trigger("reset");
        $("#category_id option").removeAttr("selected");
        $("#deal_on option").removeAttr("selected");
        $("#deal_type option").removeAttr("selected");
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        $("#weekdeal_id").val(undefined);
        $("#modal_title").text("Add A Deal");
    }

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
