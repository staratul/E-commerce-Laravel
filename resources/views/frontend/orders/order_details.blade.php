<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Order Details</title>
    <style>
        body {
            min-height: 100vh;
            background-size: cover;
            font-family: 'Lato', sans-serif;
            color: rgba(116, 116, 116, 0.667);
            background: linear-gradient(140deg, #fff, 50%, #BA68C8)
        }

        .container-fluid {
            margin-top: 200px
        }

        p {
            font-size: 14px;
            margin-bottom: 7px
        }

        .small {
            letter-spacing: 0.5px !important
        }

        .card-1 {
            box-shadow: 2px 2px 10px 0px rgb(190, 108, 170)
        }

        hr {
            background-color: rgba(248, 248, 248, 0.667)
        }

        .bold {
            font-weight: 500
        }

        .change-color {
            color: #AB47BC !important
        }

        .card-2 {
            box-shadow: 1px 1px 3px 0px rgb(112, 115, 139)
        }

        .fa-circle.active {
            font-size: 8px;
            color: #AB47BC
        }

        .fa-circle {
            font-size: 8px;
            color: #aaa
        }

        .rounded {
            border-radius: 2.25rem !important
        }

        .progress-bar {
            background-color: #AB47BC !important
        }

        .progress {
            height: 5px !important;
            margin-bottom: 0
        }

        .invoice {
            position: relative;
            top: -70px
        }

        .Glasses {
            position: relative;
            top: -12px !important
        }

        .card-footer {
            background-color: #AB47BC;
            color: #fff
        }

        h2 {
            color: rgb(78, 0, 92);
            letter-spacing: 2px !important
        }

        .display-3 {
            font-weight: 500 !important
        }

        @media (max-width: 479px) {
            .invoice {
                position: relative;
                top: 7px
            }

            .border-line {
                border-right: 0px solid rgb(226, 206, 226) !important
            }
        }

        @media (max-width: 700px) {
            h2 {
                color: rgb(78, 0, 92);
                font-size: 17px
            }

            .display-3 {
                font-size: 28px;
                font-weight: 500 !important
            }
        }

        .card-footer small {
            letter-spacing: 7px !important;
            font-size: 12px
        }

        .border-line {
            border-right: 1px solid rgb(226, 206, 226)
        }

    </style>
  </head>
  <body>
    <div class="container-fluid my-5 d-flex justify-content-center">
        <div class="col-md-11">
            <div class="card card-1">
                <div class="card-header bg-white">
                    <div class="media flex-sm-row flex-column-reverse justify-content-between ">
                        <div class="col my-auto">
                            <h4 class="mb-0">Thanks for your Order,<span class="change-color">{{ $userDetail->first_name }} {{ $userDetail->last_name }}</span> !</h4>
                        </div>
                        <div class="col my-auto">
                        </div>
                        <div class="col-auto text-center my-auto pl-0 pt-sm-4"> <img class="img-fluid my-auto align-items-center mb-0 pt-3" src="{{ asset('/img/logo.png') }}" width="115" height="115">
                            <p class="mb-4 pt-0 mt-4 Glasses">Cloths For Everyone</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-5">
                            <h6 class="color-1 mb-0 change-color">Receipt</h6>
                        </div>
                        <div class="col-md-5 text-right"> <small>Receipt Voucher : 1KAU9-84UIL</small> </div>
                    </div>
                    @foreach ($orders as $key => $order)
                    <div class="row justify-content-center @if($key % 2 != 0) mt-4 @endif">
                        <div class="col-md-10">
                            <div class="card card-2">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="sq align-self-center "> <img class="img-fluid my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="{{ $order->product_image_url }}" width="135" height="135" /> </div>
                                        <div class="media-body my-auto text-right">
                                            <div class="row my-auto flex-column flex-md-row">
                                                <div class="col my-auto">
                                                    <h6 class="mb-0"> {{ $order->title }}</h6>
                                                </div>
                                                <div class="col-auto my-auto"> <small>{{ $order->sub_title }} </small></div>
                                                <div class="col my-auto"> <small>Size : {{ $order->product_size }}</small></div>
                                                <div class="col my-auto"> <small>Qty : {{ $order->product_qty }}</small></div>
                                                <div class="col my-auto">
                                                    <h6 class="mb-0">&#8377;{{ $order->product_price }}.00</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-3 ">
                                    <div class="row">
                                        <div class="col-md-3 mb-3"> <small> Track Order <span><i class=" ml-2 fa fa-refresh" aria-hidden="true"></i></span></small> </div>
                                        <div class="col mt-auto">
                                            <div class="progress my-auto">
                                                <div class="progress-bar progress-bar rounded" style="width: 1%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="media row justify-content-between ">
                                                <div class="col-auto text-right"><span> <small class="text-right mr-sm-2"></small> <i class="fa fa-circle active"></i> </span></div>
                                                <div class="flex-col"> <span> <small class="text-right mr-sm-2">Out for delivary</small><i class="fa fa-circle active"></i></span></div>
                                                <div class="col-auto flex-col-auto"><small class="text-right mr-sm-2">Delivered</small><span> <i class="fa fa-circle"></i></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="row mt-4 justify-content-center">
                        <div class="col-md-10">
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <p class="mb-1 text-dark"><b>Order Details</b></p>
                                </div>
                                <div class="flex-sm-col text-right col">
                                    <p class="mb-1"><b>Total</b></p>
                                </div>
                                <div class="flex-sm-col col-auto">
                                    <p class="mb-1">&#8377;{{ $orders->sum('product_price') }}</p>
                                </div>
                            </div>
                            <div class="row justify-content-between">
                                <div class="flex-sm-col text-right col">
                                    <p class="mb-1"> <b>Discount</b></p>
                                </div>
                                <div class="flex-sm-col col-auto">
                                    <p class="mb-1">&#8377;150</p>
                                </div>
                            </div>
                            <div class="row justify-content-between">
                                <div class="flex-sm-col text-right col">
                                    <p class="mb-1"><b>GST 18%</b></p>
                                </div>
                                <div class="flex-sm-col col-auto">
                                    <p class="mb-1">843</p>
                                </div>
                            </div>
                            <div class="row justify-content-between">
                                <div class="flex-sm-col text-right col">
                                    <p class="mb-1"><b>Delivery Charges</b></p>
                                </div>
                                <div class="flex-sm-col col-auto">
                                    <p class="mb-1">Free</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row invoice justify-content-center">
                        <div class="col-md-10">
                            <p class="mb-1"> Invoice Number : 788152</p>
                            <p class="mb-1">Invoice Date : 22 Dec,2019</p>
                            <p class="mb-1">Recepits Voucher:18KU-62IIK</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="jumbotron-fluid">
                        <div class="row justify-content-between ">
                            <div class="col-sm-auto col-auto my-auto"><img class="img-fluid my-auto align-self-center " src="{{ asset('img/logo.png') }}" width="115" height="115"></div>
                            <div class="col-auto my-auto ">
                                <h2 class="mb-0 font-weight-bold">TOTAL PAID</h2>
                            </div>
                            <div class="col-auto my-auto ml-auto">
                                <h1 class="display-3 ">&#8377; {{ $orders->sum('product_price') }}</h1>
                            </div>
                        </div>
                        <div class="row mb-3 mt-3 mt-md-0">
                            <div class="col-auto border-line"> <small class="text-white">PAN:AA02hDW7E</small></div>
                            <div class="col-auto border-line"> <small class="text-white">CIN:UMMC20PTC </small></div>
                            <div class="col-auto "><small class="text-white">GSTN:268FD07EXX </small> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
