@extends('admin.layouts.master') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div id="loader"></div>
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ isset($footer) ? 'Edit Footer' : 'Add Footer' }}</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="{{ route("footers.index") }}">Manage Footer</a></li>
               <li class="breadcrumb-item active">{{ isset($footer) ? 'Edit Footer' : 'Add Footer' }}</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- Main content -->
<div class="content">
    @include('common.messages')
   <div class="container-fluid">
      <div class="row">
         <a href="{{ route('footers.index') }}" class="btn btn-light ml-2 py-2">Back</a>
         <div class="col-md-12 my-3">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
               <div class="card-header">
                  <h3 class="card-title">Manage Footer</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                     <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                  </div>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <form action="{{ isset($footer) ? route('footers.update', $footer['id']) : route('footers.store') }}" method="POST" id="addfooter" enctype="multipart/form-data">
                     @csrf
                     @if (isset($footer))
                         @method('PUT')
                     @endif
                     <div class="row">
                        <div class="col-md-6">
                            <label for="logo">Logo</label>
                            <input class="btn btn-info form-control-file" type="file" accept="image/jpg, image/jpeg, image/png, image/gif" name="logo" id="logo" required>
                            <span id="logo_error"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="icons">Icons</label>
                            <select class="select2bs4 w-100" multiple="multiple" name="icons[]" id="icons" data-placeholder="Select Icons" required>
                                <option value="fa fa-facebook">Facebook</option>
                                <option value="fa fa-instagram">Instagram</option>
                                <option value="fa fa-twitter">Twitter</option>
                                <option value="fa fa-pinterest">Pinterest</option>
                            </select>
                            <span id="icons_error"></span>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required value="{{ isset($footer) ? $footer->email : '' }}">
                            <span id="email_error"></span>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="phone">Phone</label>
                            <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone" required value="{{ isset($footer) ? $footer->phone : '' }}">
                            <span id="phone_error"></span>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control" placeholder="Address" required>{!! isset($footer) ? $footer->address : '' !!}</textarea>
                            <span id="address_error"></span>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="information_links">Information Links</label>
                            <input type="text" data-role="tagsinput" name="information_links" id="information_links" class="form-control" placeholder="Information Links" required value="{{ isset($footer) ? $footer->information_links : '' }}">
                            <span id="information_links_error"></span>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="account_links">Account Links</label>
                            <input type="text" data-role="tagsinput" name="account_links" id="account_links" class="form-control" placeholder="Account Links" required value="{{ isset($footer) ? $footer->account_links : '' }}">
                            <span id="account_links_error"></span>
                        </div>
                         <div class="col-md-12 mt-2">
                            <label for="newsletter_text">Newsletter Text</label>
                            <textarea name="newsletter_text" id="newsletter_text" class="form-control" placeholder="Newsletter Text" required>{!! isset($footer) ? $footer->newsletter_text : '' !!}</textarea>
                            <span id="newsletter_text_error"></span>
                        </div>
                        <div class="col-md-12 text-right mt-3">
                           <button type="reset" class="btn btn-dark rounded-0 mr-3">Cancle</button>
                           <button type="submit" class="btn btn-success rounded-0">Submit</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection @push('js')
<script>
    let icons = "{{ isset($footer) ? $footer->icons : '' }}";
    let isEdit = "{{ isset($footer) ? 'true' : 'false' }}";
    let array = [];
    if(icons) {
        array = icons.split(",");
    }
    $("select option").each(function(i,o) { 
        if($(o).val() == array[i]) {
            $(o).prop("selected", "selected");
        }
    });

    if(isEdit) {
        $("#logo").removeAttr("required");
    }

   $(function() {
        let errors = {!! isset($errors) ? json_encode($errors->all()) : null !!};
        if(errors) {
            for(error of errors) {
                toastr.error(error);
            }
        }

        let success = "@if(Session::has('success')) {{ Session::get('success') }} @endif";
        if(success) {
            toastr.success(success);
        }

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("#addfooter").validate({
            ignore: [],
            ignore: ":hidden:not(.textarea),.note-editable.panel-body",
            errorPlacement: function(error, element) {
                if (element.attr("name") == "logo")
                    error.appendTo('#logo_error');
                if  (element.attr("name") == "icons[]" )
                    error.appendTo('#icons_error');
                if  (element.attr("name") == "email" )
                    error.appendTo('#email_error');
                if  (element.attr("name") == "phone" )
                    error.appendTo('#phone_error');
                if  (element.attr("name") == "address" )
                    error.insertBefore('#address_error');
                if  (element.attr("name") == "account_links" )
                    error.insertBefore('#account_links_error');
                if  (element.attr("name") == "information_links" )
                    error.insertBefore('#information_links_error');
                if  (element.attr("name") == "information_links" )
                    error.insertBefore('#information_links_error');
                if  (element.attr("name") == "newsletter_text" )
                    error.insertBefore('#newsletter_text_error');
                // else
                //     error.insertAfter(element);
            }
        });

        $('#icons').change(function(){
            $("#icons").valid()
        });
        $('#account_links').change(function(){
            $("#account_links").valid()
        });
        $('#information_links').change(function(){
            $("#information_links").valid()
        });

   });
</script> @endpush @push('css')
<style>
   #loader {display: none;: fixed;: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999;
   background: url('/img/loader3.gif') 50% 50% no-repeat rgb(10, 10, 10);
   opacity: .8;
   }
   .bootstrap-tagsinput .badge {margin: 2px 2px;}
</style>
@endpush

