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
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th class="p-name">Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th><i class="ti-close"></i></th>
                                </tr>
                            </thead>
                            <tbody id="totalCart">
                                @if (Session::has('shoppingcart') && count(Session::get('shoppingcart')->items) > 0)
                                    @foreach (Session::get('shoppingcart')->items as $cart)
                                        <tr>
                                            <td class="cart-pic first-row"><img src="{{ $cart["item"]->product_image->product_image_url }}" alt=""></td>
                                            <td class="cart-title first-row">
                                                <h6>{{ $cart["item"]->sub_title }}</h6>
                                            </td>
                                            <td class="p-price first-row">₹{{ $cart["item"]->selling_price }}.00</td>
                                            <td class="qua-col first-row">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <span class="dec qtybtn" onclick="qtyDecrease({{ $cart['item']->id }})">-</span>
                                                        <input type="text" id="qtyTotal" value="{{ $cart["qty"] }}">
                                                        <span class="inc qtybtn" onclick="qtyIncrease({{ $cart['item']->id }})">+</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="total-price first-row" id="priceintoqty-{{ $cart['item']->id }}">₹{{ $cart["price"] }}.00</td>
                                            <td class="close-td first-row">
                                                <button onclick="removeCartItem({{ $cart['item']->id }}, {{ $cart['item']->cart->id }})" type="button" class="btn btn-xs btn-danger"><i class="ti-close"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">
                                            <img src="{{ asset('img/cart-page/empty-cart.png') }}" alt="empty-cart">
                                            <br>
                                            <a href="{{ url('shop') }}" class="btn btn-primary rounded-0">ADD ITEM</a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="cart-buttons">
                                <a href="#" class="primary-btn continue-shop">Continue shopping</a>
                                <a href="#" class="primary-btn up-cart">Update cart</a>
                            </div>
                            <div class="discount-coupon">
                                <h6>Discount Codes</h6>
                                <form action="#" class="coupon-form">
                                    <input type="text" placeholder="Enter your codes">
                                    <button type="submit" class="site-btn coupon-btn">Apply</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-lg-4">
                            <div class="proceed-checkout">
                                <ul>
                                    @if (Session::has('shoppingcart'))
                                        <li class="subtotal">TotalQty <span id="totalqty">{{ Session::get('shoppingcart')->totalQty }}</span></li>
                                        <li class="subtotal">Subtotal <span id="subtotal">₹{{ Session::get('shoppingcart')->totalPrice }}.00</span></li>
                                        <li class="cart-total">Total <span id="carttotal">₹{{ Session::get('shoppingcart')->totalPrice }}.00</span></li>
                                    @endif
                                </ul>
                                <a href="{{ url('checkout') }}" class="proceed-btn">PROCEED TO CHECK OUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
@endsection

@push('js')
<script>
    $(() => {
        removeCartItem = (id, cart_id) => {
            $.ajax({
                url: "{{ route('remove.cartitem') }}",
                method: "POST",
                data: {id,cart_id},
                headers: {"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    let html="",count=0;
                    console.log(response);
                    if(response.cart) {
                        console.log(response.cart);
                        $("#totalCart").html(html);
                        if(response.cart.totalPrice != 0) {
                            for(i in response.cart.items) {
                                count++;
                                html =  `<tr><td class="cart-pic first-row"><img src="${response.cart.items[i].item.product_image.product_image_url}" alt=""></td>
                                    <td class="cart-title first-row">
                                    <h6>${response.cart.items[i].item.sub_title}</h6>
                                    </td><td class="p-price first-row">₹${response.cart.items[i].item.selling_price}.00</td>
                                    <td class="qua-col first-row">
                                    <div class="quantity"><div class="pro-qty">
                                    <span class="dec qtybtn" onclick="qtyDecrease(${response.cart.items[i].item.id})">-</span>
                                    <input type="text" id="qtyTotal" value="${response.cart.items[i].qty}">
                                    <span class="inc qtybtn" onclick="qtyIncrease(${response.cart.items[i].item.id})">+</span>
                                    </div></div></td>
                                    <td class="total-price first-row" id="priceintoqty-${response.cart.items[i].item.id}">₹${response.cart.items[i].price}.00</td>
                                    <td class="close-td first-row">
                                    <button onclick="removeCartItem(${response.cart.items[i].item.id})" type="button" class="btn btn-xs btn-danger"><i class="ti-close"></i></button>
                                    </td></tr>`;

                                $("#totalCart").append(html);
                            }
                            $("#icon_bag_total").text(count);
                            $(".cart-price").text('₹'+response.cart.totalPrice);
                            $("#totalqty").text(response.cart.totalQty);
                            $("#subtotal").text('₹'+response.cart.totalPrice);
                            $("#carttotal").text('₹'+response.cart.totalPrice);
                        } else {
                            $("#totalqty").text(0);
                            $("#icon_bag_total").text(count);
                            $(".cart-price").text('₹'+response.cart.totalPrice);
                            $("#subtotal").text('₹0.00');
                            $("#carttotal").text('₹0.00');
                            html = `<tr><td colspan="5">
                                    <img src="{{ asset('img/cart-page/empty-cart.png') }}" alt="empty-cart"><br>
                                    <a href="{{ url('shop') }}" class="btn btn-primary rounded-0">ADD ITEM</a></td></tr>`;
                            $("#totalCart").append(html);
                        }
                    }
                    var proQty = $('.pro-qty');
                    proQty.on('click', '.qtybtn', function () {
                        var $button = $(this);
                        var oldValue = $button.parent().find('input').val();
                        if ($button.hasClass('inc')) {
                            if(oldValue < 10) {
                                var newVal = parseFloat(oldValue) + 1;
                            } else {
                                newVal = 10;
                            }
                        } else {
                            // Don't allow decrementing below zero
                            if (oldValue > 1) {
                                var newVal = parseFloat(oldValue) - 1;
                                // console.log(newVal);
                            } else {
                                newVal = 1;
                            }
                        }
                        $button.parent().find('input').val(newVal);
                    });
                    toastr.success(response.success);
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        }

        qtyDecrease = (id) => {
            let qty;
            qty = Number($("#qtyTotal").val());
            $.ajax({
                url: "{{ route('decrease.cartquantity') }}",
                method: "POST",
                data: {id,qty},
                headers: {"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    console.log(response);
                    $(".cart-price").text('₹'+response.cart.totalPrice);
                    $("#totalqty").text(response.cart.totalQty);
                    $("#subtotal").text('₹'+response.cart.totalPrice);
                    $("#carttotal").text('₹'+response.cart.totalPrice);
                    $("#priceintoqty-"+id).text('₹'+response.item.price);
                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        }

        qtyIncrease = (id) => {
            let qty;
            qty = Number($("#qtyTotal").val());
            console.log(qty);
            $.ajax({
                url: "{{ route('increase.cartquantity') }}",
                method: "POST",
                data: {id,qty},
                headers: {"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    console.log(response);
                    $(".cart-price").text('₹'+response.cart.totalPrice);
                    $("#totalqty").text(response.cart.totalQty);
                    $("#subtotal").text('₹'+response.cart.totalPrice);
                    $("#carttotal").text('₹'+response.cart.totalPrice);
                    $("#priceintoqty-"+id).text('₹'+response.item.price);

                },
                error: function(reject) {
                    console.log(reject);
                }
            });
        }
    });
</script>
@endpush
