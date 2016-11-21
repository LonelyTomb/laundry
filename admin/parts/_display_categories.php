<div class="jumbotron jumbotron-fluid well well-sm">
  <div class="container">
    <h1 class="display-3">Edit Categories</h1>
  </div>
</div>
<div class="well">
  <table class="table table-bordered table-hover table-striped categories">
    <thead>
      <tr class='bg-info'>
        <th><p>S/N</p></th>
        <th><p>Name</p></th>
        <th><p>Edit</p></th>
      </tr>
    </thead>
    <tbody>
      <?php
      try{
        $sql = "SELECT * FROM category";
        $stmt=$pdo->query($sql);
        $stmt->bindColumn('name',$name);
        $stmt->bindColumn('id',$id);
        $count=0;
        while($stmt->fetch(PDO::FETCH_BOUND)){
          $count++;
          echo "<tr class='ctgy_row'>
            <th scope='row'>$count</th>
            <td class='ctgy_name'><p>{$name}</p><input type='hidden' value='{$id}' name='ctgy_id'></td>
            <td><button type='button' id='display_ctgy' data-toggle='modal' onclick='display_ctgy($(this).parent())'data-target='#ctgy_modal' name='button' class='btn btn-success'>Edit</button></td>
          </tr>";
        }
      }catch(PDOException $e){
        $error = $e->getMessage();
      }
       ?>

    </tbody>
  </table>
  <button type="button" class='btn btn-info' name="button"data-target="#create_ctgy_modal" data-toggle="modal" class="add_category">Add New Category</button>
</div>
<!-- /*=========================================*/ -->
<!-- /*===========     Edit category Modal == */ -->
<!-- /*=========================================*/ -->
<div class="modal fade ctgy_modal" id="ctgy_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" >&times;</button>
        <h3 class="text-center">
          Edit category
        </h3>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
        <form action="" class="form form-horizontal">
          <div class="alertBlock"></div>
          <div class="form-group">
            <label for="ctgy_name" class="ctgy_label control-label col-sm-3">Category: </label>
            <div class="col-sm-7">
              <input type="text" class="form-control ctgy_name" name="ctgy_name" id="ctgy_name" value="">
              <input type="hidden" name="ctgy_id" id="ctgy_id" value="">
            </div>
          </div>
          <div class="form-group">
            <label for="ctgy_name" class="ctgy_label control-label col-sm-7">Update/Delete associated products : </label>
            <div class="col-sm-2">
              <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-primary btn-sm"><input type="checkbox" name="update" autocomplete="off" value="1"> Yes</label>
            </div>
            </div>
          </div>
        </form>
        </div>
      </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger delete_ctgy pull-left" name="delete">Delete</button>
      <div class="before_msg pull-left"></div>
      <button type="button" class="btn btn-success edit_ctgy" name="edit">Edit</button>
      <button type="button" class="btn btn-warning" data-dismiss="modal" name="close">Close</button>
    </div>
    </div>
  </div>
</div>
<!-- /*=========================================*/ -->
<!-- /*===========     Create category Modal == */ -->
<!-- /*=========================================*/ -->
<div class="modal fade create_ctgy_modal" id="create_ctgy_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" >&times;</button>
        <h3 class="text-center">
          Create New Category
        </h3>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
        <form action="" class="form form-horizontal">
          <div class="alertBlock"></div>
          <div class="form-group">
            <label for="ctgy_name" class="ctgy_label control-label col-sm-3">Category: </label>
            <div class="col-sm-7">
              <input type="text" class="form-control ctgy_name" name="ctgy_name" id="ctgy_name" value="">
            </div>
          </div>
        </form>
        </div>
      </div>
    <div class="modal-footer">
      <div class="before_msg pull-left"></div>
      <button type="button" class="btn btn-success create_ctgy" name="create">Create</button>
      <button type="button" class="btn btn-warning" data-dismiss="modal" name="close">Close</button>
    </div>
    </div>
  </div>
</div>
