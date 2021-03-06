@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Manage Users</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Manage Users</li>
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
            <button type="button" class="btn btn-light ml-2 py-2" data-toggle="modal" data-target="#users_modal" onclick="addUserModal()"><i class="fas fa-plus mr-1"></i>Add</button>
            <div class="col-md-12 my-3">
                <div id="jsGrid"></div>
            </div>
          </div>
        </div>
      </div>
      @include('admin.modals.users_modal')
@endsection


@push('js')
<script>
    $(() => {
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
            deleteConfirm: "Do you really want to delete item?",
            controller: {
                loadData: function(filter) {
                    var d = $.Deferred();
                    $.ajax({
                        url: "{{ route('user.list') }}",
                        method: "GET"
                    }).done(function(result) {
                        result = $.grep(result, function(item) {
                            return (!filter.name || item.name.indexOf(filter.name) > -1)
                                && (!filter.email || item.email.indexOf(filter.email) > -1)
                        });
                        d.resolve(result);
                    });
                    return d.promise();
                },
            },
            fields: [
                { name: "name", type: "text", title: "Name", width:80},
                { name: "email", type: "text", title: "Email", width:100},
                { name: "created_at", type: "text", title: "Registration Date", width:100},
                { type: "control", width: 120, editButton: false, deleteButton: false,
                    itemTemplate: function(item, value) {
                        return `<button type="button" onclick="editUser(${value.id})" class="btn btn-info text-white ml-1"><i class="fas fa-pen"></i></button>`
                    }
                }
            ]
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
    });

    $("#user_form").validate();
    storeCategories = (formData) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#user_form_submit").attr("disabled", "disabled");
        $("#loader").css("display", "block");
        // Submit Form data using ajax
        $.ajax({
            url: "{{ route('users.store') }}",
            method: "POST",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(response) {
                // console.log(response);
                toastr.success(response.msg);
                $("#jsGrid").jsGrid({
                    autoload: true
                });
                $("#loader").css("display", "none")
                $("#user_form").trigger("reset");
                $("#users_modal").modal("hide");
                $("#user_id").val(undefined);
                $("#modal_title").text("Add User");
                $("#user_form_submit").removeAttr("disabled")
            },
            error: function(reject) {
                $.each(reject.responseJSON.errors, function (key, item)
                {
                    toastr.error(item);
                });
                $("#loader").css("display", "none")
                $("#user_form_submit").removeAttr("disabled")
            }
        });
    }
    $("#user_form").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);
        if($("#user_form").valid()) {
            e.preventDefault();
            storeCategories(formData);
        }
    });

    editUser = (id) => {
        let url = "{{ route('users.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            url,
            method: "GET",
            success: function(response) {
                // console.log(response);
                $("#user_form").trigger("reset");
                $("#user_id").val(response.id);
                $("#name").val(response.name);
                $("#email").val(response.email);
                $("#password").removeAttr("required");
                $("#modal_title").text("Update User");
                $("#users_modal").modal("show");
            },
            error: function(reject) {
                console.log(reject);
            }
        })
    }

    addUserModal = () => {
        $("#password").attr("required","required");
    }
</script>
@endpush
@push('css')
<style>
    #loader {
        display: none;position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999;
        background: url('/img/loader3.gif') 50% 50% no-repeat rgb(10,10,10);
        opacity: .8;
    }
</style>
@endpush

