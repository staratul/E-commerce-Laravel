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

    <!-- Shopping Cart Section Begin -->
    <section class="checkout-section spad">
        <div class="container">
            <form action="#" class="checkout-form" id="checkout-form">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="checkout-content">
                            <a href="{{ route('login') }}" class="content-btn">Click Here To Login</a>
                        </div>
                        <h4>Biiling Details</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="fir">Name<span>*</span></label>
                                <input type="text" id="fir" name="name" placeholder="Name" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="address-street">Address<span>*</span></label>
                                <input type="text" name="address-street" id="address-street" class="street-first" placeholder="Address(House No, Building, Street)" required>
                                <input type="text" name="area" id="area" placeholder="Address(Area)" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="pincode">Pin Code</label>
                                <input type="text" id="pincode" name="pincode" placeholder="Pin Code" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="city">Town / City<span>*</span></label>
                                <input type="text" id="city" name="city" placeholder="Town / City" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Email Address<span>*</span></label>
                                <input type="text" id="email" name="email" placeholder="Email Address" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="phone">Phone<span>*</span></label>
                                <input type="text" id="phone" name="phone" placeholder="Phone" required>
                            </div>
                            <div class="col-lg-12">
                                <div class="create-item">
                                    <label for="acc-create">
                                        Create an account?
                                        <input type="checkbox" id="acc-create">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="checkout-content">
                            <input type="text" placeholder="Enter Your Coupon Code">
                        </div>
                        <div class="place-order">
                            <h4>Your Order</h4>
                            <div class="order-total">
                                <ul class="order-table">
                                    <li>Product <span>Total</span></li>
                                    @if(isset($products))
                                        @foreach ($products->items as $product)
                                            <li class="fw-normal">
                                                {{ Str::limit($product['item']->sub_title, 30, '...') }} 
                                                x {{ $product['qty'] }} 
                                                <span>${{ $product['price'] }}.00</span>
                                            </li>
                                        @endforeach
                                    @endif
                                    {{-- <li class="fw-normal">Combination x 1 <span>$60.00</span></li>
                                    <li class="fw-normal">Combination x 1 <span>$60.00</span></li>
                                    <li class="fw-normal">Combination x 1 <span>$120.00</span></li> --}}
                                    <li class="fw-normal">Subtotal <span>${{ $products->totalPrice }}.00</span></li>
                                    <li class="total-price">Total <span>${{ $products->totalPrice }}.00</span></li>
                                </ul>
                                <div class="payment-check">
                                    <div class="pc-item">
                                        <label for="pc-check">
                                            Cheque Payment
                                            <input type="checkbox" id="pc-check">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="pc-item">
                                        <label for="pc-paypal">
                                            Paypal
                                            <input type="checkbox" id="pc-paypal">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="order-btn">
                                    <button type="submit" class="site-btn place-btn">Place Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
@endsection


@push('js')
    <script>
        $(() => {
            $("#checkout-form").validate();
            $("#checkout-form").on("submit", (e) => {   
                $(".error").css({"color":"red"});
                $(".checkout-form input").css("margin-bottom", "0px");
            });
        });
    </script>
@endpush