
<?php
try {
    $sql = 'SELECT * FROM admin  WHERE name = :name AND email= :email';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $_SESSION['admin']['username'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $_SESSION['admin']['email'], PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $stmt->bindColumn('name', $username);
        $stmt->bindColumn('email', $email);
        $stmt->bindColumn('mailReceiver', $mailReceiver);
        $stmt->fetch(PDO::FETCH_BOUND);
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
}
 ?>
<div class="jumbotron jumbotron-fluid well well-sm">
  <div class="container">
    <h1 class="display-3">Edit Admin</h1>
  </div>
</div>
<form action="" class="form form-horizontal well">
  <div class="alertBlock"></div>
  <div class="form-group row">
    <label for="name" class="control-label col-sm-3">Name: </label>
    <div class="col-sm-8">
      <input type="text" name="name" id="name" class="form-control name" value="<?php echo $username;?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="email" class="control-label col-sm-3">Email: </label>
    <div class="col-sm-8">
      <input type="email" name="email" id="email" class="form-control email" value="<?php echo $email;?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="pwd" class="control-label col-sm-3">Password: </label>
    <div class="col-sm-8">
      <input type="password" name="pwd" id="pwd" class="form-control pwd" placeholder="Enter to change Password, Otherwise leave blank">
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="control-label col-sm-5">Receive Checkout Inventory Mails</label>
    <div class="col-sm-5">
      <div class="btn-group" data-toggle="buttons">
        <?php
        $radio = array('Y' => array('txt' => 'yes', 'code' => '1', 'color' => 'btn-primary'), 'N' => array('txt' => 'no', 'code' => '0', 'color' => 'btn-danger'));
        foreach ($radio as $button) {
            $txt = $button['txt'];
            $code = $button['code'];
            $color = $button['color'];
            if ($mailReceiver == $code) {
                $active = 'active';
                $checked = "checked='checked'";
            } else {
                $active = '';
                $checked = '';
            }
            echo "<label class='btn {$color} {$active} mailReceiverlabel'>
              <input type='radio'  class='mailReceiver' name='mailReceiver' id='$txt' value='$code' autocomplete='off' {$checked}>$txt
            </label>";
        }
        ?>
</div>
    </div>
  </div>
  <div class="form-group">
    <button type="submit" name="editAdmin" id="editAdmin" class="btn btn-info col-sm-offset-1">Edit</button>
    <span class="before_msg col-sm-offset-1"></span>
  </div>
</form>
