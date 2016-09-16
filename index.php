<?php require 'includes/start_session.php';?>
<?php require "includes/processor.php"; ?>
<?php require "includes/connection.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title></title>
    <?php require 'resources.php';?>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container-fluid">
        <header>
            <div class="page-header clearfix">
                <div class="col-md-3 col-xs-12 pull-left">
                    <h1 class="text-center">Laundry</h1>
                </div>
                <div class="col-md-4 col-md-offset-1 col-xs-offset-1 log_on">
                    <ul class="nav nav-pills text-center">
                      <?php
                      if (!isset($_SESSION['logged'])) {
                          echo "<li><a class='btn btn-info' data-toggle='modal' data-target='#logIn'>Log in</a></li>
                        <li><a class='btn btn-primary' data-toggle='modal' data-target='#signUp'>Sign Up</a></li>";
                      } else {
                          echo "<li><a href='index.php?log_out' class='btn btn-danger'>Log out</a></li>";
                      }
?>
                    </ul>
                </div>
                <div class="col-md-2 col-xs-12 pull-right cart dropdown">
                    <a data-target="#laundry_cart" class="btn" data-toggle="modal" onclick="view_cart()"><h4 class="text-center">Cart: <span class="num_of_items"><?php if(isset($_SESSION['laundry_cart'])){
                        echo count($_SESSION['laundry_cart']);
                    }else{
                        echo "0";
                    }?></span></h4></a>
                </div>

            </div>
            <nav class="navbar navbar-default navbar-fixed-top navbar-inverse " role="navigation">
                <div class="">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-content">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="index.php" class="navbar-brand">Home</a>
                    </div>

                    <div class="collapse navbar-collapse" id="navbar-content">
                        <ul class="nav navbar-nav">
                            <?php
                            try {
                                $sql = 'SELECT * FROM category';
                                $stmt = $pdo->query($sql);
                                $stmt->bindColumn('name', $name);
                                while ($result = $stmt->fetch(PDO::FETCH_BOUND)) {
                                    echo "<li><a href='index.php?category=$name'>$name</a></li>";
                                }
                            } catch (PDOException $e) {
                                $error = $e->getMessage();
                                $result = array();
                            }

                             ?>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>

                </div>

            </nav>
        </header>
    </div>

      <?php require 'includes/alert_states.php';?>
    <div class="container-fluid">
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
      require 'includes/display_categories.php';
        if (!isset($_GET['category'])) {
            display_category();
        } else {
            display_category($_GET['category']);
        }
        ?>
        <div class="add_to_cart">
            <button type="button" class="pull-right btn btn-success" onclick="view_cart()" data-target="#laundry_cart" data-toggle="modal" name="button">View Cart</button>
        </div>
    </div>
    <footer class="container-fluid">
        <div class="col-md-6 col-xs-12 pull-left">
            <h4 class="page-header">Laundry...</h4>
            <ul class="nav nav-pills">
                <li><a href="" class="text-muted">About Us</a></li>
                <li><a href="" class="text-muted">Delivery</a></li>
                <li><a href="" class="text-muted">Terms &amp; Conditions</a></li>
            </ul>
        </div>
        <div class="col-md-6 col-xs-12 pull-right">
            <h4 class="page-header">Account...</h4>
            <ul class="nav nav-pills">
                <li><a href="" class="text-muted">My Account</a></li>
                <li><a href="" class="text-muted">Order History</a></li>
            </ul>
        </div>
    </footer>

    <!-- Sign In -->
    <div class="modal fade signIn" role="dialog" id="logIn">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-center">Log In</h3>
                </div>

                <div class="modal-body">
                    <form class="form form-horizontal" action="includes/sign_in.php" method="post">
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
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="log_in">Log In</button>
                        <button type="button" class="btn btn-warning" name="button" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Sign Up -->
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

    <!-- // display cart -->
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
                    <button type="button" name="button" onclick="" class="chk_out btn btn-success pull-left">Checkout</button>
                    <button type="button" name="button" onclick="clear_cart()" class="clear_cart btn btn-danger">Empty Cart</button>
                    <button type="button" class="btn btn-warning" name="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

</html>
