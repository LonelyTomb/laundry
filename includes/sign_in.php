<?php
require 'start_session.php';
require 'processor.php';
require 'connection.php';

$color = array('success' => 'alert-success', 'failure' => 'alert-danger');
$icn = array('success' => 'glyphicon-ok-sign', 'failure' => 'glyphicon-exclamation-sign');

if (isset($_POST['logIn'])) {
    try {
        $email = secure($_POST['email']);
        $password = secure($_POST['password']);
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            try {
                $stmt->bindColumn('name',$name);
                $stmt->bindColumn('email',$email);
                $stmt->bindColumn('password',$pwd);

                $result = $stmt->fetch(PDO::FETCH_BOUND);
                if (password_verify($password, $pwd)) {
                    $_SESSION['logged'] = true;
                    $_SESSION['user']['username'] = $name;
                    $_SESSION['user']['email'] = $email;
                    echo json_encode(array('txt'=>'Log In Process Successful!', 'color'=>$color['success'],'icon'=>$icn['success']));
                    exit;
                } else {
                    echo json_encode(array('txt'=>'The combination of the email and password entered is incorrect!', 'color'=>$color['failure'],'icon'=>$icn['failure']));
                    exit;
                }
            } catch (PDOException $e) {
                $error = $e->getMessage();
            }
        } else {
            echo json_encode(array('txt'=>'The combination of the email and password entered is incorrect!', 'color'=>$color['failure'],'icon'=>$icn['failure']));
            exit;
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
