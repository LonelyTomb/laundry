<?php
require 'start_session.php';
require 'processor.php';
require 'connection.php';

function display_cart($laundry)
{
    global $count;
    $count = 0;
    $message = "<div class='cart_init container-fluid'>
    <table class='table table-striped table-hover table-responsive table-bordered'>
      <thead>
      <tr>
      <th class='col-xs-1'><p>S/N</p></th>
      <th class='col-xs-3'><p>Item</p></th>
      <th class='col-xs-2'><p>Num</p></th>
      <th class='col-xs-2'><p>Price</p></th>
      <th class='col-xs-2'><p>Total</p></th>
      <th class='col-xs-2'><p>Action</p></th>
      </tr>
      </thead>
      <tbody>";
        foreach ($laundry as $key => $cart_item) {
            $count += 1;
            $id = $cart_item['cloth_id'];
            $name = $cart_item['name'];
            $quantity = $cart_item['quantity'];
            $category = $cart_item['category'];
            $price = number_format($cart_item['price']);
            $total = $cart_item['quantity'] * $cart_item['price'];
            $total = number_format($total);
            $message .= "<tr>
                    <td><p>$count</p></td>
                    <td><p>$name<small class='text-info'>$category</small></p></td>
                    <td><p>$quantity</p></td>
                    <td><p>₦$price</p></td>
                    <td><p>₦$total</p></td>
                    <td><button type='button' onclick='remove_from_cart($(this))' class='btn btn-warning delete_item'>Delete</button>
                    <input type='hidden' name='cloth_id' class='cloth_id' value='$id'></td>
                    </tr>";
        }
    $message .= '</tbody></table>
  </div>';

    return array('txt' => $message, 'count' => $count);
}

if (isset($_POST['send'])) {
    $id = secure($_POST['cloth_id']);

    $name = strtr(secure($_POST['name']), '-', '&');
    $quantity = $_POST['quantity'];
    try {
        $sql = 'SELECT * FROM clothing WHERE name =:name AND clothing_id = :clothing_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':clothing_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $errorInfo = $stmt->errorInfo();
        if (isset($errorInfo[2])) {
            $_SESSION['debug'] = $errorInfo[2];
        }

        if ($stmt->rowCount() == 1) {
            $stmt->bindColumn('clothing_id', $clothing_id);
            $stmt->bindColumn('name', $name);
            $stmt->bindColumn('price', $price);
            $stmt->bindColumn('category', $category);

            $result = $stmt->fetch(PDO::FETCH_BOUND);
            $cart = array(
              'cloth_id' => $clothing_id,
              'name' => $name,
              'price' => $price,
              'quantity' => $quantity,
              'category' => $category,
            );

//If laundry cart exist
  if (isset($_SESSION['laundry_cart'])) {
      $cart_cloth_id = array_column($_SESSION['laundry_cart'], 'cloth_id');

      if (!in_array($cart['cloth_id'], $cart_cloth_id)) { // if item isn't in laundry cart
        array_push($_SESSION['laundry_cart'], $cart);
      } else {
          foreach ($_SESSION['laundry_cart'] as $key => $cart_item) {
              if ($cart['cloth_id'] === $cart_item['cloth_id']) {
                  $_SESSION['laundry_cart'][$key]['quantity'] = $cart_item['quantity'] + $quantity;
              }
          }
      }
      echo json_encode(display_cart($_SESSION['laundry_cart']));
  } else { // If It doesn't exist , initialize
    $_SESSION['laundry_cart'][0] = $cart;
      echo json_encode(display_cart($_SESSION['laundry_cart']));
  }
        } else {
            exit;
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}

#Deletes an  item from the laundry cart
if (isset($_POST['id'])) {
    $id = secure($_POST['id']);
    foreach ($_SESSION['laundry_cart'] as $key => $cart) {
        if ($cart['cloth_id'] === $id) {
            unset($_SESSION['laundry_cart'][$key]);
        }
    }
    array_values($_SESSION['laundry_cart']);
    echo json_encode(display_cart($_SESSION['laundry_cart']));
}
#Prepare Laundry cart modal for display
if (isset($_GET['view'])) {
    if (isset($_SESSION['laundry_cart']) && count($_SESSION['laundry_cart']) > 0) {
        echo json_encode(display_cart($_SESSION['laundry_cart']));
    } else {
        echo json_encode(array('txt' => '<p>Laundry Cart is currently empty</p>', 'count' => '0'));
    }
}

#Empty Laundry cart
if (isset($_POST['clear'])) {
    // session_destroy();
    unset($_SESSION['laundry_cart']);
    echo json_encode(array('txt' => '<p>Laundry Cart is currently empty</p>', 'count' => '0'));
}
#Checks out laundry cart
if(isset($_POST['checkout'])){
  if(!confirm_logged_in()){
    echo json_encode(array("error"=>"Not Logged in!","code"=>"!logged"));
  }
}
