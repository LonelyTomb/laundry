<?php
require "processor.php";

if(!isset($_SESSION['laundry_cart'])){
  echo "0";
}else{
  echo count($_SESSION['laundry_cart']);
}
 ?>
