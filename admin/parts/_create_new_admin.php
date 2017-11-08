<div class="jumbotron jumbotron-fluid well well-sm">
  <div class="container">
    <h1 class="display-3">Add New Admin</h1>
  </div>
</div>
<form action="" class="form form-horizontal well">
  <div class="alertBlock"></div>
  <div class="form-group row">
    <label for="name" class="control-label col-sm-3">Name: </label>
    <div class="col-sm-8">
      <input type="text" name="name" id="name" class="name form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="email" class="control-label col-sm-3">Email: </label>
    <div class="col-sm-8">
      <input type="email" name="email" id="email" class="email form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="pwd" class="control-label col-sm-3">Password: </label>
    <div class="col-sm-8">
      <input type="password" name="pwd" id="pwd" class="pwd form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="control-label col-sm-5">Receive Checkout Inventory Mails</label>
    <div class="col-sm-5">
      <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary">
          <input type="radio"  class='mailReceiver' name='mailReceiver' id="yes" value="1" autocomplete="off"> Yes
        </label>
        <label class="btn btn-danger active">
          <input type="radio"  class='mailReceiver' name='mailReceiver' id="no" value="0" autocomplete="off" checked> No
        </label>
</div>
    </div>
  </div>
  <div class="form-group">
    <button type="submit" name="createAdmin" id="createAdmin" class="btn btn-info col-sm-offset-1">Submit</button>
    <span class="before_msg col-sm-offset-1"></span>
  </div>
</form>
