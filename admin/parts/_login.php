<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-3">Admin Section</h1>
      <p class="lead">Restricted Access!!!</p>
    </div>
  </div>
  <div class="container-fluid">
  <form action='process_forms.php' method="post" class='login well form form-horizontal'>
    <div class="alertBlock"></div>
    <div class='formgroup row'>
      <label for="email" class="control-label col-sm-3">Email</label>
      <div class="col-sm-7">
        <input type="email" id="email" class="email form-control" name="email">
      </div>
    </div>
    <div class='formgroup row'>
      <label for="pwd" class="control-label col-sm-3">Password</label>
      <div class="col-sm-7">
        <input type="password" id="pwd" class="pwd form-control" name="pwd">
        <input type="hidden" class='token' name="token" id="token" value="<?php echo get_token();?>">
      </div>
    </div>
    <div class="form-group">
    <button type="submit" name="logIn" class="btn btn-primary col-sm-offset-2">Log In</button>
    <span class="before_msg col-sm-offset-1"></span>
    </div>
    </div>
  </form>
  </div>
