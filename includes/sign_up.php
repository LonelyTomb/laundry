<?php
require 'validate.php';
$error = array();

$color = array('success' => 'alert-success', 'failure' => 'alert-danger');
$icn = array('success' => 'glyphicon-ok-sign', 'failure' => 'glyphicon-exclamation-sign');
if (isset($_POST['signUp'])) {
    $name = secure($_POST['name']);
    $email = secure($_POST['email']);
    $phone = secure($_POST['phone']);
    $address = secure($_POST['address']);
    $password = secure($_POST['password']);

    if (!in_array($icon['icn_ok'], test_name($name, $icon))) {
        $error['name'] = test_name($name, $icon)['txt'];
        echo json_encode(array('txt'=>'Invalid Username!', 'color'=>$color['failure'],'icon'=>$icn['failure']));
        exit;
    }
    if (!in_array($icon['icn_ok'], test_email($email, $icon))) {
        $error['email'] = test_email($name, $icon)['txt'];
        echo json_encode(array('txt'=>"<strong>Invalid Email!</strong>", 'color'=>$color['failure'],'icon'=>$icn['failure']));
        exit;
    }
    if (!in_array($icon['icn_ok'], test_phone($phone, $icon))) {
        $error['phone'] = test_phone($name, $icon)['txt'];
        echo json_encode(array('txt'=>"<strong>Invalid Telephone number!</strong>", 'color'=>$color['failure'],'icon'=>$icn['failure']));
        exit;
    }
    if (empty($address)) {
        $error['address'] = 'Address field cannot be empty';
        echo json_encode(array('txt'=>"<strong>Invalid Address!</strong>", 'color'=>$color['failure'],'icon'=>$icn['failure']));
        exit;
    }
    if (!in_array($icon['icn_ok'], test_password($password, $icon))) {
        $error['password'] = test_password($name, $icon)['txt'];
        echo json_encode(array('txt'=>"<strong>Invalid Password!</strong>", 'color'=>$color['failure'],'icon'=>$icn['failure']));
        exit;
    }
    if (empty($error)) {
        try {
            #Checks for total number of users in database
      $sql = 'SELECT * FROM users';
            $stmt = $pdo->query($sql);
            $usr_num = $stmt->rowCount();
            $usr_num += 1;
        #Encrypts Password
      $enc_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (usr_num, name, email, phone, address, password) VALUES(:usr_num, :name,:email,:phone,:address,:password)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':usr_num', $usr_num, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR, 11);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':password', $enc_password, PDO::PARAM_STR);
            $stmt->execute();
            $errorInfo = $stmt->errorInfo();
            if (isset($errorInfo[2])) {
                // echo $errorInfo[2];
                echo json_encode(array('txt'=>"<strong>Unable to Complete Registeration Process! Please Try Again!</strong>", 'color'=>$color['failure'],'icon'=>$icn['failure']));
            } else {
                echo json_encode(array('txt'=>"<strong>Account Registeration Successful!</strong>", 'color'=>$color['success'],'icon'=>$icn['success']));
                exit;
            }
        } catch (PDOException $e) {
            $err = $e->getMessage();
        }
    }
}
