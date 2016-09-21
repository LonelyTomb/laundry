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
