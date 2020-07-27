@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Unique Visitors</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Unique Visitors</li>
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
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>IP</th>
                            <th>Date Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($visitors as $key => $visitor)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $visitor['ip'] }}</td>
                                <td>{{ Helper::dateFormat($visitor['datetime']) }}</td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>S No</th>
                            <th>IP</th>
                            <th>Date Time</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
          </div>
        </div>
      </div>

@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
@endpush


