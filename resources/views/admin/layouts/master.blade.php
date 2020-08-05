
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AdminLTE 3 | Starter</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/dist/css/jsgrid.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/dist/css/jsgrid-theme.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/dist/css/select2-bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/dist/css/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/dist/css/tagsinput.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" href="{{ asset('css/trix.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/dist/css/style.css') }}">
  <style>
      .btn-light {
          background-color: white;
          border: 1px solid gray;
      }
      .btn-info {
          color: white;
      }
      .btn-light:hover {
          background-color: white;
      }
      .error {
          color: red;
      }
  </style>
@stack('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a style="text-decoration: none" class="dropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="fas fa-user mr-1"></i>{{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center">
      <img src="{{ asset('img/footer-logo.png') }}" alt="AdminLTE Logo">
      {{-- <span class="brand-text font-weight-light">Fashi.</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('admin-img/teammember4.png') }}" alt="AdminLTE Logo">
          </div>
          <div class="info">
            <a href="#" class="d-block">Atul Chauhan</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                    Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item has-treeview @if(Route::currentRouteName() === 'admin.home.slider') menu-open @endif">
                <a href="#" class="nav-link @if(Route::currentRouteName() === 'admin.home.slider') active @endif">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Home
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('admin.home.slider') }}" class="nav-link @if(Route::currentRouteName() === 'admin.home.slider') active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Home Slider</p>
                      </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.weekdeal') }}" class="nav-link @if(Route::currentRouteName() === 'admin.weekdeal') active @endif">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Week Deal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.partnerlogo') }}" class="nav-link @if(Route::currentRouteName() === 'admin.partnerlogo') active @endif">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Partner Logo</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('footers.index') }}" class="nav-link @if(Route::currentRouteName() === 'footers.index') active @endif">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Partner Logo</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview @if(Route::currentRouteName() === 'admin.categories' || Route::currentRouteName() === 'admin.menus' || Route::currentRouteName() === 'admin.tags') menu-open @endif">
              <a href="#" class="nav-link @if(Route::currentRouteName() === 'admin.categories' || Route::currentRouteName() === 'admin.menus' || Route::currentRouteName() === 'admin.tags') active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Pages
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('admin.categories') }}" class="nav-link @if(Route::currentRouteName() === 'admin.categories') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Categories</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.menus') }}" class="nav-link @if(Route::currentRouteName() === 'admin.menus') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Menus</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.tags') }}" class="nav-link @if(Route::currentRouteName() === 'admin.tags') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tags</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview @if(Route::currentRouteName() === 'products.index' || Route::currentRouteName() === 'products.create' || Route::currentRouteName() === 'products.size' || Route::currentRouteName() === 'products.color') menu-open @endif">
              <a href="#" class="nav-link @if(Route::currentRouteName() === 'products.index' || Route::currentRouteName() === 'products.create' || Route::currentRouteName() === 'products.size' || Route::currentRouteName() === 'products.color') active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Product
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('products.index') }}" class="nav-link @if(Route::currentRouteName() === 'products.index') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Products</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('products.create') }}" class="nav-link @if(Route::currentRouteName() === 'products.create') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add Product</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('products.size') }}" class="nav-link @if(Route::currentRouteName() === 'products.size') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Product Size</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('products.color') }}" class="nav-link @if(Route::currentRouteName() === 'products.color') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Product Color</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('products.state') }}" class="nav-link @if(Route::currentRouteName() === 'products.state') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>State</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('products.brand') }}" class="nav-link @if(Route::currentRouteName() === 'products.brand') active @endif">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Brand</p>
                  </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('payment.type') }}" class="nav-link @if(Route::currentRouteName() === 'payment.type') active @endif">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Payment Types</p>
                    </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview @if(Route::currentRouteName() === 'orders.index') menu-open @endif">
                <a href="#" class="nav-link @if(Route::currentRouteName() === 'orders.index') active @endif">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Orders
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('orders.index') }}" class="nav-link @if(Route::currentRouteName() === 'orders.index') active @endif">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Manage Orders</p>
                      </a>
                    </li>
                </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
            @yield('content')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('dashboard/dist/js/jsgrid.min.js') }}"></script>
<script src="{{ asset('dashboard/dist/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('dashboard/dist/js/additional-methods.min.js') }}"></script>
<script src="{{ asset('dashboard/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('dashboard/dist/js/toastr.min.js') }}"></script>
<script src="{{ asset('dashboard/dist/js/tagsinput.js') }}"></script>
<script src="{{ asset('js/trix.js') }}"></script>
<script>
    $(() => {
        $('.alert-danger').fadeIn().delay(5000).fadeOut();
        $('.alert-success').fadeIn().delay(5000).fadeOut();
    })
</script>
@stack('js')
</body>
</html>
