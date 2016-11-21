<div class="modal fade signIn" role="dialog" id="logIn">
      <div class="modal-dialog">
          <div class="modal-content ">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="modal-title text-center">Log In</h3>
              </div>

              <div class="modal-body">
                  <form class="form form-horizontal container-fluid" action="includes/sign_in.php" method="post">
                    <div class="alertBlock"></div>
                    <div class='alert alert-dismissible  text-center' role='alert'>
                      <button type='button' class='close close_alert' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                      <span class='glyphicon alert_icon' aria-hidden='true'></span>
                      <span class="alert_msg"><strong></strong></span>
                    </div>
                      <div class="form-group">
                          <label for="email" class="col-xs-3">Email: </label>
                          <div class="col-xs-9">
                              <input id="email" class="form-control" name="email" type="email"></input>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="pwd" class="col-xs-3">Password: </label>
                          <div class="col-xs-9">
                              <input id="pwd" class="form-control" name="password" type="password"></input>
                          </div>
                      </div>
                      <div class="before_msg pull-left"></div>
              </div>
              <div class="modal-footer">
                  <div class="form-group">
                    <a href="reset_password.php" class="btn btn-info pull-left" name="reset">Forgot Password?</a>
                      <button type="submit" class="btn btn-primary"id="log_in" name="log_in">Log In</button>
                      <button type="button" class="btn btn-warning" name="button" data-dismiss="modal">Close</button>
                  </div>
              </div>
              </form>

          </div>
      </div>
  </div>
