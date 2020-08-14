
    <!-- Man Banner Section Begin -->
    <section class="man-banner spad">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="product-large set-bg m-large" data-setbg="{{ asset('img/products/man-large.jpg') }}">
                        <h2>Men’s</h2>
                        <a href="#">Discover More</a>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="filter-control">
                        <ul>
                            <li class="active">Clothings</li>
                            <li>HandBag</li>
                            <li>Shoes</li>
                            <li>Accessories</li>
                        </ul>
                    </div>
                    <div class="product-slider owl-carousel">
                        @if (isset($products))
                            @foreach ($products as $product)
                                @if ($product->category->category == 'Men’s Clothing')
                                    <div class="product-item">
                                        <div class="pi-pic">
                                            <img src="{{ $product->product_image->product_image_url ?? 'public/img/not-available.jpg' }}" alt="" style="z-index: initial;">
                                            @php $count = 0; @endphp
                                            @if (isset($wishlists))
                                                @foreach ($wishlists as $wish)
                                                    @if((int)$wish["product_id"] == $product->id)
                                                    @php $count = 1; @endphp
                                                        <div class="icon" onclick="addToWishlist({{$product->id}})">
                                                            <i class="fa fa-heart text-danger heart_icon_{{$product->id}}" aria-hidden="true"></i>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                                @if($count === 0)
                                                    <div class="icon" onclick="addToWishlist({{$product->id}})">
                                                        <i class="fa fa-heart-o heart_icon_{{$product->id}}" aria-hidden="true"></i>
                                                    </div>
                                                @endif
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
                                                ₹ {{ $product->selling_price ?? '' }}.00
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Man Banner Section End -->

@push('js')
    <script src="{{ asset('js/manual/addtocartsingle.js') }}"></script>
@endpush
