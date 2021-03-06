@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Mange Footer</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Tags</li>
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
            <a href="{{ route('footers.create') }}" class="btn btn-light ml-2 py-2"><i class="fas fa-plus mr-1"></i>Add</a>
            <div class="col-md-12 my-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>{{ 1 }}</td>
                                <td>{{ $footer['email'] ?? "" }}</td>
                                <td>{{ $footer['phone'] ?? "" }}</td>
                                <td>{{ $footer['address'] ?? "" }}</td>
                                <td><a href="{{ route('footers.edit', $footer['id']) }}" class="btn btn-light ml-2 py-2">Edit</a></td>
                            </tr>
                    </tbody>
                </table>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->

@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            let success = "@if(Session::has('success')) {{ Session::get('success') }} @endif";
            if(success) {
                toastr.success(success);
            }
        });
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
@endpush

