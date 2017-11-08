<?php require 'config/start_session.php';?>
<?php require "config/processor.php"; ?>
<?php require "config/connection.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Washman</title>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php require 'resources.php';?>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "_header.php"; ?>
    <div class="container-fluid">
        <div class="mainalertBlock"></div>
        <div id="carousel-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-generic" data-slide-to="1"></li>
                <li data-target="#carousel-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img src="images/image2.jpg" alt="" class="carousel-image img-responsive ">
                    <div class="carousel-caption">

                    </div>
                </div>
                <div class="item">
                    <img src="images/image1.jpg" alt="" class="carousel-image img-responsive ">
                    <div class="carousel-caption">

                    </div>
                </div>
                <div class="item">
                    <img src="images/image3.jpg" alt="" class="carousel-image img-responsive ">
                    <div class="carousel-caption">

                    </div>
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>

    <div class="container orders">
      <?php
      // var_dump($_SESSION);
      require 'includes/display_categories.php';
        if (!isset($_GET['category'])) {
            display_category();
        } else {
            display_category($_GET['category']);
        }
        ?>
    </div>
    <?php require "_footer.php";?>
<?php
if(confirm_logged_in() === false){
    #<!-- Sign In -->
     require "_sign_in.php";
    #<!-- Sign Up  Modal--
     require "_sign_up.php";
}
?>
    <!-- // display cart -->
    <?php require "_laundry_cart.php";?>
    <script src="js/script.js"></script>
</body>
</html>
