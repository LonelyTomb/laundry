<?php
require("validate.php");
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
if(isset($_POST['reset_pwd']) && !isset($_POST['cnfrm_pwd'])){
    echo json_encode(test_password($_POST['reset_pwd'],$icon));
}
if(isset($_POST['reset_pwd']) && isset($_POST['cnfrm_pwd'])){
    echo json_encode(confirm_password($_POST['reset_pwd'],$_POST['cnfrm_pwd'],$icon));
}
