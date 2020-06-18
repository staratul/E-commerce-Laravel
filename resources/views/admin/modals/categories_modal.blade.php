<div class="modal fade" id="category_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="categories_form" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                <h4 class="modal-title" id="modal_title">Add Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-light" aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div id="response-message"></div>
                    <div class="form-group">
                        <input id="categories_id" type="hidden" name="categories_id">
                        <label for="category">Category *</label>
                        <input type="text" class="form-control" name="category" id="category" placeholder="Enter Category" required>
                    </div>
                    <div class="form-group">
                        <label for="category_url">Category URL *</label>
                        <input type="text" class="form-control" name="category_url" id="category_url" placeholder="Enter Category URL" required>
                    </div>
                    <div id="sub_category_div">

                    </div>
                    <div class="form-group">
                        <button type="button" id="add_sub_category" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Add Sub Category</button>
                    </div>
                    {{-- <div class="form-group">
                        <label for="sub_category">Sub Category</label>
                        <input type="text" data-role="tagsinput" name="sub_category" id="sub_category" class="form-control">
                        </select>
                    </div> --}}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="category_form_submit" class="btn btn-primary rounded-0">Submit</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
