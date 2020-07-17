@extends('layouts.app')

@section('content')

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="./home.html"><i class="fa fa-home"></i> Home</a>
                        <a href="./shop.html">Shop</a>
                        <span>Detail</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('layouts.inc.filter_product')
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-pic-zoom">
                                <img class="product-big-img" src="{{ asset($product->product_image->product_image_url) }}" alt="">
                                <div class="zoom-icon">
                                    <i class="fa fa-search-plus"></i>
                                </div>
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
                                    <div class="pt active" data-imgbigurl="{{ asset($product->product_image->product_image_url) }}"><img
                                            src="{{ asset($product->product_image->product_image_url) }}" alt="">
                                    </div>
                                    @if (isset($product->product_preview_images))
                                        @foreach ($product->product_preview_images as $prev)
                                        <div class="pt" data-imgbigurl="{{ asset($prev->product_preview_image_url) }}">
                                            <img src="{{ asset($prev->product_preview_image_url) }}" alt="">
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form id="addcartform">
                                <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">
                                <div class="product-details">
                                    <div class="pd-title">
                                        <span>{{ $product->title ?? '' }}</span>
                                        <h4 class="text-gray">{{ $product->sub_title ?? '' }}</h4>
                                        <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a>
                                    </div>
                                    <div class="pd-rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <span>(5)</span>
                                    </div>
                                    <div class="pd-desc">
                                        <h4>₹{{ $product->selling_price ?? '' }}.00
                                        <span>₹{{ $product->original_price }}</span>
                                        <span style="font-size: 20px !important;color: black;text-decoration: none;">({{ $product->discount }}% Off)</span>
                                        </h4>
                                    </div>
                                    <div class="pd-color">
                                        <h6 class="mt-10">Color</h6>
                                        <div class="pd-size-choose">
                                            @foreach ($product->productColors as $k => $color)
                                                <div class="cc-item">
                                                    <input type="radio" name="color" id="sm-color-{{ $k }}" value="{{ $color->color }}" {{ $color->color == $product->product_color ? 'checked' : '' }}>
                                                    <label for="sm-color-{{ $k }}" class="{{ $color->color == $product->product_color ? 'active' : '' }}">
                                                        <i class="fa fa-circle" style="color: {{ $color->code }};font-size:23px" aria-hidden="true"></i>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="pd-color">
                                        <h6 class="mt-10">Size</h6>
                                        <div class="pd-size-choose">
                                            @foreach (Helper::explode($product->size) as $k => $size)
                                                <div class="sc-item">
                                                    <input type="radio" name="size" id="sm-size-{{ $k }}" value="{{ $size }}" {{ $size == $product->product_size ? 'checked' : '' }}>
                                                    <label for="sm-size-{{ $k }}" class="{{ $size == $product->product_size ? 'active' : '' }}">{{ $size }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <span class="dec qtybtn">-</span>
                                            <input type="text" name="quantity" value="1">
                                            <span class="inc qtybtn">+</span>
                                        </div>
                                        <button type="submit" id="addToCart" class="primary-btn pd-cart" style="border: none;">
                                            Add To Cart
                                        </button>
                                    </div>
                                    <ul class="pd-tags">
                                        <li><span>CATEGORIES</span>: {{ $product->category->category ?? '' }}, {{ $product->sub_category->sub_category ?? '' }}</li>
                                        <li><span>TAGS</span>: {{ $product->tags ?? '' }}</li>
                                        <li><span>MATERIAL</span>: {{ $product->material ?? '' }}</li>
                                    </ul>
                                    <div class="pd-share">
                                        <div class="p-code">Sku : 00012</div>
                                        <div class="pd-social">
                                            <a href="#"><i class="ti-facebook"></i></a>
                                            <a href="#"><i class="ti-twitter-alt"></i></a>
                                            <a href="#"><i class="ti-linkedin"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="product-tab">
                        <div class="tab-item">
                            <ul class="nav" role="tablist">
                                <li>
                                    <a class="active" data-toggle="tab" href="#tab-1" role="tab">DESCRIPTION</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-2" role="tab">SPECIFICATIONS</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-3" role="tab">Customer Reviews (02)</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-item-content">
                            <div class="tab-content">
                                <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                    <div class="product-content">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <h5>Introduction</h5>
                                                <p>{!! $product->description ?? '' !!}</p>
                                                <h5>Features</h5>
                                                <p>{!! $product->product_details !!}</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <img src="{{ asset($product->product_image->product_image_url) }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                    <div class="specification-table">
                                        <table>
                                            <tr>
                                                <td class="p-catagory">Customer Rating</td>
                                                <td>
                                                    <div class="pd-rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <span>(5)</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Price</td>
                                                <td>
                                                    <div class="p-price">₹{{ $product->selling_price ?? '' }}.00</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Add To Cart</td>
                                                <td>
                                                    <div class="cart-add">+ add to cart</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Availability</td>
                                                <td>
                                                    <div class="p-stock">{{ $product->total_in_stock }} in stock</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Weight</td>
                                                <td>
                                                    <div class="p-weight">{{ $product->weight ?? 'NA' }}kg</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Size</td>
                                                <td>
                                                    <div class="p-size">{{ $product->product_size ?? '' }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Color</td>
                                                <td><span>{{ $product->product_color ?? '' }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Sku</td>
                                                <td>
                                                    <div class="p-code">00012</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                    <div class="customer-review-option">
                                        <h4>2 Comments</h4>
                                        <div class="comment-option">
                                            <div class="co-item">
                                                <div class="avatar-pic">
                                                    <img src="{{ asset('img/product-single/avatar-1.png') }}" alt="">
                                                </div>
                                                <div class="avatar-text">
                                                    <div class="at-rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <h5>Brandon Kelley <span>27 Aug 2019</span></h5>
                                                    <div class="at-reply">Nice !</div>
                                                </div>
                                            </div>
                                            <div class="co-item">
                                                <div class="avatar-pic">
                                                    <img src="{{ asset('img/product-single/avatar-2.png') }}" alt="">
                                                </div>
                                                <div class="avatar-text">
                                                    <div class="at-rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <h5>Roy Banks <span>27 Aug 2019</span></h5>
                                                    <div class="at-reply">Nice !</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="personal-rating">
                                            <h6>Your Ratind</h6>
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>
                                        </div>
                                        <div class="leave-comment">
                                            <h4>Leave A Comment</h4>
                                            <form action="#" class="comment-form">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="Name">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="Email">
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <textarea placeholder="Messages"></textarea>
                                                        <button type="submit" class="site-btn">Send message</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->

    <!-- Related Products Section End -->
    <div class="related-products spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (isset($relatedProducts))
                    @foreach ($relatedProducts as $product)
                    <div class="col-lg-3 col-sm-6">
                        <div class="product-item">
                            <div class="pi-pic">
                                <img src="{{ asset($product->product_image->product_image_url) }}" alt="">
                                <div class="sale">Sale</div>
                                <div class="icon">
                                    <i class="icon_heart_alt"></i>
                                </div>
                                <ul>
                                    <li class="w-icon active"><a href="javascript:;" onclick="addToCart({{$product->id}},1,'{{ $product->product_color}}','{{ $product->product_size}}')"><i class="icon_bag_alt"></i></a></li>
                                    <li class="quick-view">
                                        <a href="{{ route('product.details', [$product->id,Helper::slug($product->sub_title)]) }}">
                                            + Quick View
                                        </a>
                                    </li>
                                    <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                                </ul>
                            </div>
                            <div class="pi-text">
                                <div class="catagory-name">{{ $product->sub_category->sub_category ?? '' }}</div>
                                <a href="#">
                                    <h6>{{ $product->sub_title ?? '' }}</h6>
                                </a>
                                <div class="product-price">
                                    ₹{{ $product->selling_price }}.00
                                    <span>₹{{ $product->original_price }}.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- Related Products Section End -->
@endsection

@push('js')
<script src="{{ asset('js/manual/addtocartsingle.js') }}"></script>
<script>
    $(() => {
        $("#addcartform").on("submit", (e) => {
            e.preventDefault();
            // Submit Form data using ajax
            $.ajax({
                url: "{{ route('addcart') }}",
                method: "POST",
                data: $("#addcartform").serialize(),
                headers: {"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    let url;
                    if(response) {
                        url = '{{ route("cart.notifications", ":id") }}';
                        url = url.replace(':id', response.cart.id);
                        $.ajax({
                            url,
                            method: "GET",
                            success: function(res) {
                                let totalPrice=0, count=0;
                                for(data in res.items) {
                                    totalPrice += res.items[data].price;
                                    count++;
                                }
                                $("#select-total-price").text(totalPrice);
                                $(".cart-price").text(totalPrice);
                                $("#icon_bag_total").text(count);
                            },
                            error: function(reject) {
                                console.log(reject);
                            }
                        });
                    }
                    if(response) {
                        toastr.success(response.success);
                    }

                },
                error: function(reject) {
                    $.each(reject.responseJSON.errors, function (key, item)
                    {
                        toastr.error(item);
                    });
                }
            });
        })
    })
</script>
@endpush
