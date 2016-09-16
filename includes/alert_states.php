<?php
if(isset($_GET['status'])){
  $color = $_GET['status'] == 'success' ? "alert-success":"alert-danger";
  $icon = $_GET['status'] == 'success' ? "glyphicon-ok-sign":"glyphicon-exclamation-sign";
  $message = "<div class='container-fluid'><div class='alert $color alert-dismissible text-center' role='alert'>
        <button type='button' class='close close_alert' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><span class='glyphicon $icon' aria-hidden='true'></span>";
  if($_GET['status'] =='success' && $_GET['code'] =='account'){
  $message .="<strong>Account Registeration Successful!</strong>";
}
if($_GET['status'] =='success' && $_GET['code'] =='logged_in'){
$message .="<strong>Log In Process Successful!</strong>";
}
if($_GET['status'] =='error' && $_GET['code'] =='name'){
  $message .="<strong>Invalid Username!</strong>";
}
if($_GET['status'] =='error' && $_GET['code'] =='email'){
  $message .="<strong>Invalid Email!</strong>";
}
if($_GET['status'] =='error' && $_GET['code'] =='phone'){
  $message .="<strong>Invalid Telephone number!</strong>";
}
if($_GET['status'] =='error' && $_GET['code'] =='address'){
  $message .="<strong>Invalid Address!</strong>";
}
if($_GET['status'] =='error' && $_GET['code'] =='password'){
  $message .="<strong>Invalid Password!</strong>";
}
if($_GET['status'] =='error' && $_GET['code'] =='not_logged'){
  $message .="<strong>The combination of the email and password entered is incorrect!</strong>";
}
  $message.="</div></div>";
  echo $message;
}
 ?>
