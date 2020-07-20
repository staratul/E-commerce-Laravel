@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div id="loader"></div>
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Manage Orders</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Manage Orders</li>
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
                <div id="jsGrid"></div>
            </div>
          </div>
        </div>
      </div>

@endsection


@push('js')
<script>
    $(() => {
        let orders,fields=[];
        orders = {!! isset($orders) ? json_encode($orders) : 'false' !!};
        // console.log(orders);
        if(orders != false) {
            fields.push({ name: "id", type: "number", title: "Id", width:15});
            fields.push({ name: "product.title", type: "text", title: "Title", width:25});
            fields.push({ name: "product.sub_title", type: "text", title: "Sub Title", width:90});
            fields.push({ name: "product_price", type: "number", title: "Price", width:15});
            fields.push({ name: "payment_type.payment_type", type: "text", title: "Payment Mode", width:25});
            fields.push({ name: "checkout_date", type: "text", title: "Date", width:30});
            fields.push({ type: "control", width: 20, editButton: false, deleteButton: false,
                itemTemplate: function(item, value) {
                    let url = "{{ route('order.detail', ':id') }}";
                    url = url.replace(':id', value.id);
                    return `<a href="${url}" class="btn btn-info ml-1"><i class="fa fa-info" aria-hidden="true"></i>nfo</a>`
                }
            });
            $("#jsGrid").jsGrid({
                height: "auto",
                width: "100%",
                filtering: true,
                inserting: false,
                editing: false,
                sorting: true,
                paging: true,
                autoload: true,
                pageSize: 10,
                pageButtonCount: 5,
                deleteConfirm: "Do you really want to delete item?",
                controller: {
                    loadData: function (filter) {
                        $("#jsGrid").data("JSGrid").data = orders;
                        let result = $.grep($("#jsGrid").data("JSGrid").data, function(item) {
                            return (!filter.product.title || item.product.title.indexOf(filter.product.title) > -1)
                            && (!filter.product_price || item.product_price==filter.product_price)
                            && (!filter.product.sub_title || item.product.sub_title.indexOf(filter.product.sub_title) > -1)
                            && (!filter.payment_type.payment_type || item.payment_type.payment_type.indexOf(filter.payment_type.payment_type) > -1)
                            && (!filter.checkout_date || item.checkout_date.indexOf(filter.checkout_date) > -1)
                        });
                        return result;
                    }
                },
                fields:fields
            });

            $("#jsGrid :input").keydown(function () {
                var self = this;
                if (self.timeout)
                    clearTimeout(self.timeout);
                if (self.value.length == 0)
                    $("#jsGrid").jsGrid('loadData');
                self.timeout = setTimeout(function() {
                    $("#jsGrid").jsGrid('loadData');
                }, 1);
            });
        }
    });
</script>
@endpush



