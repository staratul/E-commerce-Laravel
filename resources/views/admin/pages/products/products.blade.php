@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Manage Products</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("home") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Manage Products</li>
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
            <a type="button" class="btn btn-light ml-2 py-2" href="{{ route('products.create') }}"><i class="fas fa-plus mr-1"></i>Add</a>
            <div class="col-md-12 my-3">

            </div>
          </div>
        </div>
      </div>

@endsection


@push('js')
<script>
    $(() => {

    });
</script>
@endpush

@push('css')
    <style>
        #loader {display: none;position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;
            z-index: 9999;
            background: url('/img/loader3.gif') 50% 50% no-repeat rgb(10,10,10);
            opacity: .8;
        }
    </style>
@endpush
