@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Contact Messages</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Contact Messages</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 my-3">
                <div id="jsGrid"></div>
            </div>
          </div>
        </div>
      </div>
      {{-- Modal --}}
      <div class="modal fade" id="reply_modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="reply_form">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title" id="modal_title">Send Reply To - <span id="user_name_text"></span></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-light" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="contact_message_id" id="contact_message_id" value="">
                            <input type="hidden" name="user_name" id="user_name" value="">
                            <label for="user_email">Email</label>
                            <input id="user_email" class="form-control" type="eamil" name="user_email" placeholder="Email" readonly>
                        </div>
                        <div class="form-group">
                            <label for="reply">Reply Message</label>
                            <textarea name="reply" id="reply" class="form-control" placeholder="Write your reply here..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="reply_form_submit" class="btn btn-primary rounded-0">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                        url: "{{ route('contact.messages.list') }}",
                        method: "GET"
                    }).done(function(result) {
                        result = $.grep(result, function(item) {
                            return (!filter.name || item.name.indexOf(filter.name) > -1)
                                && (!filter.email || item.email.indexOf(filter.email) > -1)
                                && (!filter.message || item.message.indexOf(filter.message) > -1)
                        });
                        d.resolve(result);
                    });
                    return d.promise();
                },
            },
            fields: [
                { name: "name", type: "text", title: "Name", width:60},
                { name: "email", type: "text", title: "Email", width:100},
                { name: "message", type: "text", title: "Message", width:100},
                { name: "created_at", type: "text", title: "Message Date", width:70},
                { type: "control", width: 50, editButton: false, deleteButton: false,
                    itemTemplate: function(item, value) {
                        let button = "";
                        if(value.replied == '0') {
                            button = `<button type="button" data-toggle="modal" data-target="#reply_modal" onclick="sendReply(${value.id},'${value.email}','${value.name}')" class="btn btn-info text-white ml-1">SEND</button>`
                        } else {
                            button = `<a href="javascript:;"  class="btn btn-dark text-white ml-1">SENDED!</a>`
                        }
                        return button;
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

    $("#reply_form").validate();
    $("#reply_form").on("submit", (e) => {
        e.preventDefault();
        $("#loader").css("display", "block")
        $.ajax({
            url: "{{ route('contact.messages') }}",
            method: "POST",
            data: $("#reply_form").serialize(),
            headers: {"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                toastr.success(response.msg);
                $("#jsGrid").jsGrid({
                    autoload: true
                });
                $("#reply_modal").modal("hide");
                $("#loader").css("display", "none");
            },
            error: function(reject) {
                $("#reply_modal").modal("hide");
                $("#loader").css("display", "none");
                $.each(reject.responseJSON.errors, function (key, item) {
                    toastr.error(item);
                });
            }
        });
    });

    sendReply = (id, email, name) => {
        console.log(id, email, name);
        $("#contact_message_id").val(id);
        $("#user_email").val(email);
        $("#user_name").val(name);
        $("#user_name_text").text(name);
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

