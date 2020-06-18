<div class="modal fade" id="menu_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="menus_form">
                <div class="modal-header bg-primary">
                <h4 class="modal-title" id="modal_title">Add Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-light" aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div id="response-message"></div>
                    <div class="form-group">
                        <input id="menus_id" type="hidden" name="menus_id">
                        <label for="menu">Menu *</label>
                        <input type="text" class="form-control" name="menu" id="menu" placeholder="Enter Menu" required>
                    </div>
                    <div class="form-group">
                        <label for="menu_url">Menu URL *</label>
                        <input type="text" class="form-control" name="menu_url" id="menu_url" placeholder="Enter Menu URL" required>
                    </div>
                    <div id="sub_menu_div">

                    </div>
                    <div class="form-group">
                        <button type="button" id="add_sub_menu" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Add Sub Menu</button>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="menu_form_submit" class="btn btn-primary rounded-0">Submit</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
