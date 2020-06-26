<div class="modal fade" id="fill_product_stock_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="fill_product_stock_form">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" id="modal_title">Product In Stock - <b class="modal_total_stock"></b></h4>
                    <button type="button" class="close" onclick="closeProductStockModal()" data-dismiss="modal" aria-label="Close">
                        <span class="text-light" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Total Stock: <span class="modal_total_stock"></span></h5>
                            <div class="row" id="stock_in_size_div">

                            </div>
                        </div>
                        <div class="col-md-6 border-left">
                            <h5>Total Stock: <span class="modal_total_stock"></span></h5>
                            <div class="row" id="stock_in_color_div">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <h6><b>Note: </b>Total of <mark>"size stock"</mark> and color <mark>"stock value"</mark> must be = <span class="modal_total_stock"></span></h6>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-primary" onclick="doneProductStock()">Done</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
