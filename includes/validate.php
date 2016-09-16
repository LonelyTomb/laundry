<?php
require 'processor.php';
require 'connection.php';
$icon = array(
'icn_remove' => 'glyphicon glyphicon-remove text-danger', 'icn_ok' => 'glyphicon glyphicon-ok text-success', );

function test_name($name, $icon)
{
    $name = secure($name);
    if (empty($name)) {
        return array('icon' => $icon['icn_remove'], 'txt' => 'Username is required!');
    }
    if (strlen($name) < 5) {
        return array('icon' => $icon['icn_remove'], 'txt' => 'Username length must be greater than 5!');
    } elseif (!validateName($name)) {
        return array('icon' => $icon['icn_remove'], 'txt' => 'Invalid Character! ');
    } else {
        return array('icon' => $icon['icn_ok'], 'txt' => 'Username Valid!');
    }
}
function test_email($email, $icon)
{
    global  $pdo;
    $email = secure($email);
    if (empty($email)) {
        return array('icon' => $icon['icn_remove'], 'txt' => 'Email is required!');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return array('icon' => $icon['icn_remove'], 'txt' => 'Invalid Email Address!');
    } else {
        try {
            $sql = 'SELECT email FROM users WHERE email=:email';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $errorInfo = $stmt->errorInfo();
            if (isset($errorInfo[2])) {
                $error = $errorInfo[2];
        // return json_encode(array('icon'=>$icon['icn_remove'],'txt'=>"Error"));
            }
            if ($stmt->rowCount() > 0) {
                return array('icon' => $icon['icn_remove'], 'txt' => 'Email Address already registered!');
            } else {
                return array('icon' => $icon['icn_ok'], 'txt' => 'Email Address Valid!');
            }
        } catch (PDOException $e) {
            $error = $e->getMessage();

            return array('icon' => $icon['icn_remove'], 'txt' => $error);
        }
    }
}
function test_password($password, $icon)
{
    $password = secure($password);
    if (empty($password)) {
        return array('icon' => $icon['icn_remove'], 'txt' => 'Password field cannot be empty!');
    }
    if (strlen($password) < 4) {
        return array('icon' => $icon['icn_remove'], 'txt' => 'Password length must be greater than 4!');
    } else {
        return array('icon' => $icon['icn_ok'], 'txt' => 'Password OK!');
    }
}

function test_phone($phone, $icon)
{
    if (empty($phone)) {
        return array('icon' => $icon['icn_remove'], 'txt' => 'Telephone field cannot be empty!');
    }
    if (preg_match('/(^0)([7|8|9])(\d{9})/', $phone)) {
        return array('icon' => $icon['icn_ok'], 'txt' => 'Telephone number valid!');
    } else {
        return array('icon' => $icon['icn_remove'], 'txt' => 'Invalid Telephone number!');
    }
}
####          AJAX Validation   ########
if (isset($_POST['name']) && isset($_POST['sign_Up']) === false) {
    echo json_encode(test_name($_POST['name'], $icon));
}

if (isset($_POST['email']) && !isset($_POST['sign_Up'])) {
    echo json_encode(test_email($_POST['email'], $icon));
}
if (isset($_POST['password']) && !isset($_POST['sign_Up'])) {
    echo json_encode(test_password($_POST['password'], $icon));
}
if (isset($_POST['phone']) && !isset($_POST['sign_Up'])) {
    echo json_encode(test_phone($_POST['phone'], $icon));
}
if (isset($_POST['address']) && !isset($_POST['sign_Up'])) {
    if (empty($_POST['address'])) {
        echo json_encode(array('txt' => 'Address field cannot be empty!'));
    }else{
        echo json_encode(array('txt' => 'Address field valid'));
    }
}
### End of AJAX Validation  ######
