@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Manage State</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Manage State</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <button type="button" onclick="openModal()" class="btn btn-light ml-2 py-2" data-toggle="modal" data-target="#state_modal"><i class="fas fa-plus mr-1"></i>Add</button>
            <div class="col-md-12 my-3">
                <div id="jsGrid"></div>
            </div>
          </div>
        </div>
      </div>

    @include('admin.modals.state_modal')

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
            deleteConfirm: "Do you really want to delete state?",
            controller: {
                loadData: function(filter) {
                    var d = $.Deferred();
                    $.ajax({
                        url: "{{ route('products.state') }}",
                        method: "GET"
                    }).done(function(result) {
                        result = $.grep(result, function(item) {
                            return (!filter.state || item.state.indexOf(filter.state) > -1)
                        });
                        d.resolve(result);
                    });
                    return d.promise();
                },
            },
            fields: [
                { name: "state", type: "text", title: "state", width: 100},
                { type: "control", width: 80, editButton: false, deleteButton: false,
                    itemTemplate: function(item, value) {
                        return `<button type="button"  onclick="editstate(${value.id})" class="btn btn-info text-white"><i class="fas fa-pen"></i></button><button type="button"  onclick="deletestate(${value.id})" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>`
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

        $("#state_form").validate();
        storestate = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#state_form_submit").attr("disabled", "disabled");
            $("#loader").css("display", "block");
            // Submit Form data using ajax
            $.ajax({
                url: "{{ route('products.state') }}",
                method: "POST",
                data: $("#state_form").serialize(),
                success: function(response) {
                    toastr.success(response.msg);
                    $("#jsGrid").jsGrid({
                        autoload: true
                    });
                    $("#loader").css("display", "none")
                    $("#state_form").trigger("reset");
                    $("#state_modal").modal("hide");
                    $("#state_id").val(undefined);
                    $("#modal_title").text("Add State");
                    $("#state_form_submit").removeAttr("disabled")
                },
                error: function(reject) {
                    $.each(reject.responseJSON.errors, function (key, item)
                    {
                        toastr.error(item);
                    });
                    $("#loader").css("display", "none")
                    $("#state_form_submit").removeAttr("disabled")
                }
            });
        }

        $("#state_form").submit(function(e) {
            e.preventDefault();
            if($("#state_form").valid()) {
                e.preventDefault();
                storestate();
            }
        });

        updateStatus = (id, status) => {
            $("#loader").css("display", "block")
            $.ajax({
                url: "{{ route('products.state') }}",
                method: "GET",
                data: {state_id: id, status: status},
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

        editstate = (id) => {
            $.ajax({
                url: "{{ route('products.state') }}",
                method: "GET",
                data: {state_id: id},
                success: function(response) {
                    let state;
                    $("#state_form").trigger("reset");
                    $("#state_id").val(response.id);
                    $("#state").val(response.state);
                    $("#modal_title").text("Update State");
                    $("#state_modal").modal("show");
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        }

        deletestate = (id) => {
            if(confirm("Are you sure you want to delete this item ?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#loader").css("display", "block")
                $.ajax({
                    url: "{{ route('products.state') }}",
                    method: "DELETE",
                    data: {state_id: id},
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
            $("#modal_title").text("Add state");
            $("#state_form").trigger("reset");
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
