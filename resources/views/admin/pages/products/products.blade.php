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
                <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
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
                <div id="jsGrid"></div>
            </div>
          </div>
        </div>
      </div>

@endsection


@push('js')
<script>
    $(() => {
        let products,fields=[];
        products = {!! isset($products) ? json_encode($products) : 'false' !!};
        // console.log(products);
        if(products != false) {
            fields.push({ name: "product_image.product_image_url", type: "text", title: "Image", width: 80,
                itemTemplate: function(item, value) {
                    return `<img src="${value.product_image.product_image_url}" width="80" height="80">`
                }
            });
            fields.push({ name: "category.category", type: "text", title: "Category", width: 70});
            fields.push({ name: "sub_category.sub_category", type: "text", title: "Sub Category", width:80});
            fields.push({ name: "title", type: "text", title: "Title", width:80});
            fields.push({ name: "sub_title", type: "text", title: "Sub Title", width:100});
            fields.push({ name: "selling_price", type: "number", title: "Price", width:40});
            fields.push({ name: "discount", type: "number", title: "Discount", width:40,
                itemTemplate: function(item, value) {
                    return `${value.discount}%`;
                }
            });
            fields.push({ name: "total_in_stock", type: "number", title: "Stock", width:40});
            fields.push({ type: "control", width: 120, editButton: false, deleteButton: false,
                itemTemplate: function(item, value) {
                    let button = '', url = '';
                    url = '{{ route("products.edit", ":id") }}';
                    url = url.replace(':id', value.id);
                    if(value.status == 0) {
                        button = `<button type="button" onclick="updateStatus(${value.id},${value.status})" class="btn btn-secondary text-white"><i class="fas fa-toggle-off"></i></button>`;
                    }else if(value.status == 1) {
                        button = `<button type="button" onclick="updateStatus(${value.id},${value.status})" class="btn btn-success"><i class="fas fa-toggle-on"></i></button>`;
                    }
                    return `${button} <a href="${url}" class="btn btn-info text-white ml-1"><i class="fas fa-pen"></i></a><button type="button"  onclick="deletemenu(${value.id})" class="btn btn-danger ml-1"><i class="fas fa-trash"></i></button>`
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
                        $("#jsGrid").data("JSGrid").data = products;
                        let result = $.grep($("#jsGrid").data("JSGrid").data, function(item) {
                            return (!filter.category.category || item.category.category.indexOf(filter.category.category) > -1)
                                    && (!filter.sub_category.sub_category || item.sub_category.sub_category.indexOf(filter.sub_category.sub_category) > -1)
                                    && (!filter.title || item.title.indexOf(filter.title) > -1)
                                    && (!filter.sub_title || item.sub_title.indexOf(filter.sub_title) > -1)
                                    && (!filter.selling_price || item.selling_price==filter.selling_price)
                                    && (!filter.discount || item.discount==filter.discount)
                                    && (!filter.total_in_stock || item.total_in_stock==filter.total_in_stock)
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

@push('css')
    <style>
        #loader {display: none;position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;
            z-index: 9999;
            background: url('/img/loader3.gif') 50% 50% no-repeat rgb(10,10,10);
            opacity: .8;
        }
    </style>
@endpush


