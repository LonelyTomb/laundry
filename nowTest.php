<?php require 'includes/start_session.php';?>
<?php require "includes/connection.php"; ?>
<?php require "includes/process_cart.php"; ?>

<?php
$stmt = $pdo->query("SELECT * FROM users");
$stmt->bindColumn('name' ,$name);
  $stmt->fetch(PDO::FETCH_BOUND);
echo display_cart($_SESSION['laundry_cart'],true)['txt'];



// $pdo = new PDO('mysql:host=localhost;dbname=wg', 'root', 'Spellingbee@1');
// try {
//     if($pdo->exec("INSERT INTO test (date) VALUES(NOW())")){
//         echo 'done';
//     }else{
//         $errorInfo = $pdo->errorInfo();
//         echo ($errorInfo[2]);
//         // echo 'error';
//     }
// } catch (PDOException $e) {
//     $error = $e->getMessage();
//     echo $error;
// }

// $to = 'vgaruba@ymail.com';
// $subject = 'PHP mail tester';
// $message = '<p>
// This message was sent via PHP!
// </p>'.'<p>Some other message text.</p>'.'<p>
// -- signature
// </p>';
// $headers = "MIME-Version: 1.0\r\n";
// $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
// $headers .= "From: Victory <garubav@gmail.com>\r\n" .
//            "To: Victory <vgaruba@ymail.com>\r\n";
//
// if (mail($to, $subject, $message, $headers)) {
//   echo 'mail() Success!';
// }
// else {
//   echo 'mail() Failed!';
// }
