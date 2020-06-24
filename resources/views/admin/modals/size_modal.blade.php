<div class="modal fade" id="size_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="size_form">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="modal_title">Add Size</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-light" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <input type="hidden" id="size_id" name="size_id">
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        <select>
                    </div>
                    <div class="form-group">
                        <label for="size">Select Size</label>
                        <select class="select2bs4" multiple="multiple" name="size[]" id="size" data-placeholder="Select Size" style="width: 100%;">
                            <option value="Onsize">Onsize</option>
                            <option value="1-2Y">1-2Y</option>
                            <option value="2-3Y">2-3Y</option>
                            <option value="3-4Y">3-4Y</option>
                            <option value="4-5Y">4-5Y</option>
                            <option value="5-6Y">5-6Y</option>
                            <option value="6-7Y">6-7Y</option>
                            <option value="7-8Y">7-8Y</option>
                            <option value="8-9Y">8-9Y</option>
                            <option value="9-10Y">9-10Y</option>
                            <option value="26">26</option>
                            <option value="28">28</option>
                            <option value="30">30</option>
                            <option value="32">32</option>
                            <option value="34">34</option>
                            <option value="36">36</option>
                            <option value="38">38</option>
                            <option value="40">40</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="size_form_submit" class="btn btn-primary rounded-0">Submit</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
