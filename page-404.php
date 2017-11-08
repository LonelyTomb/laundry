<?php require('config/processor.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Washman</title>
    <?php $ld= getLevelDeepness(0);require 'resources.php';?>
    <style>
    .container{
            margin: 10% auto;
        min-height:480px;
    }</style>
</head>
<body>
<div class="container">
<div class="jumbotron jumbotron-fluid">
  <h1 class="display-3"><?php echo http_response_code();?>!</h1>
  <?php
  if (http_response_code() === 404){
  echo '<p class="lead">The page can not be found</p>
  <p class="lead">The page you are looking for might have been removed, <br> had its name changed or is temporarily unavailable.</p>';
}else if(http_response_code() === 403){
  echo '<p class="lead">The page could not be displayed</p>
  <p class="lead">You are currently unable to view this page.</p>';
}  ?>

</div>
</div>
</body>
</html>
