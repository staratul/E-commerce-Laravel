@extends('admin.layouts.master') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div id="loader"></div>
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Manage Slider</h1> </div>
			<!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route("home") }}">Dashboard</a></li>
					<li class="breadcrumb-item active">Manage Slider</li>
				</ol>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</div>
<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
            <button type="button" class="btn btn-light ml-2 py-2">Back</button>
            <div class="col-md-12 my-3">
                <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Manage Home Slider</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Category</label>
                    <select class="form-control select2bs4" name="category_id" id="category_id" style="width: 100%;">
                      <option selected="selected" value="">selected</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tags</label>
                    <select class="select2bs4" multiple="multiple" name="tags" data-placeholder="Select a State"
                            style="width: 100%;">

                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Title">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="offer">Offer</label>
                        <input type="number" min="1" max="99" class="form-control" name="offer" placeholder="Offer">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Select Image</label>
                        <input class="btn btn-info form-control-file" type="file" accept="image/jpg, image/jpeg, image/png, image/gif" name="images" id="images" />
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="text">Sort Text</label>
                        <textarea class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                    </textarea>
                    </div>
                </div>
                <div class="col-md-12 text-right mt-3">
                    <button type="reset" class="btn btn-dark rounded-0 mr-3">Cancle</button>
                    <button type="submit" class="btn btn-success rounded-0">Submit</button>
                </div>
              </div>
            </div>
          </div>
            </div>
		</div>
    </div>
</div>

@endsection @push('js')
<script>
	$(function() {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        $('.textarea').summernote()

        $("#category_id").on("change", () => {
            let categories,category_id,category,tags;
            categories = {!! isset($categories) ? $categories : [] !!};
            category_id = $("#category_id").val();
            category = categories.filter(cat => cat.id === Number(category_id));
            tags = category[0].tag.tags.split(",");
            console.log(category,category_id, tags);
        });
	});
</script> @endpush @push('css')
<style>
	#loader {
		display: none;
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('/img/loader3.gif') 50% 50% no-repeat rgb(10, 10, 10);
		opacity: .8;
	}
</style> @endpush
