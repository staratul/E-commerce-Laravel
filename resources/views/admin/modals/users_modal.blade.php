<div class="modal fade" id="users_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="user_form">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="modal_title">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-light" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <label for="name">Name</label>
                        <input id="name" class="form-control" type="text" name="name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" class="form-control" type="eamil" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="user_form_submit" class="btn btn-primary rounded-0">Submit</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
