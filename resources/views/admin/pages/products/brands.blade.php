@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Manage Brand</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Manage Brand</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <button type="button" onclick="openModal()" class="btn btn-light ml-2 py-2" data-toggle="modal" data-target="#brand_modal"><i class="fas fa-plus mr-1"></i>Add</button>
            <div class="col-md-12 my-3">
                <div id="jsGrid"></div>
            </div>
          </div>
        </div>
      </div>

    @include('admin.modals.brand_modal')

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
            deleteConfirm: "Do you really want to delete brand?",
            controller: {
                loadData: function(filter) {
                    var d = $.Deferred();
                    $.ajax({
                        url: "{{ route('products.brand') }}",
                        method: "GET",
                        data: filter
                    }).done(function(result) {
                        result = $.grep(result, function(item) {
                            return (!filter.brand || item.brand.indexOf(filter.brand) > -1)
                        });
                        d.resolve(result);
                    });
                    return d.promise();
                },
            },
            fields: [
                { name: "brand", type: "text", title: "brand", width: 100},
                { type: "control", width: 80, editButton: false, deleteButton: false,
                    itemTemplate: function(item, value) {
                        return `<button type="button"  onclick="editbrand(${value.id})" class="btn btn-info text-white"><i class="fas fa-pen"></i></button><button type="button"  onclick="deletebrand(${value.id})" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></button>`
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

        $("#brand_form").validate();
        storebrand = () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#brand_form_submit").attr("disabled", "disabled");
            $("#loader").css("display", "block");
            // Submit Form data using ajax
            $.ajax({
                url: "{{ route('products.brand') }}",
                method: "POST",
                data: $("#brand_form").serialize(),
                success: function(response) {
                    toastr.success(response.msg);
                    $("#jsGrid").jsGrid({
                        autoload: true
                    });
                    $("#loader").css("display", "none")
                    $("#brand_form").trigger("reset");
                    $("#brand_modal").modal("hide");
                    $("#brand_id").val(undefined);
                    $("#modal_title").text("Add brand");
                    $("#brand_form_submit").removeAttr("disabled")
                },
                error: function(reject) {
                    $.each(reject.responseJSON.errors, function (key, item)
                    {
                        toastr.error(item);
                    });
                    $("#loader").css("display", "none")
                    $("#brand_form_submit").removeAttr("disabled")
                }
            });
        }

        $("#brand_form").submit(function(e) {
            e.preventDefault();
            if($("#brand_form").valid()) {
                e.preventDefault();
                storebrand();
            }
        });

        updateStatus = (id, status) => {
            $("#loader").css("display", "block")
            $.ajax({
                url: "{{ route('products.brand') }}",
                method: "GET",
                data: {brand_id: id, status: status},
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

        editbrand = (id) => {
            $.ajax({
                url: "{{ route('products.brand') }}",
                method: "GET",
                data: {brand_id: id},
                success: function(response) {
                    let brand;
                    $("#brand_form").trigger("reset");
                    $("#brand_id").val(response.id);
                    $("#brand").val(response.brand);
                    $("#modal_title").text("Update brand");
                    $("#brand_modal").modal("show");
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        }

        deletebrand = (id) => {
            if(confirm("Are you sure you want to delete this item ?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#loader").css("display", "block")
                $.ajax({
                    url: "{{ route('products.brand') }}",
                    method: "DELETE",
                    data: {brand_id: id},
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
            $("#modal_title").text("Add brand");
            $("#brand_form").trigger("reset");
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
