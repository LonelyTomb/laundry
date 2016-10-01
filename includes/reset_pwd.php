<?php
require 'start_session.php';
require 'validate.php';

if (isset($_POST['submit'])) {
    $name = secure($_POST['username']);
    $email = secure($_POST['email']);
    $resetPwd = secure($_POST['reset_pwd']);
    $cnfrmPwd = secure($_POST['cnfrm_pwd']);

    if (empty($name)) {
        echo  json_encode(test_name($resetPwd, $icon));
    } elseif (empty($email)) {
        echo  json_encode(test_email($email, $icon));
    } elseif (!in_array($icon['icn_ok'], test_password($resetPwd, $icon))) {
        echo  json_encode(test_password($resetPwd, $icon));
    } elseif (!in_array($icon['icn_ok'], confirm_password($resetPwd, $cnfrmPwd,$icon))) {
        echo  json_encode(confirm_password($resetPwd, $icon));
    } else {
        try {
            $sql = 'SELECT password FROM users WHERE name= :name AND email= :email';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $errorInfo = $stmt->errorInfo();
            if(isset($errorInfo[2])){
                // echo json_encode(array('txt'=>$errorInfo[2]));
            }
            if ($stmt->rowCount() == 1) {
                $enc_password = password_hash($resetPwd, PASSWORD_DEFAULT);
                $sql = 'UPDATE users SET password = :enc_password WHERE name= :name AND email= :email';
                $stmt=$pdo->prepare($sql);
                $stmt->bindParam(':enc_password', $enc_password, PDO::PARAM_STR);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                $errorInfo = $stmt->errorInfo();

                if ($stmt->rowCount() == 1) {
                    echo json_encode(array('icon' => $icon['icn_ok'], 'txt' => 'Password Successfully Updated!'));
                }
            } else {
                echo json_encode(array('icon' => $icon['icn_remove'], 'txt' => 'Incorect combination of username and email'));
            }
        } catch (PDOException $e) {
            $error = $e->getMessage();
            // echo json_encode(array('txt'=>$error));
        }
    }
}
