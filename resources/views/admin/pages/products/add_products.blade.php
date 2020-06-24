@extends('admin.layouts.master') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div id="loader"></div>
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Product</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route("home") }}">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="{{ route("products.index") }}">Manage Products</a></li>
               <li class="breadcrumb-item active">Add Product</li>
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
         <a href="{{ route('products.index') }}" class="btn btn-light ml-2 py-2">Back</a>
         <div class="col-md-12 my-3">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
               <div class="card-header">
                  <h3 class="card-title">Add Product</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                     <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                  </div>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <form action="{{ route('products.store') }}" method="POST" id="addProductForm" enctype="multipart/form-data">
                     @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                               <input type="hidden" name="home_slider_id" value="{{ isset($homeSlider) ? $homeSlider->id : '' }}">
                              <label>Category</label>
                              <select class="form-control select2bs4" name="category_id" id="category_id" style="width: 100%;" >
                                 <option selected="selected" value="">Select Category</option>
                                 @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"

                                        >
                                        {{ $category->category }}
                                    </option>
                                 @endforeach
                              </select>
                              <span id="category_id_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Tags</label>
                              <select class="select2bs4" multiple="multiple" name="tags[]" id="tags" data-placeholder="Select Tags" style="width: 100%;">
                              </select>
                              <span id="tags_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="title">Title</label>
                              <input type="text" class="form-control" name="title" placeholder="Title" value="">
                              <span id="title_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="sub_title">Sub Title</label>
                              <input type="text" class="form-control" name="sub_title" placeholder="Sub Title" value="">
                              <span id="sub_title_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="original_price">Original Price</label>
                              <input type="number" min="1" class="form-control" name="original_price" placeholder="Original Price" value="">
                              <span id="original_price_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="discount">Discount</label>
                              <input type="number" min="1" max="99" class="form-control" name="discount" placeholder="Discount" value="">
                              <span id="discount_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="selling_price">Selling Price</label>
                              <input type="number" min="1" class="form-control" name="selling_price" placeholder="Selling Price" value="" readonly>
                              <span id="selling_price_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="color">Color</label>
                              <input type="text" class="form-control" name="color" placeholder="Color" value="">
                              <span id="color_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="weight">Weight (In KG)</label>
                              <input type="number" min="1" class="form-control" name="weight" placeholder="Weight (In KG)" value="">
                              <span id="weight_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="free_delivery_price">Free Delivery Price</label>
                              <input type="number" min="1" class="form-control" name="free_delivery_price" placeholder="Free Delivery Price" value="">
                              <span id="free_delivery_price_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="stock">In Stock</label>
                              <input type="number" min="1" class="form-control" name="stock" placeholder="In Stock" value="">
                              <span id="stock_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="seller">Seller</label>
                              <input type="text" class="form-control" name="seller" placeholder="Seller" value="">
                              <span id="seller_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="brand">Brand</label>
                              <input type="text" class="form-control" name="brand" placeholder="Brand" value="">
                              <span id="brand_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="image">Select Image</label>
                              <input class="btn btn-info form-control-file" type="file" accept="image/jpg, image/jpeg, image/png, image/gif" name="image" id="image" >
                              <span id="image_error"></span>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="product_details">Product Details</label>
                              <input id="product_details" type="hidden" name="product_details" value="">
                              <trix-editor input="product_details"></trix-editor>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="description">Sort description</label>
                              <input id="description" type="hidden" name="description" value="">
                              <trix-editor input="description"></trix-editor>
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
            let categories,category_id,category,tags, option = "", sliderTags, isMatch = '';
            $("#tags").html(option);
            categories = {!! isset($categories) ? $categories : [] !!};
            sliderTags = "{!! isset($homeSlider) ? $homeSlider->tags : '' !!}".split(',');
            category_id = $("#category_id").val();
            category = categories.filter(cat => cat.id === Number(category_id));
            if(category.length > 0) {
                if(category[0].tag) {
                    tags = category[0].tag.tags.split(",");
                    for(tag of tags) {
                        for(st of sliderTags) {
                            if(st == tag) {
                                isMatch = 'selected';
                            }
                        }
                        option += `<option ${isMatch} value="${tag}">${tag}</option>`;
                    }
                }
            }
            $("#tags").append(option);
        }).change();

        $('#tags').change(function(){
            $("#tags").valid()
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("#addProductForm").validate({
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
        });
   });
</script> @endpush @push('css')
<style>
   #loader {display: none;: fixed;: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999;
   background: url('/img/loader3.gif') 50% 50% no-repeat rgb(10, 10, 10);
   opacity: .8;
   }
</style>
@endpush

