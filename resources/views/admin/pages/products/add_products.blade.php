@extends('admin.layouts.master') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div id="loader"></div>
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ isset($product) ? 'Edit Product - '.$product->title : 'Add Product' }}</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route("home") }}">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="{{ route("products.index") }}">Manage Products</a></li>
               <li class="breadcrumb-item active">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</li>
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
                  <h3 class="card-title">{{ isset($product) ? 'Edit Product - '.$product->title : 'Add Product' }}</h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                     <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                  </div>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                   @include('common.messages')
                  <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" id="addProductForm" enctype="multipart/form-data">
                     @csrf
                     @if(isset($product))
                        @method('PUT')
                     @endif
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                               <input type="hidden" name="product_id" value="">
                              <label>Category</label>
                              <select class="form-control select2bs4" name="category_id" id="category_id" style="width: 100%;" data-placeholder="Select Category">
                                 @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}
                                        >
                                        {{ $category->category }}
                                    </option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label>Tags</label>
                               <select class="select2bs4" multiple="multiple" name="tags[]" id="tags" data-placeholder="Select Tags" style="width: 100%;" required>
                               </select>
                               <span id="tags_error"></span>
                            </div>
                         </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Sub Category</label>
                              <select class="form-control select2bs4" name="sub_category_id" id="sub_category_id" data-placeholder="Select Sub Category" style="width: 100%;" required>
                              </select>
                              <span id="sub_category_id_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Available Sizes</label>
                              <select class="select2bs4" multiple="multiple" name="size[]" id="size" data-placeholder="Select Size" style="width: 100%;" required>
                              </select>
                              <span id="size_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="title">Title</label>
                              <input type="text" class="form-control" name="title" placeholder="Title" value="{{ isset($product) ? $product->title : '' }}" required>
                              <span id="title_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="sub_title">Sub Title</label>
                              <input type="text" class="form-control" name="sub_title" placeholder="Sub Title" value="{{ isset($product) ? $product->sub_title : '' }}" required>
                              <span id="sub_title_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="color">Available Color</label>
                               <select class="select2bs4" multiple="multiple" name="colors[]" id="colors" data-placeholder="Select Color" style="width: 100%;" required>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}"
                                            @if (isset($product))
                                                @foreach (Helper::explode($product->colors) as $pc)
                                                    @if($pc == $color->id)
                                                        selected
                                                    @endif
                                                @endforeach
                                            @endif
                                            >
                                            {{ $color->color }}
                                        </option>
                                    @endforeach
                               </select>
                               <span id="colors_error"></span>
                            </div>
                         </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="color">Available In State</label>
                               <select class="select2bs4" multiple="multiple" name="states[]" id="states" data-placeholder="Select State" style="width: 100%;" required>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}"
                                            @if (isset($product))
                                                @foreach (Helper::explode($product->states) as $ps)
                                                    @if($ps == $state->id)
                                                        selected
                                                    @endif
                                                @endforeach
                                            @endif
                                            >
                                            {{ $state->state }}
                                        </option>
                                    @endforeach
                                </select>
                               <span id="states_error"></span>
                            </div>
                         </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="original_price">Original Price</label>
                              <input type="number" min="1" class="form-control" name="original_price" placeholder="Original Price" id="original_price" value="{{ isset($product) ? $product->original_price : '' }}" required>
                              <span id="original_price_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="discount">Discount</label>
                              <input type="number" min="1" max="99" class="form-control" name="discount" placeholder="Discount" id="discount" value="{{ isset($product) ? $product->discount : '' }}" required>
                              <span id="discount_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="selling_price">Selling Price</label>
                              <input type="number" min="1" class="form-control" name="selling_price" placeholder="Selling Price" id="selling_price" value="{{ isset($product) ? $product->selling_price : '' }}" readonly>
                           </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                               <label for="free_delivery_price">Free Delivery Price</label>
                               <input type="number" min="1" class="form-control" name="free_delivery_price" id="free_delivery_price" placeholder="Free Delivery Price" value="{{ isset($product) ? $product->free_delivery_price : '' }}" required>
                               <span id="free_delivery_price_error"></span>
                            </div>
                         </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="weight">Weight (In KG)</label>
                              <input type="number" min="1" class="form-control" name="weight" id="weight" placeholder="Weight (In KG)" value="{{ isset($product) ? $product->weight : '' }}">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="brand">Brand</label>
                              <input type="text" class="form-control" name="brand" id="brand" placeholder="Brand" value="{{ isset($product) ? $product->brand : '' }}">
                           </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="seller_name">Seller Name</label>
                               <input type="text" class="form-control" name="seller_name" id="seller_name" placeholder="Seller Name" value="{{ isset($product) ? $product->seller_name : '' }}" required>
                               <span id="seller_name_error"></span>
                            </div>
                         </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <label for="color">Seller State</label>
                               <select class="select2bs4" name="seller_state" id="seller_state" data-placeholder="Seller State" style="width: 100%;">
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ isset($product) && $product->seller_state == $state->id ? 'selected' : '' }}
                                            >
                                            {{ $state->state }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                         </div>
                        <div class="col-md-3">
                           <div class="form-group">
                               <label for="total_in_stock">Total In Stock</label>
                               <input type="number" min="1" name="total_in_stock" id="total_in_stock" class="form-control" placeholder="Total Stock" value="{{ isset($product) ? $product->total_in_stock : '1' }}">
                           </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Product Stock</label>
                                 <button type="button" id="fill_product_stock" onclick="openProductStockModal()" class="btn btn-primary rounded-0" id="open_stock_fill">Enter Product Stocks</button><br>
                                 <span class="text-danger" id="enter_product_span_btn"></span>
                            </div>
                         </div>
                        <div class="col-sm-3 mt4">
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="pay_on_delivery" name="pay_on_delivery" {{ isset($product) && $product->pay_on_delivery == 1 ? 'checked' : '' }} value="1">
                                <label for="pay_on_delivery ml-1">
                                    Pay on delivery available
                                </label>
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mt4">
                            <div class="form-group clearfix">
                              <div class="icheck-primary d-inline">
                                <input type="checkbox" id="status"  {{ isset($product) && $product->status == 1 ? 'checked' : '' }} name="status" value="1">
                                <label for="status ml-1">
                                  Status
                                </label>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="product_image">Product Image</label>
                              <input class="btn btn-info form-control-file" type="file" accept="image/jpg, image/jpeg, image/png, image/gif" name="product_image" id="product_image" {{ isset($product) ? '' : 'required' }}>
                              <span id="product_image_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="preview_image">Product Preview Image</label>
                              <input class="btn btn-info form-control-file" type="file" accept="image/jpg, image/jpeg, image/png, image/gif" name="preview_image[]" id="preview_image" multiple="multiple">
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="product_details">Product Details</label>
                              <input id="product_details" type="hidden" name="product_details" value="{!! isset($product) ? $product->product_details : '' !!}">
                              <trix-editor input="product_details"></trix-editor>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="description">Sort description</label>
                              <input id="description" type="hidden" name="description" value="{!! isset($product) ? $product->description : '' !!}">
                              <trix-editor input="description"></trix-editor>
                           </div>
                        </div>
                        {{-- Add Product Stock Modal --}}
                        @include('admin.modals.products_modal')
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
    let sizeCouter = 0, colorConter = 0, TotalProductStock = 1;
   $(function() {

        $("#addProductForm").validate({
            ignore: [],
            ignore: ":hidden:not(.textarea),.note-editable.panel-body",
            errorPlacement: function(error, element) {
                if (element.attr("name") == "sub_category_id")
                    error.appendTo('#sub_category_id_error');
                if  (element.attr("name") == "tags[]" )
                    error.appendTo('#tags_error');
                if  (element.attr("name") == "size[]" )
                    error.appendTo('#size_error');
                if  (element.attr("name") == "title" )
                    error.appendTo('#title_error');
                if  (element.attr("name") == "sub_title" )
                    error.appendTo('#sub_title_error');
                if  (element.attr("name") == "colors[]" )
                    error.appendTo('#colors_error');
                if  (element.attr("name") == "states[]" )
                    error.appendTo('#states_error');
                if  (element.attr("name") == "original_price" )
                    error.appendTo('#original_price_error');
                if  (element.attr("name") == "discount" )
                    error.appendTo('#discount_error');
                if  (element.attr("name") == "free_delivery_price" )
                    error.appendTo('#free_delivery_price_error');
                if  (element.attr("name") == "seller_name" )
                    error.appendTo('#seller_name_error');
                if  (element.attr("name") == "product_image" )
                    error.appendTo('#product_image_error');
                // else
                //     error.insertAfter(element);
            }
        });

        $("#category_id").on("change", () => {
            $("#category_id").valid();
            let categories,category_id,category,tags,tagOption="",subCatOption="",sizeOption="",productTags,productSize,isMatch='';
            $("#tags").html(tagOption);
            $("#sub_category_id").html(subCatOption);
            $("#size").html(sizeOption);
            categories = {!! isset($categories) ? $categories : [] !!};
            productTags = "{!! isset($product) ? $product->tags : '' !!}".split(',');
            productSize = "{!! isset($product) ? $product->size : '' !!}".split(',');
            productSubCat = "{!! isset($product) ? $product->sub_category_id : '' !!}";
            category_id = $("#category_id").val();
            category = categories.filter(cat => cat.id === Number(category_id));
            if(category.length > 0) {
                if(category[0].tag) {
                    tags = category[0].tag.tags.split(",");
                    for(tag of tags) {
                        for(pt of productTags) {
                            if(pt == tag) {
                                isMatch = 'selected';
                            }
                        }
                        tagOption += `<option ${isMatch} value="${tag}">${tag}</option>`;
                        isMatch = '';
                    }
                }
                if(category[0].size) {
                    sizes = category[0].size.size.split(",");
                    for(size of sizes) {
                        for(ps of productSize) {
                            if(ps == size) {
                                isMatch = 'selected';
                            }
                        }
                        sizeOption += `<option ${isMatch} value="${size}">${size}</option>`;
                        isMatch = '';
                    }
                }
                if(category[0].sub_categories) {
                    for(subCategory of category[0].sub_categories) {
                        if(productSubCat == subCategory.id) {
                            isMatch = 'selected';
                        }
                        subCatOption += `<option ${isMatch} value="${subCategory.id}">${subCategory.sub_category}</option>`;
                        isMatch = '';
                    }
                }
            }
            $("#tags").append(tagOption);
            $("#sub_category_id").append(subCatOption);
            $("#size").append(sizeOption);
        }).change();

        $('#tags').change(function(){
            $("#tags").valid()
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("#size").on("change", () => {
            let sizes=[],html='',value='';
            $("#stock_in_size_div").html(html);
            sizes = $("#size").val();
            if(sizes.length > 0) {
                sizeStock = {!! isset($product) ? $product->product_size_stocks : 'false' !!};
                for([i,s] of sizes.entries()) {
                    if(sizeStock != false) {
                        if(sizeStock.length === 1 && i === 0) {
                            value = sizeStock[i].stock_in_size;
                        } 
                        if(sizeStock.length > 1) {
                            value = sizeStock[i].stock_in_size;
                        }
                    }
                    html += `<div class="col-md-6"><div class="form-group">
                            <label for="size">Size</label>
                            <input type="text" name="size_of_product[]" value="${s}" class="form-control" placeholder="Size" readonly></div></div>
                            <div class="col-md-6"><div class="form-group">
                            <label for="stock_in_size">Stock</label>
                            <input type="number" name="stock_of_size[]" value="${value}" class="form-control stock_of_size" placeholder="Stock"></div></div>`;
                    value = '';
                }
            } else {
                html = '<h4 class="text-gray">No size selected from the box.</h4>';
            }
            $("#stock_in_size_div").append(html);
        }).change();

        $("#colors").on("change", () => {
            let colors=[],html='',colorsName=[],names='',value='';
            $("#stock_in_color_div").html(html);
            colors = $("#colors").val()
            names = $('#colors option:selected').toArray().map(item => item.text).join();
            colorsName = names.split(',');
            if(colorsName.length > 0) {
                colorStock = {!! isset($product) ? $product->product_color_stocks : 'false' !!};
                for([i,s] of colorsName.entries()) {
                    if(colorStock != false) {
                        if(colorStock.length === 1 && i === 0) {
                            value = colorStock[i].stock_in_color;
                        } 
                        if(colorStock.length > 1) {
                            value = colorStock[i].stock_in_color;
                        }
                    }
                    html += `<div class="col-md-6"><div class="form-group">
                            <label for="color">Color</label>
                            <input type="text" name="color_of_product[]" value="${s}" class="form-control" placeholder="color" readonly></div></div>
                            <div class="col-md-6"><div class="form-group">
                            <label for="stock_in_color">Stock</label>
                            <input type="number" name="stock_of_color[]" value="${value}" class="form-control stock_of_color" placeholder="Stock"></div></div>`;
                    value = '';
                }
            } else {
                html = '<h4 class="text-gray">No color selected from the box.</h4>';
            }
            $("#stock_in_color_div").append(html);
        }).change();

        $("#size").on("change", () => {$("#size").valid();});
        $("#colors").on("change", () => {$("#colors").valid();});
        $("#sub_category_id").on("change", () => {$("#sub_category_id").valid();});
        $("#states").on("change", () => {$("#states").valid();});

        $("#discount").on('keyup', () => {
            let originalPrice, discount, totalPrice;
            originalPrice = Number($("#original_price").val());
            if(originalPrice === 0) {
                toastr.error('Enter original price before enter discount.');
                return false;
            }
            discount = Number($("#discount").val());
            totalPrice = originalPrice - ((originalPrice * discount) / 100);
            $("#selling_price").val(totalPrice);
        });

        openProductStockModal = () => {
            let totalStock;
            totalStock = Number($("#total_in_stock").val());
            TotalProductStock = totalStock;
            $(".modal_total_stock").text(totalStock);
            sizeCouter = $("#size").val().length;
            colorConter = $("#colors").val().length;
            if(totalStock <= 0 || totalStock === undefined) {
                toastr.error('Total stock must be greather than 0.');
                $("#total_in_stock").focus();
                return false;
            }
            if(sizeCouter === 0) {
                toastr.error('Select at least 1 size form the box.');
                return false;
            }
            if(colorConter === 0) {
                toastr.error('Select at least 1 color form the box');
                return false;
            }
            $("#fill_product_stock_modal").modal('show');
        }

        closeProductStockModal = () => {
            let isAdd = true;
            isAdd = {!! isset($product) ? 'false' : 'true' !!};
            if(isAdd) {
                $('.stock_of_color').each(function(){
                    $(this).val(undefined);
                });
                $('.stock_of_size').each(function(){
                    $(this).val(undefined);
                });
            }
        }

        doneProductStock = () => {
            let isValid = true, colorStock = 0, sizeStock = 0;
            $('.stock_of_color').each(function(){
                if($(this).val() === "") {
                    toastr.error("Fill all stock fill.")
                    isValid = false;
                }
                colorStock += Number($(this).val());
            });
            $('.stock_of_size').each(function(){
                if($(this).val() === "") {
                    toastr.error("Fill all stock fill.")
                    isValid = false;
                }
                sizeStock += Number($(this).val());
            });
            // Check if valid or not
            if(isValid === false) return false;
            
            // Check if stock is correct with total stock
            if(colorStock !== TotalProductStock) {
                toastr.error(`Total color stock must be = ${TotalProductStock}.`)
                return false;
            }
            if(sizeStock !== TotalProductStock) {
                toastr.error(`Total size stock must be = ${TotalProductStock}.`)
                return false;
            }
            $("#fill_product_stock_modal").modal('hide');
        }

        $("#addProductForm").on("submit", () => {
            let isValid = true,sizeStock=0,colorStock=0;
            TotalProductStock = Number($("#total_in_stock").val());
            $('.stock_of_color').each(function(i, o){
                sizeStock += Number($(this).val());
                if($(this).val() === "") isValid = false;
            });
            $('.stock_of_size').each(function(){
                colorStock += Number($(this).val());
                if($(this).val() === "") isValid = false;
            });
            // Check if valid or not
            if(isValid === false) {
                toastr.error("Fill product stock. Click Enter Product Stock Button");
                $("#enter_product_span_btn").text("Click me!");
                return false;
            } else {
                $("#enter_product_span_btn").text("");
            }
            if(sizeStock !== TotalProductStock) {
                toastr.error(`Total size stock must be = ${TotalProductStock}.`)
                return false;
            }
            if(colorStock !== TotalProductStock) {
                toastr.error(`Total color stock must be = ${TotalProductStock}.`)
                return false;
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

