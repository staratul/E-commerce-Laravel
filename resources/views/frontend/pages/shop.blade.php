@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    @include('layouts.inc.filter_product')
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-show-option">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <div class="select-option">
                                    <select class="sorting">
                                        <option value="">Default Sorting</option>
                                    </select>
                                    <select class="p-show">
                                        <option value="">Show:</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 text-right">
                                <p>Show 01- 09 Of 36 Product</p>
                            </div>
                        </div>
                    </div>
                    <div class="product-list">
                        <form id="addcartform">
                            <div class="row"> 
                                @if (isset($products))
                                    @foreach ($products as $product)
                                    <div class="col-lg-4 col-sm-6">
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
                        </form>
                    </div>
                    <div class="loading-more">
                        <i class="icon_loading"></i>
                        <a href="#">
                            Loading More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->
@endsection

@push('js')
<script>
    $(() => {
        addToCart = (product_id,quantity,color,size) => {
            // Submit Form data using ajax
            $.ajax({
                url: "{{ route('addcart') }}",
                method: "POST",
                data:{
                    product_id,quantity,size,color
                },
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
        }
    });
</script>
@endpush
