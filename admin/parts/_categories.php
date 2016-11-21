<?php
if(isset($_GET['categories']) && $_GET['categories'] == ''){
  require '_display_categories.php';
}else if(isset($_GET['category']) && $_GET['category'] !== ''){
  require '_display_product.php';  
}