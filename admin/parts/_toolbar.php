<div class="col-xs-3 pull-left well toolbar">
  <div>
    <h3 class='adminHeader '><a href="index.php" class="">Admin</a></h3>
  </div>
  <div class='adminLinks'>
  <div><a href="index.php?log_out" class=""><p class=''>Log Out</p></a></div>
  <div><a href="index.php?edit_admin" class=""><p class=''>Edit Profile</p></a></div>
  <div><a href="index.php?create_admin" class=""><p class=''>Add New Admin</p></a></div>
  <div><a class="" href="index.php?categories"><p class=''>Check Categories </p></a><span class='collapseArrow pull-right'>&ddarr;</span></div>
  <div class="categories collapse <?php $toggle_collapse = isset($_GET['category']) ? 'in': '';echo $toggle_collapse;?>" id="categories">
    <?php try {#displays categories existing in database
        $sql = 'SELECT * FROM category';
        $stmt = $pdo->query($sql);
        $stmt->bindColumn('name', $name);
        while ($result = $stmt->fetch(PDO::FETCH_BOUND)) {

            echo "<a href='index.php?category=$name&token=".get_token()."'><p>$name</p></a>";
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    } ?>
  </div>
  <div><a href="index.php?create_product" class=""><p class=''>Create New Product</p></a></div>
  </div>
</div>
