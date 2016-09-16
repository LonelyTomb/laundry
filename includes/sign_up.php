<?php
require 'validate.php';

$error = array();
if (isset($_POST['sign_Up'])) {
    $name = secure($_POST['name']);
    $email = secure($_POST['email']);
    $phone = secure($_POST['phone']);
    $address = secure($_POST['address']);
    $password = secure($_POST['password']);

    if (!in_array($icon['icn_ok'], test_name($name, $icon))) {
        $error[] = test_name($name, $icon)['txt'];
        header('location: ../index.php?status=error&code=name');
        exit;
    }
    if (!in_array($icon['icn_ok'], test_email($email, $icon))) {
        $error[] = test_email($name, $icon)['txt'];
        header('location: ../index.php?status=error&code=email');
        exit;
    }
    if (!in_array($icon['icn_ok'], test_phone($phone, $icon))) {
        $error[] = test_phone($name, $icon)['txt'];
        header('location: ../index.php?status=error&code=phone');
        exit;
    }
    if (empty($address)) {
        $error[] = 'Address field cannot be empty';
        header('location: ../index.php?status=error&code=address');
        exit;
    }
    if (!in_array($icon['icn_ok'], test_password($password, $icon))) {
        $error[] = test_password($name, $icon)['txt'];
        header('location: ../index.php?status=error&code=password');
        exit;
    }
    if (empty($error)) {
        try {
            #Checks for total number of users in database
      $sql = 'SELECT * FROM users';
            $stmt = $pdo->query($sql);
            $usr_id = $stmt->rowCount();
            $usr_id += 1;
        #Encrypts Password
      $enc_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (usr_id, name, email, phone, address, password) VALUES(:usr_id, :name,:email,:phone,:address,:password)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':usr_id', $usr_id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR, 11);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':password', $enc_password, PDO::PARAM_STR);
            $stmt->execute();
            $errorInfo = $stmt->errorInfo();
            if (isset($errorInfo[2])) {
                echo $errorInfo[2];
            } else {
                header('location: ../index.php?status=success&code=account');
                exit;
            }
        } catch (PDOException $e) {
            $err = $e->getMessage();
        }
    }
}
