<?php
try{
$pdo = new PDO("mysql:host=localhost;dbname=laundry", "root","Spellingbee@1");
}catch(PDOException $e){
  $error = $e->getMessage();
  // die ($error);
}
 ?>
