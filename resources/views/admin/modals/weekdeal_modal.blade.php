<div class="modal fade" id="weekdeal_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="weekdeal_form" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                <h4 class="modal-title" id="modal_title">Add A Deal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-light" aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div id="response-message"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                               <label>Category</label>
                               <select class="form-control select2bs4 w-100" name="category_id" id="category_id" required>
                                   <option value="">Select</option>
                                  @foreach ($categories as $category)
                                     <option value="{{ $category->id }}"
                                         {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}
                                         >
                                         {{ $category->category }}
                                     </option>
                                  @endforeach
                               </select>
                               <span id="category_id_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="weekdeal_id" type="hidden" name="weekdeal_id">
                                <label for="deal_type">Deal Type</label>
                                <select name="deal_type" id="deal_type" class="form-control select2bs4 w-100" required>
                                    <option value="">Select</option>
                                    <option value="D">Day</option>
                                    <option value="W">Week</option>
                                    <option value="M">Month</option>
                                </select>
                                <span id="deal_type_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deal_on">Deal On</label>
                                <select name="deal_on" id="deal_on" class="form-control select2bs4 w-100" required></select>
                                <span id="deal_on_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input name="price" id="price" class="form-control" placeholder="Price" required>
                                <span id="price_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="image">Image</label>
                            <input class="btn btn-info form-control-file" type="file" accept="image/jpg, image/jpeg, image/png, image/gif" name="image" id="image">
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control" required></textarea>
                            <span id="content_error"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="weekdeal_form_submit" class="btn btn-primary rounded-0">Submit</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
