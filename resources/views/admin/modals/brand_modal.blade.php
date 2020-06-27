<div class="modal fade" id="brand_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="brand_form">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="modal_title">Add Brand</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-light" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="hidden" id="brand_id" name="brand_id">
                        <input type="text" name="brand" id="brand" placeholder="Brand" class="form-control">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="brand_form_submit" class="btn btn-primary rounded-0">Submit</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
