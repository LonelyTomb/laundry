<?php require '../includes/processor.php';?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin</title>
    <?php $ld = getLevelDeepness(1); require '../resources.php';?>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php
    if (!isset($_SESSION['admin'])) {
        echo'
    ';
    }
    ?>
    <div class='container-fluid'>
      <div class="col-sm-3 pull-left hidden-xs toolbar">
        <div>
          <h3 class='adminHeader'>Admin Section</h3>
        </div>
        <div class='adminLinks'>
        <a href="#" class=""><p class=''>Log Out</p></a>
        <a href="#" class=""><p class=''>Edit Current Admin Profile</p></a>
        <a href="#" class=""><p class=''>Add New Admin</p></a>
        <a class="" data-toggle="collapse" href="#categories" aria-expanded="false" aria-controls="categories"><p class=''>Check Categories</p></a>
        <div class="collapse categories" id="categories">
          <a href=""><p>Men</p></a>
          <a href=""><p>Ladies</p></a>
          <a href=""><p>Household</p></a>
        </div>
        <a href="#" class=""><p class=''>Create New Product</p></a>
        </div>
      </div>
      <div class="col-sm-8 pull-right">
      <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-3">Admin Section</h1>
          <p class="lead">Restricted Access!!!</p>
        </div>
      </div>
      <form action='' class='form form-horizontal'>
        <div class='formgroup row'>
          <label for="email" class="control-label col-sm-3">Email</label>
          <div class="col-sm-4">
            <input type="email" id="email" class="form-control" name="email">
          </div>
        </div>
        <div class='formgroup row'>
          <label for="pwd" class="control-label col-sm-3">Password</label>
          <div class="col-sm-4">
            <input type="password" id="pwd"class="form-control" name="pwd">
          </div>
        </div>
      </form>
      </div>
    </div>
  </body>
</html>
