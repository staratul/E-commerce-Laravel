<div class="modal fade" id="color_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="color_form">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="modal_title">Add Color</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-light" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="hidden" id="color_id" name="color_id">
                        <input type="text" name="color" id="color" placeholder="Color" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" name="code" id="code" placeholder="Code" class="form-control">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="color_form_submit" class="btn btn-primary rounded-0">Submit</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
