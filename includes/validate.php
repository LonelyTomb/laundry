<?php
require '../config/processor.php';
require '../config/connection.php';
$icon = array(
'icn_remove' => 'glyphicon glyphicon-remove text-danger', 'icn_ok' => 'glyphicon glyphicon-ok text-success', );
$alertColor = array('ok'=>'alert-success','nok'=>'alert-danger','info'=>'alert-info');
function validateName($nam)
{
    if (preg_match('/^[a-z\d- ]{2,20}$/i', $nam)) {
        return true;
    } else {
        return false;
    }
}


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
//    $email = $email;
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
function confirm_password($pwd,$cnfrm_pwd, $icon){
if(in_array($icon['icn_ok'], test_password($cnfrm_pwd, $icon))){
        if($cnfrm_pwd === $pwd){
            return array('icon' => $icon['icn_ok'], 'txt' => 'Password Match!');
        }else{
            return array('icon' => $icon['icn_remove'], 'txt' => 'Incorrect Password Match!');
        }
}else{
    return test_password($cnfrm_pwd, $icon);
}
}
