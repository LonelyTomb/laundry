<?php require '../config/start_session.php';?>
<?php require '../config/processor.php';?>
<?php require '../config/connection.php';?>
<?php require '../config/token.php';?>
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
    <div class='container-fluid'>
      <?php
      if(confirm_admin() == true){
        require 'parts/_toolbar.php';
      }
      ?>
      <div class="col-xs-8 col-xs-offset-3">

    <?php
      if(confirm_admin() === false){
        require 'parts/_login.php';
      }else if (confirm_admin() === true && isset($_GET['create_admin'])) {
        require 'parts/_create_new_admin.php';
      }else if(confirm_admin() === true && isset($_GET['edit_admin'])){
        require 'parts/_edit_admin.php';
      }else if(confirm_admin() === true && isset($_GET['categories']) || isset($_GET['category'])){
            if(isset($_GET['categories']) && $_GET['categories'] == ''){
                require 'parts/_display_categories.php';
              }else if(isset($_GET['category']) && $_GET['category'] !== ''){
                require 'parts/_display_product.php';  
                }    
      }elseif(confirm_admin() === true && isset($_GET["create_product"])){
                require 'parts/_create_new_product.php';  
      }else{      
        $username = $_SESSION['admin']['username'];
        echo "<div class='jumbotron jumbotron-fluid'>
        <div class='container'>
          <h1 class='display-3'>Admin Section</h1>
          <hr class='m-y-2'/>
          <p class='lead'>Admin {$username}  Currently logged in.</p><p class='m-b-0'> Click on one of the various links to proceed</p>
        </div>
      </div>";
    }
    ?>
  </div>
  </div>
    <script src="script.js"></script>
  </body>
</html>
