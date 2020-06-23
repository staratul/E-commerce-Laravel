@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Manage Slider</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("home") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Manage Slider</li>
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
            <a type="button" class="btn btn-light ml-2 py-2" href="{{ route('add.home.slider') }}"><i class="fas fa-plus mr-1"></i>Add</a>
            <div class="col-md-12 my-3">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Tags</th>
                            <th>Offer</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#No</th>
                            <th>#Image</th>
                            <th>#Category</th>
                            <th>#Title</th>
                            <th>#Tags</th>
                            <th>#Offer</th>
                            <th width="100px">#Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->

@endsection


@push('js')
<script>
    $(() => {
        let table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.home.slider') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'image', name: 'image'},
                {data: 'category.category', name: 'category.category'},
                {data: 'title', name: 'title'},
                {data: 'tags', name: 'tags'},
                {data: 'offer', name: 'offer'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
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
        .bootstrap-tagsinput .badge {margin: 2px 2px;}
        #delete_sub_menu {height: 38px;width: 50px;margin-top: 30px;margin-left: 20px;
        }
    </style>
@endpush
