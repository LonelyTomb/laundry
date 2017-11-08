<?php
require '../includes/validate.php';
//Display Category modal
if (isset($_POST['display_ctgy'])) {
    $name = secure($_POST['name']);
    try {
        $sql = 'SELECT * FROM category WHERE name = :name';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        $stmt->bindColumn('name', $category);
        $stmt->bindColumn('id', $id);
        if ($stmt->rowCount() == 1) {
            $stmt->fetch(PDO::FETCH_BOUND);
            echo json_encode(array('txt' => "{$category}", 'id' => $id));
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
//Creates category
if (isset($_POST['create'])) {
    
  $name = strtolower(secure($_POST['name']));
  if(empty($name)){
    echo json_encode(array('txt' => 'Invalid category name!','color' => $alertColor['nok']));
    exit;
  }
    try {
        //Ensures category doesn't exist
        $sql = 'SELECT * FROM category WHERE name=:name';
         $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            echo(json_encode(array('txt'=>'Category already exist','color'=>$alertColor['nok'])));
            exit;
        }

        
        $sql = 'INSERT INTO category(name) VALUES(:name)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name,PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            echo json_encode(array('txt' => "{$name} category successfully created!",'color' => $alertColor['ok']));
        } else {
            echo json_encode(array('txt' => 'Unable to complete request! Please Try again.','color' => $alertColor['nok']));
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}

//Edit Category
if (isset($_POST['edit_ctgy'])) {
    
    $name = strtolower(secure($_POST['name']));
    $check = secure($_POST['check']);
    $id = secure($_POST['id']);
    try {
        // Stores previous category name
        $sql = 'SELECT name FROM category WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->bindColumn('name', $pre_name);//Previous Category Name
        $stmt->fetch(PDO::FETCH_BOUND);

        //Updates category name
        $sql = 'UPDATE category SET name=:name WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            if ($check == 1) {
                $sql = 'UPDATE clothing SET category=:category WHERE category=:pre_name';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':category', $name, PDO::PARAM_STR);
                $stmt->bindParam(':pre_name', $pre_name, PDO::PARAM_STR);

                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    echo json_encode(array('txt' => '<p>Category Name Updated</p> <p>Products Associated Successfully Updated In Database.</p>','color' => $alertColor['ok']), JSON_UNESCAPED_SLASHES);
                    exit;
                } else {
                    echo json_encode(array('txt' => '<p>Category Name Updated</p><p>No Products Associated with category found in database!</p>','color' => $alertColor['ok']), JSON_UNESCAPED_SLASHES);
                    exit;
                }
            } else {
                echo json_encode(array('txt' => 'Category Name Successfully Updated.','color' => $alertColor['ok']));
                exit;
            }
        } elseif ($stmt->rowCount() == 0) {
            echo json_encode(array('txt' => '<p>Category Name Unchanged!</p>','color' => $alertColor['info']), JSON_UNESCAPED_SLASHES);
            exit;
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}

// Delete Category
if(isset($_POST['delete_ctgy'])){
  $name = secure($_POST['name']);
  $check = secure($_POST['check']);
  $id = secure($_POST['id']);
try{
  $sql = 'DELETE FROM category WHERE id = :id AND name=:name';
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();

  if($stmt->rowCount() > 0 ){
    if($check == 1){
        $sql = 'DELETE FROM clothing WHERE category=:category';
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':category',$name,PDO::PARAM_STR);
        $stmt->execute();
        echo json_encode(array('txt' => '<p>Category Successfully Deleted.</p><p>Products Associated Deleted</p>','color' => $alertColor['ok']),JSON_UNESCAPED_SLASHES);
      exit;      
    }else{
      echo json_encode(array('txt' => '<p>Category Successfully Deleted.</p><p>Products Associated Untouched</p>','color' => $alertColor['ok']),JSON_UNESCAPED_SLASHES);
      exit;
    }
  }else{
    echo json_encode(array('txt' => '<p>Category not Found!</p>','color' => $alertColor['nok']), JSON_UNESCAPED_SLASHES);
    exit;
  }
}catch(PDOException $e){
  $error= $e->getMessage();
}
}
