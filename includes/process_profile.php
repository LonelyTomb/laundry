<?php
require '../config/start_session.php';
require 'validate.php';
if (isset($_POST['editUser'])) {
    $name = secure($_POST['name']);
    $address = secure($_POST['address']);
    $phone = secure($_POST['phone']);
    $password = secure($_POST['password']);

    if (!in_array($icon['icn_ok'], test_name($name, $icon))) {
        echo json_encode(test_name($name, $icon));
        exit;
    }
    if (empty($address)) {
        echo json_encode(array('txt' => 'Address field cannot be empty'));
    }
    if (!in_array($icon['icn_ok'], test_phone($phone, $icon))) {
        echo json_encode(test_phone($phone, $icon));
        exit;
    }
    try {
        if (empty($password)) {
            $sql = 'UPDATE users SET name=:name,phone=:phone,address=:address WHERE name=:sessionname AND email=:sessionemail';
            $stmt = $pdo->prepare($sql);
        } elseif (!empty($password)) {
            if (strlen(trim($password)) < 4) {
                echo json_encode(array('txt' => 'Password length must be greater than 4!'));
                exit;
            }

            $enc_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = 'UPDATE users SET name=:name,phone=:phone,address=:address,password=:enc_password WHERE name=:sessionname AND email=:sessionemail';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':enc_password', $enc_password,PDO::PARAM_STR);
        }

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':sessionname', $_SESSION['user']['username'], PDO::PARAM_STR);
        $stmt->bindParam(':sessionemail', $_SESSION['user']['email'], PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            echo json_encode(array('txt' => 'Account Successfully Updated', 'color' => $alertColor['ok']));
            exit;
        } elseif ($stmt->rowCount() == 0) {
            echo json_encode(array('txt' => 'No Fields Updated','color' => $alertColor['info']));
            exit;
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
