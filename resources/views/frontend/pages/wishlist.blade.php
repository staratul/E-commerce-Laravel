@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="{{ url('shop') }}">Shop</a>
                        <span>Check Out</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->
    <main>
        <div class="container">
        <section>
            <div class="row">
                @if (isset($products))
                    @foreach ($products as $product)
                    <div class="col-md-4 mb-5">
                        <!-- Card -->
                        <div class="">
                        <div class="view zoom overlay z-depth-2 rounded">
                            <img class="img-fluid w-100"
                            src="{{ asset($product->product_image->product_image_url) }}" alt="Sample">
                        </div>
                        <div class="text-center pt-4">
                            <h5>{{ Str::limit($product->sub_title, 30) }}</h5>
                            <p class="mb-2 text-muted text-uppercase small">Shirts</p>
                            <ul class="rating">
                                <li>
                                    <i class="fa fa-star fa-sm text-primary"></i>
                                </li>
                                <li>
                                    <i class="fa fa-star fa-sm text-primary"></i>
                                </li>
                                <li>
                                    <i class="fa fa-star fa-sm text-primary"></i>
                                </li>
                                <li>
                                    <i class="fa fa-star fa-sm text-primary"></i>
                                </li>
                                <li>
                                    <i class="fa fa-star fa-sm text-primary"></i>
                                </li>
                            </ul>
                            <hr>
                            <h6 class="mb-3">₹{{ $product->selling_price }}.00</h6>
                            <button type="button" onclick="moveToCart({{$product->id}},1,'{{ $product->product_color}}','{{ $product->product_size}}')" class="btn btn-primary btn-sm mr-1 mb-2"><i
                                class="fa fa-shopping-cart pr-2"></i>Add to cart</button>
                            <button type="button" class="btn btn-light btn-sm mr-1 mb-2"><i
                                class="fa fa-info-circle pr-2"></i>Details</button>
                            <button type="button" onclick="removeFromWishlist({{$product->id}})" class="btn btn-dark btn-sm mr-1 mb-2 material-tooltip-main"
                            data-toggle="tooltip" data-placement="top" title="Remove from wishlist"><i
                                class="fa fa-times"></i></button>
                        </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </section>
        </div>
    </main>

@endsection

@push('js')
    <script src="{{ asset('js/manual/addtocartsingle.js') }}"></script>
    <script>
        $(() => {
            $('.material-tooltip-main').tooltip({
                template: '<div class="tooltip md-tooltip-main"><div class="tooltip-arrow md-arrow"></div><div class="tooltip-inner md-inner-main"></div></div>'
            });
        });
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('css/manual/frontend.css') }}">
@endpush
