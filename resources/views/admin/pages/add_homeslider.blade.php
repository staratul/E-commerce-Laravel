@extends('admin.layouts.master') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div id="loader"></div>
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Slider</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route("home") }}">Dashboard</a></li>
               <li class="breadcrumb-item active">Manage Slider</li>
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
   <div class="container-fluid">
      <div class="row">
         <a href="{{ route('admin.home.slider') }}" class="btn btn-light ml-2 py-2">Back</a>
         <div class="col-md-12 my-3">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
               <div class="card-header">
                  <h3 class="card-title">Manage Home Slider</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                     <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                  </div>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <form action="{{ route('add.home.slider') }}" method="POST" id="addHomeSlider">
                     @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Category</label>
                              <select class="form-control select2bs4" name="category_id" id="category_id" style="width: 100%;" required>
                                 <option selected="selected" value="">Select Category</option>
                                 @foreach ($categories as $category)
                                 <option value="{{ $category->id }}">{{ $category->category }}</option>
                                 @endforeach
                              </select>
                              <span id="category_id_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Tags</label>
                              <select class="select2bs4" multiple="multiple" name="tags" id="tags" data-placeholder="Select Tags" style="width: 100%;" multiple required>
                              </select>
                              <span id="tags_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="title">Title</label>
                              <input type="text" class="form-control" name="title" placeholder="Title" required>
                              <span id="title_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="offer">Offer</label>
                              <input type="number" min="1" max="99" class="form-control" name="offer" placeholder="Offer" required>
                              <span id="offer_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="image">Select Image</label>
                              <input class="btn btn-info form-control-file" type="file" accept="image/jpg, image/jpeg, image/png, image/gif" name="image" id="image" required>
                              <span id="image_error"></span>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="text">Sort Text</label>
                              <input id="text" type="hidden" name="content">
                              <trix-editor input="text"></trix-editor>
                           </div>
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
   $(function() {
        $("#category_id").on("change", () => {
            $("#category_id").valid();
            let categories,category_id,category,tags, option = "";
            $("#tags").html(option);
            categories = {!! isset($categories) ? $categories : [] !!};
            category_id = $("#category_id").val();
            category = categories.filter(cat => cat.id === Number(category_id));
            if(category[0].tag) {
                tags = category[0].tag.tags.split(",");
                for(tag of tags) {
                    option += `<option value="${tag}">${tag}</option>`;
                }
            }
            $("#tags").append(option);
        });

        $('#tags').change(function(){
            $("#tags").valid()
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        $("#addHomeSlider").validate({
            ignore: [],
            ignore: ":hidden:not(.textarea),.note-editable.panel-body",
            errorPlacement: function(error, element) {
                if (element.attr("name") == "category_id")
                    error.appendTo('#category_id_error');
                if  (element.attr("name") == "tags" )
                    error.appendTo('#tags_error');
                if  (element.attr("name") == "title" )
                    error.appendTo('#title_error');
                if  (element.attr("name") == "offer" )
                    error.appendTo('#offer_error');
                if  (element.attr("name") == "image" )
                    error.insertBefore('#image_error');
                // else
                //     error.insertAfter(element);
            }
        })
   });
</script> @endpush @push('css')
<style>
   #loader {
   display: none;
   position: fixed;
   left: 0px;
   top: 0px;
   width: 100%;
   height: 100%;
   z-index: 9999;
   background: url('/img/loader3.gif') 50% 50% no-repeat rgb(10, 10, 10);
   opacity: .8;
   }
</style>
@endpush

