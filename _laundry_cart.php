<div class="modal fade signUp" role="dialog" id="laundry_cart">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" data-dismiss="modal" class="close">&times;</button>
                  <h3 class="modal-title text-center">Laundry Cart</h3>
              </div>
              <div class="modal-body cart_body">
              </div>
              <div class="modal-footer">
                  <button type="button" name="button" class="chk_out btn btn-success pull-left">Checkout</button>
                  <button type="button" name="button" onclick="clear_cart()" class="clear_cart btn btn-danger">Empty Cart</button>
                  <button type="button" class="btn btn-warning" name="button" data-dismiss="modal">Close</button>
                  <p class="text-center before_msg" style="border-bottom: 1px solid #ddd;padding: 1px 0 5px;">
                    Processing
                  </p>
              </div>
          </div>
      </div>
  </div>
