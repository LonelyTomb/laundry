<?php
require '../includes/validate.php';
/************************************/
/*******  Displays Products *********/
/************************************/
if(isset($_POST['display_product'])){
  $id = secure($_POST['id']);

  try {
        $stmt = $pdo->query('SELECT * FROM category');
        $stmt->bindColumn('name',$ctgy);
        $count = 0;
        $allctgy = array();
        while($stmt->fetch(PDO::FETCH_BOUND)){
            $count++;
            $allctgy[$count] = $ctgy  ;
        }

        $sql = 'SELECT * FROM clothing WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->bindColumn('id', $id);
        $stmt->bindColumn('clothing_id', $clothing_id);
        $stmt->bindColumn('name', $name);
        $stmt->bindColumn('category', $category);
        $stmt->bindColumn('price', $price);
        if ($stmt->rowCount() == 1) {
            $stmt->fetch(PDO::FETCH_BOUND);
            $name = htmlspecialchars_decode($name);
            echo json_encode(array('clothing_id' => $clothing_id,'name'=>"$name",'category'=>"$category",'price'=>$price, 'id' => $id,"allctgy"=>$allctgy));
            exit;
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
   
    
/************************************/
/*******  Edits Selected Product *****/
/************************************/
if(isset($_POST['edit_product'])){
    // echo json_encode($_POST);
    $clothing_id = secure($_POST['clothing_id']);
    $name = secure($_POST['name']);
    $category = secure($_POST['category']);
    $price = secure($_POST['price']);
    $id = secure($_POST['id']);
    $edit_product = secure($_POST['edit_product']);
    if(!preg_match('/^[0-9]\d/',$price)){
     echo json_encode(array('txt'=>'<p>Enter a valid price</p>','color'=>$alertColor['nok']),JSON_UNESCAPED_SLASHES);
            exit;   
    }
    try{

        $sql = "UPDATE clothing SET clothing_id=:clothing_id,name=:name,category=:category,price=:price WHERE id=:id";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':clothing_id',$clothing_id,PDO::PARAM_STR);
        $stmt->bindParam(':name',$name,PDO::PARAM_STR);
        $stmt->bindParam(':category',$category,PDO::PARAM_STR);
        $stmt->bindParam(':price',$price,PDO::PARAM_STR);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() == 1){
            echo json_encode(array('txt'=>'Product Details Successfully Updated','color'=>$alertColor['ok']),JSON_UNESCAPED_SLASHES);
            exit;
        }elseif($stmt->rowCount() == 0){
            echo json_encode(array('txt'=>'<p>Product Details Unchanged</p>','color'=>$alertColor['info']),JSON_UNESCAPED_SLASHES);
            exit;
        }
    }catch(PDOException $e){
          $error = $e->getMessage();              
    }
}

/************************************/
/*******  Creates New Product *****/
/************************************/
if(isset($_POST['create_product'])){
    $product['clothingId'] = secure($_POST['clothing_id']);
    $product['name'] = secure($_POST['name']);
    $product['category'] = secure($_POST['category']);
    $product['price'] = secure($_POST['price']);

    foreach($product as $key => $pd){
        if(strlen($pd) == 0){
         echo json_encode(array('txt'=>"<p>Incorrect {$key} Entered</p>",'color'=>$alertColor['nok']),JSON_UNESCAPED_SLASHES);
            exit;   
        }
    }
    if(!preg_match('/^[0-9]\d/',$product['price'])){
     echo json_encode(array('txt'=>'<p>Enter a valid price</p>','color'=>$alertColor['nok']),JSON_UNESCAPED_SLASHES);
            exit;   
    }
    try{
//Checks if Product Id or Name already exists        
        $sql = 'SELECT * FROM clothing WHERE clothing_id=:clothing_id';
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':clothing_id',$product['clothingId'],PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() == 1){          
            echo json_encode(array('txt'=>'<p>Product already exists. Please Enter a different product id</p>','color'=>$alertColor['nok']),JSON_UNESCAPED_SLASHES);
            exit;
        }

        $sql = "INSERT INTO clothing(clothing_id, name,category,price) VALUES(:clothing_id,:name,:category,:price)";
        $stmt=$pdo->prepare($sql);

        $stmt->bindParam(':clothing_id',$product['clothingId'],PDO::PARAM_STR);
        $stmt->bindParam(':name',$product['name'],PDO::PARAM_STR);
        $stmt->bindParam(':category',$product['category'],PDO::PARAM_STR);
        $stmt->bindParam(':price',$product['price'],PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() === 1){
        echo json_encode(array('txt'=>"<p>Product succesfully created!</p>",'color'=>$alertColor['ok']),JSON_UNESCAPED_SLASHES);
        exit;   
        }
    }catch(PDOException $e){
    $error = $e->getMessage();
        }
        
        
}
/************************************/
/****  Deletes Selected Product *****/
/************************************/
if(isset($_POST['delete_product'])){
        $id = secure($_POST['id']);
        try{
        $sql ="DELETE FROM clothing WHERE id =:id;";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            echo json_encode(array('txt'=>'<p>Product Successfully Deleted</p>','color'=>$alertColor['ok']),JSON_UNESCAPED_SLASHES);
            exit;
        }else{
            echo json_encode(array('txt'=>'<p>Unable to delete Product</p>','color'=>$alertColor['nok']),JSON_UNESCAPED_SLASHES);
            exit;
        }
       
    }catch(PDOException $e){
        $error=$e->getMessage();
    }
    
}


/************************************/
/****  Deletes Multiple Products *****/
/************************************/
if(isset($_POST['delete_products'])){
    $check = explode(',',$_POST['check']);
    try{
        $sql = '';
        foreach($check as $id){
            $id=secure($id);
            $sql.="DELETE FROM clothing WHERE id =$id;";
        }
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            echo json_encode(array('txt'=>'<p>Product(s) Successfully Deleted</p>','color'=>$alertColor['ok']),JSON_UNESCAPED_SLASHES);
            exit;
        }else{
            echo json_encode(array('txt'=>'<p>Unable to delete Product(s)</p>','color'=>$alertColor['nok']),JSON_UNESCAPED_SLASHES);
            exit;
        }
       
    }catch(PDOException $e){
        $error=$e->getMessage();
    }
    
}