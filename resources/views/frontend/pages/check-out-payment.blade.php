@extends('layouts.pay')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-9 mb-5">
                <h2>Choose payment mood</h2>
                <div class="tab mt-4 paymentmode">
                    <button class="tablinks" onclick="openCity(event, 'pay_on_delivery')" id="defaultOpen">PAY ON DELIVERY</button>
                    <button class="tablinks" onclick="openCity(event, 'cd_card')">CREDIT/DEBIT CARD</button>
                    <button class="tablinks" onclick="openCity(event, 'upi_pay')">PAYTM/PHONEPE/GOOGLE PAY</button>
                </div>

                <div id="pay_on_delivery" class="tabcontent mt-4">
                    <h3>PAY ON DELIVERY</h3>
                    @include('common.messages')
                    <form action="{{ route('pay.on.delivery', $userDetail->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_type" id="2">
                        <div class="form-group">
                            <label for="captcha">Captcha</label>
                              {!! NoCaptcha::renderJs() !!}
                              {!! NoCaptcha::display() !!}
                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                        </div>
                        <button type="submit" class="btn btn-outline-primary rounded-0">PAY ON DELIVERY</button>
                    </form>
                </div>

                <div id="cd_card" class="tabcontent mt-4">
                    <h3>CREDIT/DEBIT CARD</h3>
                    <div class="container-fluid py-3">
                        @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif
                        <div class="row">
                            <div class="container-fluid d-flex justify-content-center">
                                <div class="col-md-10">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-6"> <span>CREDIT/DEBIT CARD PAYMENT</span> </div>
                                                <div class="col-md-6 text-right" style="margin-top: -5px;"> <img src="https://img.icons8.com/color/36/000000/visa.png"> <img src="https://img.icons8.com/color/36/000000/mastercard.png"> <img src="https://img.icons8.com/color/36/000000/amex.png"> </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('checkout.payemnt', $userDetail->id) }}" id="payment-form" method="POST"> @csrf
                                                <input type="hidden" name="total_price" value="{{ $products->totalPrice }}">
                                                <input type="hidden" name="payment_type" id="3">
                                                <div id="payment-stripe" class="container">
                                                    <div class="row text-left justify-content-center">
                                                        <div class="col-md-12" id="card_error_message"></div>
                                                      <div class="col-sm-12">
                                                        <div class="form-group">
                                                          <label for="cc-number" class="control-label">CARD NUMBER </label>
                                                          <div class="input-group">
                                                            <input id="cc-number" type="tel" class="input-lg form-control cc-number" autocomplete="cc-number" placeholder="•••• •••• •••• ••••" data-payment='cc-number' required>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-sm-8">
                                                        <div class="form-group">
                                                          <label>CARD EXPIRY</label>
                                                          <div class="input-group">
                                                            <input id="cc-exp" type="tel" class="input-lg form-control cc-exp" autocomplete="cc-exp" placeholder="•• / ••••" data-payment='cc-exp' required>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-sm-4">
                                                        <div class="form-group">
                                                          <label>CARD CVC</label>
                                                          <div class="input-group">
                                                            <input id="cc-cvc" type="tel" class="input-lg form-control cc-cvc" autocomplete="off" placeholder="•••" data-payment='cc-cvc' required>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>CARD HOLDER NAME</label>
                                                          <div class="input-group">
                                                            <input type="text" id="cc-name" class="input-lg form-control cc-name" data-payment="cc-name" autocomplete="off" required placeholder="Atul Chauhan">
                                                          </div>
                                                          <span id="cc-name-error" class="text-danger"></span>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <button class="btn btn-primary" type="submit" id="validate">Pay Now</button>
                                                  </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="upi_pay" class="tabcontent mt-4">
                    <h3>PHONEPE/GOOGLE PAY</h3>
                    <form action="" method="POST" id="upi_payment_mode_form">
                        @csrf
                        <ul>
                            <li>
                                <label class="payment_radio_btn">
                                    <input type="radio" name="upi_payment_mode" onchange="paymentType('Paytm')" class="option-input" value="Paytm">
                                    <img src="{{ asset('img/icon/paytm.png') }}" class="payment_type_img ml-2 mr-2">
                                    Paytm
                                </label>
                            </li>
                            <hr>
                            <li>
                                <label class="payment_radio_btn">
                                    <input type="radio" name="upi_payment_mode" class="option-input" value="PayPal" onchange="paymentType('PayPal')">
                                    <img src="{{ asset('img/icon/paypal.png') }}" class="payment_type_img ml-2 mr-2">
                                    Paypal
                                </label>
                            </li>
                            <hr>
                            <li>
                                <label class="payment_radio_btn">
                                    <input type="radio" name="upi_payment_mode" class="option-input" value="GooglePay" onchange="paymentType('GooglePay')">
                                    <img src="{{ asset('img/icon/Googlepay.png') }}" class="payment_type_img ml-2 mr-2">
                                    Google Pay
                                </label>
                            </li>
                            <hr>
                            <li>
                                <label class="payment_radio_btn">
                                    <input type="radio" name="upi_payment_mode" class="option-input" value="PhonePe" onchange="paymentType('PhonePe')">
                                    <img src="{{ asset('img/icon/Phonepe.png') }}" class="payment_type_img ml-2 mr-2">
                                    Phone Pe
                                </label>
                            </li>
                        </ul>
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-block mt-3" type="submit">Pay Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <h2>Your Orders</h2>
                <div class="place-order mt-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                          <h5 class="card-title"><b>Price Details</b></h5>
                          <p class="float-left">Total Product</p>
                          <p class="float-right">{{ $products->totalQty }}<p><br>
                          <p class="float-left">Total Price</p>
                          <p class="float-right">₹{{ $products->totalPrice }}<p>
                        <button type="button" class="btn-block btn btn-primary" disabled>Total Pay (₹{{ $products->totalPrice }})</button>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
<script src="https://js.stripe.com/v2/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.min.js"></script>
<script src="{{ asset('js/manual/checkoutpayment.js') }}"></script>
<script>
    $(() => {
        paymentType = (type) => {
            let id = "{{ isset($userDetail) ? $userDetail->id : '' }}";
            let url = "{{ url('/check-out/payment/') }}/"+id+"/"+type;
            $("#upi_payment_mode_form").attr("action", url);
        }
        $(".razorpay-payment-button").addClass("btn btn-success rounded-0");
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('css/payment-checkout.css') }}">
@endpush
