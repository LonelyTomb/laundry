<?php
require '../config/start_session.php'; // start session
require '../includes/validate.php';
require '../config/token.php';

/***********************************/
/*******Admin Registeration*********/
/***********************************/
if (isset($_POST['create'])) {
    $name = secure($_POST['name']);
    $email = secure($_POST['email']);
    $password = secure($_POST['password']);
    $mailReceiver = secure($_POST['mailReceiver']);
    
    // Validate input fields
    if (!in_array($icon['icn_ok'], test_name($name, $icon))) {
        echo json_encode(test_name($name, $icon));
        exit;
    }
    if (!in_array($icon['icn_ok'], test_email($email, $icon)) && !in_array('Email Address already registered!', test_email($email, $icon))) {
        echo json_encode(test_email($email, $icon));
        exit;
    } else {
        try {
            $sql = 'SELECT email FROM admin WHERE email=:email';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $errorInfo = $stmt->errorInfo();
            if (isset($errorInfo[2])) {
                $error = $errorInfo[2];
            }
            if ($stmt->rowCount() > 0) {
                echo  json_encode(array('color' => $alertColor['nok'], 'txt' => 'Email Address already registered!'));
                exit;
            }
        } catch (PDOException $e) {
            $error = $e->getMessage();
            // return array('icon' => $icon['icn_remove'], 'txt' => $error);
        }
    }
    if (!in_array($icon['icn_ok'], test_password($password, $icon))) {
        echo json_encode(test_password($password, $icon));
        exit;
    }
    if ($mailReceiver == '') {
        echo json_encode(array('txt' => 'Mail Receiver Field cannot be empty', 'color' => $alertColor['nok']));
        exit;
    }
    
    $enc_pwd = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO admin(name,email,password,mailReceiver) VALUES(:name,:email,:password,:mailReceiver)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $enc_pwd, PDO::PARAM_STR);
    $stmt->bindParam(':mailReceiver', $mailReceiver, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo json_encode(array('txt' => 'Admin Successfully Created', 'color' => $alertColor['ok']));
    }
}

/***********************************/
/*******   Admin Login        ******/
/***********************************/

if (isset($_POST['logIn'])) {
    if (check_token(get_token_from_post()) === false) {
        echo json_encode(array('txt'=>'Invalid Admin Login. Please try Again','newToken'=>get_token(),'color' => $alertColor['nok']));
        exit;
    }
    $email = secure($_POST['email']);
    $password = secure($_POST['password']);
    if (!in_array($icon['icn_ok'], test_email($email, $icon)) && !in_array('Email Address already registered!', test_email($email, $icon))) {
        $data =test_email($email, $icon);
        echo json_encode($data += ['newToken'=>get_token(),'color' => $alertColor['nok']]);
        exit;
    }
    if (!in_array($icon['icn_ok'], test_password($password, $icon)) && !in_array('Password field cannot be empty!', test_password($password, $icon))) {
        $data= test_password($password, $icon);
        echo json_encode($data += ['newToken'=>get_token(),'color' => $alertColor['nok']]);
        exit;
    }
    
    try {
        $sql = 'SELECT * FROM admin WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $stmt->bindColumn('password', $enc_password);
            $stmt->bindColumn('name', $name);
            $stmt->bindColumn('email', $email);
            $stmt->fetch(PDO::FETCH_BOUND);
            if (password_verify($password, $enc_password)) {
                $_SESSION['admin']['username'] = $name;
                $_SESSION['admin']['email'] = $email;
                echo json_encode(array('txt'=>'Login Successfull','color' => $alertColor['ok']));
            } else {
                echo json_encode(array('txt'=>'Invalid Login Details!','newToken'=>get_token(),'color' => $alertColor['nok']));
            }
        }else{
            echo json_encode(array('txt'=>'User not found','newToken'=>get_token(),'color' => $alertColor['nok']));
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}

/***********************************/
/*******Edit Admin Details *********/
/***********************************/
if (isset($_POST['edit'])) {
    $name = secure($_POST['name']);
    $email = secure($_POST['email']);
    $password = secure($_POST['password']);
    $mailReceiver = secure($_POST['mailReceiver']);
    
    // Validate input fields
    if (!in_array($icon['icn_ok'], test_name($name, $icon))) {
        echo json_encode(test_name($name, $icon));
        exit;
    }
    if (!in_array($icon['icn_ok'], test_email($email, $icon)) && !in_array('Email Address already registered!', test_email($email, $icon))) {
        echo json_encode(test_email($email, $icon));
        exit;
    }
    if (!in_array($icon['icn_ok'], test_password($password, $icon)) && !in_array('Password field cannot be empty!', test_password($password, $icon))) {
        echo json_encode(test_password($password, $icon));
        exit;
    }
    if ($mailReceiver == '') {
        echo json_encode(array('txt' => 'Mail Receiver Field cannot be empty', 'icon' => $icon['icn_remove']));
        exit;
    }
    try {
        if(empty($password)){
            $sql = 'UPDATE admin SET name=:name,email=:email,mailReceiver=:mailReceiver WHERE name=:sessionname AND email=:sessionemail';
            $stmt=$pdo->prepare($sql);
        }else{
            $enc_pwd = password_hash($password,PASSWORD_DEFAULT);
            $sql = 'UPDATE admin SET name=:name,email=:email,mailReceiver=:mailReceiver,password=:enc_pwd WHERE name=:sessionname AND email=:sessionemail';
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':enc_pwd',$enc_pwd,PDO::PARAM_STR);
        }
        $stmt->bindParam(':name',$name,PDO::PARAM_STR);
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->bindParam(':mailReceiver',$mailReceiver,PDO::PARAM_STR);
        $stmt->bindParam(':sessionname',$_SESSION['admin']['username'],PDO::PARAM_STR);
        $stmt->bindParam(':sessionemail',$_SESSION['admin']['email'],PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount() == 1){
            echo json_encode(array('txt'=>"Account Successfully Updated",'color' => $alertColor['ok']));
        }else if($stmt->rowCount() == 0){
            echo json_encode(array('txt'=>"No fields Updated",'color' => $alertColor['ok']));
        }
        
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
