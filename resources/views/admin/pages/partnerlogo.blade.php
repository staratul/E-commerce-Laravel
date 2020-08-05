@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Partner Logo</h1>
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
            <div class="col-md-12 my-3">
                <form action="" id="partnerlogoForm">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center bg-info p-2"><i class="fas fa-plus mr-1"></i> ADD LOGO</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="partnerlogo_id" id="partnerlogo_id" value="">
                                    <label for="titlt">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="image">Image</label>
                                    <input class="btn btn-info form-control-file" type="file" accept="image/jpg, image/jpeg, image/png, image/gif" name="image" id="image" required>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="mt-4 btn btn-success rounded-0" id="partnerlogoBtn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-md-12 mt-3">
                    <div id="jsGrid"></div>
                </div>
            </div>
          </div>
        </div>
      </div>

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
                        url: "{{ route('partnerlogo.data') }}",
                        method: "GET",
                        data: filter
                    }).done(function(result) {
                        result = $.grep(result, function(item) {
                            return (!filter.title || item.title.indexOf(filter.title) > -1)
                        });
                        d.resolve(result);
                    });
                    return d.promise();
                },
            },
            fields: [
                { name: "logo", type: "text", title: "Logo", align: "center", width: 100,
                    itemTemplate: function(item, value) {
                        let url = "{{ env('APP_URL') }}";
                        return `<img src="${url}/uploads/admin/partnerlogo/${value.logo}" class="bg-dark p-3">`;
                    }
                },
                { name: "title", type: "text", title: "Title", width: 100},
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
                        return `<button type="button"  onclick="editParatnerLogo(${value.id})" class="btn btn-info text-white"><i class="fas fa-pen"></i></button><button type="button"  onclick="deleteParatnerLogo(${value.id})" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>`
                    }
                }
            ],
        });

        $("#partnerlogoForm").validate();

        storePartnerLogo = (formData) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#partnerlogoBtn").attr("disabled", "disabled");
            $("#loader").css("display", "block");
            // Submit Form data using ajax
            $.ajax({
                url: "{{ route('admin.partnerlogo') }}",
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.msg);
                    $("#jsGrid").jsGrid({
                        autoload: true
                    });
                    $("#loader").css("display", "none")
                    $("#partnerlogoForm").trigger("reset");
                    $("#partnerlogo_id").val(undefined);
                    $("#partnerlogoBtn").removeAttr("disabled")
                },
                error: function(reject) {
                    $.each(reject.responseJSON.errors, function (key, item) {
                        toastr.error(item);
                    });
                    $("#loader").css("display", "none")
                    $("#partnerlogoBtn").removeAttr("disabled")
                }
            });
        }

        $("#partnerlogoForm").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            if($("#partnerlogoForm").valid()) {
                e.preventDefault();
                storePartnerLogo(formData);
            }
        });
    });

    editParatnerLogo = (id) => {
        $("#loader").css("display", "block");
        let url = "{{ route('admin.partnerlogo.edit', ':id') }}";
        url = url.replace(":id", id);
        $.ajax({
            url,
            method: "GET",
            success: function(response) {
                $("#partnerlogoForm").trigger("reset");
                $("#title").val(response.title);
                $("#partnerlogo_id").val(response.partnerlogo_id);
                $("#loader").css("display", "none");
            },
            error: function(reject) {
                $("#loader").css("display", "none");
                console.log(reject);
            }
        })
    }

    updateStatus = (id, status) => {
        $("#loader").css("display", "block");
        let url = "{{ route('admin.partnerlogo.status', ':id') }}";
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

    deleteParatnerLogo = (id) => {

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
