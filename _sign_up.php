<div class="modal fade signUp" role="dialog" id="signUp">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" data-dismiss="modal" class="close">&times;</button>
                  <h3 class="modal-title text-center">Sign Up</h3>
              </div>
              <div class="modal-body">
                  <form class="form form-horizontal" action="includes/sign_up.php" method="post">
                      <div class="form-group has-feedback">
                          <label for="name_up" class="col-xs-3 control-label">Name: </label>
                          <div class="col-xs-9">
                              <input id="name_up" class="form-control" name="name" type="text"></input>
                              <span class="form-control-feedback result_icn" aria-hidden="true"></span>
                              <label class="result_txt"></label>
                          </div>
                      </div>
                      <div class="form-group has-feedback">
                          <label for="email_up" class="col-xs-3 control-label">Email: </label>
                          <div class="col-xs-9">
                              <input id="email_up" class="form-control" name="email" type="email"></input>
                              <span class="form-control-feedback result_icn" aria-hidden="true"></span>
                              <label class="result_txt"></label>
                          </div>
                      </div>
                      <div class="form-group has-feedback">
                          <label for="tel_up" class="col-xs-3 control-label">Tel: </label>
                          <div class="col-xs-9">
                              <input id="tel_up" class="form-control" name="phone" type="text"></input>
                              <span class="form-control-feedback result_icn" aria-hidden="true"></span>
                              <label class="result_txt"></label>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="address_up" class="col-xs-3 control-label">Address: </label>
                          <div class="col-xs-9">
                              <textarea id="address_up" class="form-control" name="address"></textarea>
                              <label class="result_txt"></label>
                          </div>
                      </div>
                      <div class="form-group has-feedback">
                          <label for="pwd_up" class="col-xs-3 control-label">Password: </label>
                          <div class="col-xs-9">
                              <input id="pwd_up" class="form-control" name="password" type="password"></input>
                              <span class="form-control-feedback result_icn" aria-hidden="true"></span>
                              <label class="result_txt"></label>
                          </div>
                      </div>
              </div>
              <div class="modal-footer">
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary" name="sign_Up">Sign Up</button>
                      <button type="button" class="btn btn-warning" name="button" data-dismiss="modal">Close</button>
                  </div>
              </div>
              </form>
          </div>
      </div>
  </div>
