<?php require 'includes/start_session.php';?>
<?php require 'includes/processor.php'; ?>
<?php require 'includes/connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title></title>
    <?php require 'resources.php';?>
    <link rel="stylesheet" href="css/style.css">
    <style>
    .reset_body{
      min-height: 250px;
    }
    </style>
</head>
<body>
    <?php require '_header.php'; ?>
      <?php require 'includes/alert_states.php';?>
      <div class="container-fluid reset_body">
        <form class="form form-horizontal container">
          <div class="form-group">
            <label for="username" class="col-xs-3 control-label">Username: </label>
            <div class="col-xs-9">
              <input type="text" id="username" name="username" class="form-control">

            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-xs-3 control-label">Email: </label>
            <div class="col-xs-9">
              <input type="email" id="email" name="email" class="form-control">

            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-xs-3 control-label">New Password: </label>
            <div class="col-xs-9">
              <input type="password" id="rst_password" name="rst_password" class="form-control">
            </div>
          </div>
          <div class="form-group has-feedback">
            <label for="confrm_password" class="col-xs-3 control-label">Confirm Password: </label>
            <div class="col-xs-9">
              <input type="password" id="confrm_password" name="confrm_password" class="form-control">
              <span class="form-control-feedback result_icn" aria-hidden="true"></span>
              <label class="result_txt"></label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary pull-right" name="Submit">Submit</button>
        </form>
      </div>
      <?php require '_footer.php';?>
      <?php require '_laundry_cart.php';?>
      <script src="js/script.js"></script>
  </body>
  </html>
