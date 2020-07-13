<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Document</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('css/otp.css') }}" type="text/css" />
        <style>
            .error {
                color: red;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <form action="{{ route('otpVerification', [$userDetail->id, $oTPVerification->id]) }}" method="POST" id="otpverificationform">
                @csrf
                <div class="mt-4">
                    @include('common.messages')
                </div>
                <div class="row justify-content-center ">
                    <div class="col-md-6" style="margin-top: 10%">
                        <!-- col -->
                        <h2><h1>Check your email!</h1></h2>
                        <p class="desc">We’ve sent a six-digit confirmation code to <strong>{{ $userDetail->email }}</strong> & {{ $userDetail->phone }}. Enter it below to confirm your email address and mobile number.</p>
                        <a href="{{ route('send.OTP', $userDetail->id) }}" style="text-decoration: none">Resend OTP</a>
                        <br />
                        <label><span class="normal">Your </span>confirmation code</label>
                        <div class="confirmation_code split_input large_bottom_margin" data-multi-input-code="true">
                            <div class="confirmation_code_group">
                                <div class="split_input_item input_wrapper">
                                    <input type="text" class="inline_input" id="input1" name="input1" maxlength="1" required onkeyup="movetoNext(this, 'input2')"/>
                                </div>
                                <div class="split_input_item input_wrapper">
                                    <input type="text" class="inline_input" id="input2" name="input2" maxlength="1" required onkeyup="movetoNext(this, 'input3')"/>
                                </div>
                                <div class="split_input_item input_wrapper">
                                    <input type="text" class="inline_input" id="input3" name="input3" maxlength="1" required onkeyup="movetoNext(this, 'input4')"/>
                                </div>
                            </div>
                            <div class="confirmation_code_span_cell">—</div>
                            <div class="confirmation_code_group">
                                <div class="split_input_item input_wrapper">
                                    <input type="text" class="inline_input" id="input4" name="input4" maxlength="1" required onkeyup="movetoNext(this, 'input5')"/>
                                </div>
                                <div class="split_input_item input_wrapper">
                                    <input type="text" class="inline_input" id="input5" name="input5" maxlength="1" required onkeyup="movetoNext(this, 'input6')"/>
                                </div>
                                <div class="split_input_item input_wrapper">
                                    <input type="text" class="inline_input" id="input6" name="input6" maxlength="1" required/>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-block btn-primary rounded-0">Verify</button>
                        </div>
                    </div>
                    <!-- endof col -->
                </div>
            </form>
        </div>

<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('dashboard/dist/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('dashboard/dist/js/additional-methods.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script>
    $(() => {
        document.getElementById('input1').focus();
        $("#otpverificationform").validate({
            errorPlacement: function(){
                return false;  // suppresses error message text
            }
        });

        $('.alert-danger').fadeIn().delay(5000).fadeOut();
        $('.alert-success').fadeIn().delay(5000).fadeOut();
    });
    movetoNext = (current, nextFieldID) => {
        if (current.value.length = 1) {
            document.getElementById(nextFieldID).focus();
        }
    }
</script>
    </body>
</html>
