<?php require 'config/start_session.php';
require 'config/processor.php';
require 'config/connection.php';
?>

<?php
phpinfo();
// try {
//     //Gets Admin mail from database
//     $Bcc = '';

//     $sql = "SELECT * FROM admin WHERE mailReceiver = '1'";
//     $stmt = $pdo->query($sql);
//     $stmt->bindColumn('email', $adminemail);

//     if ($stmt->rowCount() == 0) {
//         $Bcc = 'garuav@gmail.com';
//     } elseif ($stmt->rowCount() >= 1) {
//         $count = 0;
//         while ($stmt->fetch(PDO::FETCH_BOUND)) {
//           $count++;
//             if ($count == 1) {
//             $Bcc = "$adminemail";
//           } elseif ($count > 1) {
//                 $Bcc .= ",$adminemail";
//             }
//         }
//     }
// //Get User details
//     $sql = 'SELECT * FROM users WHERE name = :name AND email = :email';
//     $stmt = $pdo->prepare($sql);
//     $stmt->bindParam(':name', $_SESSION['user']['username'], PDO::PARAM_STR);
//     $stmt->bindParam(':email', $_SESSION['user']['email'], PDO::PARAM_STR);
//     if ($stmt->execute()) {
//         $stmt->bindColumn('id', $id);
//         $stmt->bindColumn('name', $username);
//         $stmt->bindColumn('email', $email);
//         $stmt->bindColumn('address', $address);
//         $stmt->bindColumn('phone', $phone);

//         $stmt->fetch(PDO::FETCH_BOUND);

//   #Mail Processor
//   $to = 'noreply@havendaplus.com';#Admin or Manager
//   $subject = "$username Laundry Cart";
//         $message = "<p>$username</p>
//               <p>Email: $phone</p>
//               <p>Phone Number: $phone</p>
//               <p>Address: $address</p>";
//         // $message .= display_cart($_SESSION['laundry_cart'], true)['txt'];
//         $headers = array();
//         $headers[] = "MIME-Version: 1.0";
//         $headers[] = "Content-type: text/html; charset=iso-8859-1";
//         $headers[] = "From: $username <{$email}>";
//         $headers[] = 'To: Washman <noreply@havendaplus.com>';
//         $headers[] = "Bcc: {$Bcc}";
//         $headers[] = "Subject: {$subject}";
// // print_r($headers);
//         if (mail($to, $subject, $message, implode("\r\n", $headers))) {
//             $cart = json_encode($_SESSION['laundry_cart']);
//             try {
//                 $sql = 'INSERT INTO checkout_history(usr_id,name,date,cart) VALUES(:usr_id,:name,NOW(),:cart)';
//                 $stmt = $pdo->prepare($sql);
//                 $stmt->BindParam(':usr_id', $id, PDO::PARAM_INT);
//                 $stmt->BindParam(':name', $username, PDO::PARAM_STR);
//                 $stmt->BindParam(':cart', $cart, PDO::PARAM_STR);
//                 $stmt->execute();
//                 if ($stmt->rowCount() > 0) {
//                     unset($_SESSION['laundry_cart']);

//                     echo json_encode(array('txt' => 'Thanks for using our services. You have successfully checked out your laundry cart.', 'code' => 'logged', 'count' => 0));
//                 } else {
//                     echo json_encode(array('txt' => 'Unable to complete Transaction process. Please try again', 'code' => 'logged'));
//                 }
//             } catch (PDOException $e) {
//                 $error = $e->getMessage();
//             }
//         } else {
//             echo json_encode(array('txt' => 'Unable to complete Check out process. Please try again', 'code' => 'logged'));
//         }
//     }
// } catch (PDOException $e) {
//     $error = $e->getMessage();
// }
 ?>
