<?php
require '../config/start_session.php';
require '../config/processor.php';
require '../config/connection.php';

$alertColor = array('ok'=>'alert-success','nok'=>'alert-danger');
// Function to display Laundry Cart Modal or generat Checkout table for mail
function display_cart($laundry, $mail = false)
{
    global $count;
    $count = 0;
    $message = '<div ';
    $message .=  $mail ? "style='color: #000 !important; text-shadow: none !important; -webkit-box-shadow: none !important; box-shadow: none !important; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;'>" : "class='cart_init container-fluid'>";

    $message .= '<table ';
    $message .=  $mail ? "style='border-spacing: 0; border-collapse: collapse !important; color: #000 !important; text-shadow: none !important; -webkit-box-shadow: none !important; box-shadow: none !important; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; width: 50%; max-width: 100%; margin-bottom: 20px; min-height: .01%; overflow-x: auto; background: transparent; border: 1px solid #ddd;'>" : "class='table table-striped table-hover table-responsive table-bordered'>";

    $ths = array('S/N', 'Item', 'Num', 'Price', 'Total', 'Action');
    $message .= '<thead ';
    $message .= $mail ? "style='color: #000 !important; text-shadow: none !important; -webkit-box-shadow: none !important; box-shadow: none !important; display: table-header-group; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;'>" : '>';
    $message .= '<tr ';
    $message .= $mail ? "style='color: #000 !important; text-shadow: none !important; -webkit-box-shadow: none !important; box-shadow: none !important; page-break-inside: avoid; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;'>" : '>';
    foreach ($ths as $th) {
        if ($mail === true && $th === 'Action') {
            continue;
        }
        $message .= '<th ';
        $message .= $mail ? "style='color: #000 !important; text-shadow: none !important; -webkit-box-shadow: none !important; box-shadow: none !important; background-color: #fff !important; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; text-align: left; line-height: 1.42857143; vertical-align: bottom; padding: 8px; border: 1px solid #ddd;'>" : '>';
        $message .= "<p>$th</p></th>";
    }

    $message .= '</tr></thead><tbody>';

    $tdstyle = $mail ? 'color: #000 !important; text-shadow: none !important; -webkit-box-shadow: none !important; box-shadow: none !important; background-color: #fff !important; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; line-height: 1.42857143; vertical-align: top; padding: 8px; border: 1px solid #ddd;' : '';
    $pstyle = $mail ? 'color: #000 !important; text-shadow: none !important; -webkit-box-shadow: none !important; box-shadow: none !important; orphans: 3; widows: 3; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; margin: 0 0 10px;' : '';
    $sstyle = $mail ? 'font-size: 85%; color: #000 !important; text-shadow: none !important; -webkit-box-shadow: none !important; box-shadow: none !important; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; display: block; padding-left: 10px; font-weight: 600; font-style: italic;' : '';

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
                    <td style='$tdstyle'><p style='$pstyle'>$count</p></td>
                    <td style='$tdstyle'><p style='$pstyle'>$name<small class='text-info' style='$sstyle'>$category</small></p></td>
                    <td style='$tdstyle'><p style='$pstyle'>$quantity</p></td>
                    <td style='$tdstyle'><p style='$pstyle'>&#8358;$price</p></td>
                    <td style='$tdstyle'><p style='$pstyle'>&#8358;$total</p></td>";
        $message .= $mail ? '' : "<td><button type='button' onclick='remove_from_cart($(this))' class='btn btn-warning delete_item'>Delete</button>
                    <input type='hidden' name='cloth_id' class='cloth_id' value='$id'></td>";
        $message .= '</tr>';
    }
    $message .= '</tbody></table>
  </div>';

    return array('txt' => $message, 'count' => $count);
}

if (isset($_POST['send'])) {
    $id = secure($_POST['cloth_id']);
    
    $quantity = $_POST['quantity'];
    try {
        $sql = 'SELECT * FROM clothing WHERE clothing_id = :clothing_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':clothing_id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $errorInfo = $stmt->errorInfo();
        if ($stmt->rowCount() == 1) {
            $stmt->bindColumn('clothing_id', $clothing_id);
            $stmt->bindColumn('name', $name);
            $stmt->bindColumn('price', $price);
            $stmt->bindColumn('category', $category);

            $result = $stmt->fetch(PDO::FETCH_BOUND);
            $cart = array(
              'cloth_id' => $clothing_id,
              'name' => htmlspecialchars_decode($name),
              'price' => $price,
              'quantity' => $quantity,
              'category' => $category,
            );

//If laundry cart exist
  if (isset($_SESSION['user']['laundry_cart'])) {
      $cart_cloth_id = array_column($_SESSION['user']['laundry_cart'], 'cloth_id');

      if (!in_array($cart['cloth_id'], $cart_cloth_id)) { // if item isn't in laundry cart
        array_push($_SESSION['user']['laundry_cart'], $cart);
      } else {
          foreach ($_SESSION['user']['laundry_cart'] as $key => $cart_item) {
              if ($cart['cloth_id'] === $cart_item['cloth_id']) {
                  $_SESSION['user']['laundry_cart'][$key]['quantity'] = $cart_item['quantity'] + $quantity;
              }
          }
      }
      echo json_encode(display_cart($_SESSION['user']['laundry_cart']),JSON_UNESCAPED_SLASHES);
  } else { // If It doesn't exist , initialize
    $_SESSION['user']['laundry_cart'][0] = $cart;
      echo json_encode(display_cart($_SESSION['user']['laundry_cart']),JSON_UNESCAPED_SLASHES);
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
    foreach ($_SESSION['user']['laundry_cart'] as $key => $cart) {
        if ($cart['cloth_id'] === $id) {
            unset($_SESSION['user']['laundry_cart'][$key]);
        }
    }
    array_values($_SESSION['user']['laundry_cart']);
    echo json_encode(display_cart($_SESSION['user']['laundry_cart']),JSON_UNESCAPED_SLASHES);
}

#Prepare Laundry cart modal for display
if (isset($_POST['view'])) {
    if (isset($_SESSION['user']['laundry_cart']) && count($_SESSION['user']['laundry_cart']) > 0) {
        echo json_encode(display_cart($_SESSION['user']['laundry_cart']));
    } else {
        echo json_encode(array('txt' => '<p>Laundry Cart is currently empty</p>', 'count' => 0),JSON_UNESCAPED_SLASHES);
    }
}

#Empty Laundry cart
if (isset($_POST['clear'])) {
    // session_destroy();
    unset($_SESSION['user']['laundry_cart']);
    echo json_encode(array('txt' => '<p>Laundry Cart is currently empty</p>', 'count' => 0),JSON_UNESCAPED_SLASHES);
}

#Checks out laundry cart
if (isset($_POST['checkout'])) {
    if (confirm_logged_in() === false) {
        echo json_encode(array('txt' => 'Please log in to access checkout function','color'=>$alertColor['nok'], 'code' => '!logged'));
        exit;
    }
    try {
      //Gets Admin mail from database
      $Bcc = '';

      $sql = "SELECT * FROM admin WHERE mailReceiver = '1'";
      $stmt = $pdo->query($sql);
      $stmt->bindColumn('email', $adminemail);

      if ($stmt->rowCount() == 0) {
          $Bcc = 'garuav@gmail.com';
      } elseif ($stmt->rowCount() >= 1) {
          $count = 0;
          while ($stmt->fetch(PDO::FETCH_BOUND)) {
            $count++;
              if ($count == 1) {
              $Bcc = "$adminemail";
            } elseif ($count > 1) {
                  $Bcc .= ",$adminemail";
              }
          }
      }

//Get User details
        $sql = 'SELECT * FROM users WHERE name = :name AND email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $_SESSION['user']['username'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $_SESSION['user']['email'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            $stmt->bindColumn('id', $id);
            $stmt->bindColumn('name', $username);
            $stmt->bindColumn('email', $email);
            $stmt->bindColumn('address', $address);
            $stmt->bindColumn('phone', $phone);

            $stmt->fetch(PDO::FETCH_BOUND);

      #Mail Processor
      $to = "{$Bcc}";#Admin or Manager
      $subject = "$username Laundry Cart";
            $message = "<p>$username</p>
                  <p>Email: $phone</p>
                  <p>Phone Number: $phone</p>
                  <p>Address: $address</p>";
            $message .= display_cart($_SESSION['user']['laundry_cart'], true)['txt'];
            $headers = array();
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = "From: $username <$email>";
            $headers[] = "To: $Bcc";
            $headers[] = "Bcc: {$Bcc}";
            $headers[] = "Subject: {$subject}";

            if (mail($to, $subject, $message, implode("\r\n", $headers))) {
                $cart = json_encode($_SESSION['user']['laundry_cart']);
                try {
                    $sql = 'INSERT INTO checkout_history(usr_id,name,date,cart) VALUES(:usr_id,:name,NOW(),:cart)';
                    $stmt = $pdo->prepare($sql);
                    $stmt->BindParam(':usr_id', $id, PDO::PARAM_INT);
                    $stmt->BindParam(':name', $username, PDO::PARAM_STR);
                    $stmt->BindParam(':cart', $cart, PDO::PARAM_STR);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        unset($_SESSION['user']['laundry_cart']);
                        echo json_encode(array('txt' => 'Thanks for using our services. You have successfully checked out your laundry cart.', 'code' => 'logged', 'count' => 0,'color'=>$alertColor['ok']));
                    } else {
                        echo json_encode(array('txt' => 'Unable to complete Transaction process. Please try again', 'code' => 'logged','color'=>$alertColor['nok']));
                    }
                } catch (PDOException $e) {
                    $error = $e->getMessage();
                }
            } else {
                echo json_encode(array('txt' => 'Unable to complete Check out process. Please try again', 'code' => 'logged','color'=>$alertColor['nok']));
            }
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
