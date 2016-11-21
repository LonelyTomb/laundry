<?php require 'config/start_session.php';?>
<?php require 'config/processor.php'; ?>
<?php require 'config/connection.php'; ?>
<?php if (confirm_logged_in() == false) {
    header('Location: index.php');exit;
}
try{
$sql = "SELECT * FROM users WHERE name=:name AND email=:email";
$stmt= $pdo->prepare($sql);
$stmt->bindParam(':name',$_SESSION['user']['username'],PDO::PARAM_STR);
$stmt->bindParam(':email',$_SESSION['user']['email'],PDO::PARAM_STR);
$stmt->execute();
if($stmt->rowCount() == 1){
    $stmt->bindColumn('name',$username);
    $stmt->bindColumn('email',$useremail);
    $stmt->bindColumn('phone',$userphone);
    $stmt->bindColumn('address',$useraddress);
    $stmt->fetch(PDO::FETCH_BOUND);
}
}catch(PDOException $e){
    $error=$e->getMessage();
}?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Washman</title>
    <?php require 'resources.php';?>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require '_header.php'; ?>
    <div class="container">
        <form class="form form-horizontal container-fluid">
            <div class="alertBlock"></div>
            <div class="form-group has-feedback row">
                <label for="name_up" class="col-xs-3 control-label">Name: </label>
                <div class="col-xs-9">
                    <input id="name_up" class="name_up form-control" name="name" type="text" placeholder="Enter one or more names" value="<?php echo $username;?>"></input>
                    <span class="form-control-feedback result_icn" aria-hidden="true"></span>
                    <label class="result_txt"></label>
                </div>
            </div>
            <div class="form-group has-feedback row">
                <label for="tel_up" class="col-xs-3 control-label">Tel: </label>
                <div class="col-xs-9">
                    <input id="tel_up" class="tel_up form-control" name="phone" type="text" value="<?php echo $userphone;?>"></input>
                    <span class="form-control-feedback result_icn" aria-hidden="true"></span>
                    <label class="result_txt"></label>
                </div>
            </div>
            <div class="form-group row">
                <label for="address_up" class="col-xs-3 control-label">Address: </label>
                <div class="col-xs-9">
                    <textarea id="address_up" class="address_up form-control" name="address" ><?php echo $useraddress;?></textarea>
                    <label class="result_txt"></label>
                </div>
            </div>
            <div class="form-group has-feedback row">
                <label for="pwd_up" class="col-xs-3 control-label">Password: </label>
                <div class="col-xs-9">
                    <input id="pwd_up" class="form-control" name="password" type="password" placeholder="Enter to change Password, Otherwise leave blank"></input>
                    <span class="form-control-feedback result_icn" aria-hidden="true"></span>
                    <label class="result_txt"></label>
                </div>
            </div>
            <div class="form-group">
            <button type="submit" name="saveUser" id="editUser" class="btn btn-info pull-right">Save</button>
            <span class="before_msg col-sm-offset-1 pull-left"></span>
          </div>
        </form>
    </div>
    <?php require '_footer.php';?>
    <?php require '_laundry_cart.php';?>
    <script src="js/script.js"></script>
</body>

</html>
