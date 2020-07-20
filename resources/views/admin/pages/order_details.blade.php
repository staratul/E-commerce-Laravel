@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Order Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Order Details</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 my-3">
                <div class="row mb-3">
                    <div class="col-md-10">
                        <h2>Product Details - {{ $order->product->sub_title }}</h2>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('orders.index') }}" class="btn btn-dark rounded-0">Back</a>
                    </div>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#order_details">Order Details</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#product_details">Product Details</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#user_details">User Details</a>
                  </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content border mb-3">
                  <div id="order_details" class="container tab-pane active"><br>
                    <h3>Order Details</h3>
                    <hr>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 float-left">
                                <span class="text-gray">Product Quantity: </span><br>
                                <span class="text-gray">Product Price: </span><br>
                                <span class="text-gray">Product Color: </span><br>
                                <span class="text-gray">Product Size: </span><br>
                                <span class="text-gray">Checkout Date: </span><br>
                                <span class="text-gray">Payment Type: </span>
                            </div>
                            <div class="float-right">
                                <span>{{ $order->product_qty }}</span><br>
                                <span>{{ $order->product_price }}</span><br>
                                <span>{{ $order->product_color }}</span><br>
                                <span>{{ $order->product_size }}</span><br>
                                <span>{{ $order->checkout_date }}</span><br>
                                <span>{{ $order->payment_type->payment_type }}</span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div id="product_details" class="container tab-pane fade"><br>
                    <h3>Product Details</h3>
                    <hr>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 float-left">
                                <span class="text-gray">Product Category: </span><br>
                                <span class="text-gray">Seller: </span><br>
                                <span class="text-gray">Title: </span><br>
                                <span class="text-gray">Total In Stock: </span><br>
                                <span class="text-gray">Original Price: </span><br>
                                <span class="text-gray">Selling Price: </span>
                            </div>
                            <div class="float-right">
                                <span>{{ $order->product->category->category }}</span><br>
                                <span>{{ $order->product->title }}</span><br>
                                <span>{{ $order->product->sub_title }}</span><br>
                                <span>{{ $order->product->total_in_stock }}</span><br>
                                <span>{{ $order->product->original_price }}</span><br>
                                <span>{{ $order->product->selling_price }}</span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div id="user_details" class="container tab-pane fade"><br>
                    <h3>User Details</h3>
                    <hr>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 float-left">
                                <span class="text-gray">Name: </span><br>
                                <span class="text-gray">Email: </span><br>
                                <span class="text-gray">Phone: </span><br>
                                <span class="text-gray">Address: </span><br>
                                <span class="text-gray">City: </span><br>
                                <span class="text-gray">Pincode: </span>
                            </div>
                            <div class="float-right">
                                <span>
                                    {{ $order->userDetails->first_name }}
                                    {{ $order->userDetails->last_name }}
                                </span><br>
                                <span>{{ $order->userDetails->email }}</span><br>
                                <span>{{ $order->userDetails->phone }}</span><br>
                                <span>
                                    {{ $order->userDetails->address1 }},
                                    {{ $order->userDetails->address2 }}
                                </span><br>
                                <span>{{ $order->userDetails->city }}</span><br>
                                <span>{{ $order->userDetails->pincode }}</span>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <p class="act"><b>Active Tab</b>: <span></span></p>
                <p class="prev"><b>Previous Tab</b>: <span></span></p>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection

@push('js')
    <script>
        $(() => {
            $(".nav-tabs a").click(function(){
                $(this).tab('show');
            });
            $('.nav-tabs a').on('shown.bs.tab', function(event){
                var x = $(event.target).text();         // active tab
                var y = $(event.relatedTarget).text();  // previous tab
                $(".act span").text(x);
                $(".prev span").text(y);
            });
        });
    </script>
@endpush



