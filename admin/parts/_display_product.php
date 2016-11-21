<div class="jumbotron jumbotron-fluid well well-sm">
  <div class="container">
    <h1 class="display-3">Edit Category</h1>
  </div>
</div>

<?php
$message = '<div class="well">
          <div class="alertBlock"></div>
      <table class="table table-bordered table-hover table-striped categories">
        <thead>
          <tr class="bg-success">
            <th></th>
            <th><p>S/N</p></th>
            <th><p>Id</p></th>
            <th><p>Name</p></th>
            <th><p>Category</p></th>
            <th><p>Price</p></th>
            <th></th>
        </tr>
    </thead>
    <tbody>';

        $name = secure($_GET['category']);
        $sql = "SELECT * FROM clothing WHERE category =:category";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':category',$name,PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount() == 0 ){
          //If No Results are found
          $deleteButton = '';
          $message =  "<div class='well'><p class='page-header'>No Products exist for this category yet.</p></div>";
        }else{
          $stmt->bindColumn('id',$id);
          $stmt->bindColumn('clothing_id',$pid);
          $stmt->bindColumn('name',$product_name);
          $stmt->bindColumn('category',$category);
          $stmt->bindColumn('price',$price);
          $count=0;

          $deleteButton = '<button class="multipleDelete btn btn-danger" name="multipleDelete">Delete</button>';

        while($stmt->fetch(PDO::FETCH_BOUND)){
          $count++;
          $price = number_format($price);
          $message.= "<tr>
        <th><label class='custom-control custom-checkbox'>
        <input type='checkbox' class='custom-control-input check' name='check' id='check' value={$id}>
        <span class='custom-control-indicator'></span>
        </label></th>
        <td class=''><p>{$count}</p></td>
        <td class='pid'><p>{$pid} <input type='hidden' class='id' value='{$id}'></p></td>
        <td class='pname'><p>{$product_name}</p></td>
        <td class='pctgy'><p>{$category}</p></td>
        <td class='pprice'><p>&#8358;{$price}</p></td>
        <td><button type='button' id='display_product' data-toggle='modal' onclick='display_product($(this).parent())'data-target='#product_modal' name='button' class='btn btn-success'>Edit</button></td>
        </tr>";
          }
        }
        
    $message .="</tbody>
              </table>
              {$deleteButton}
              </div>";
    //Outputs Category Table
    echo $message;
    ?>
<!-- /*=========================================*/ -->
<!-- /*===========     Edit Product Modal == */ -->
<!-- /*=========================================*/ -->
<div class="modal fade product_modal" id="product_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" >&times;</button>
        <h3 class="text-center">
          Edit Product
        </h3>
      </div>
      <div class="modal-body">
      <form  class="form-horizontal productForm">
      <div class="alertBlock"></div>
        <div class="form-group">
          <label for="pid" class="control-group col-sm-5">Product Id: </label>
          <div class="col-sm-6">
          <input type="text" class="form-control pid" value='' id='pid'>
          <input type="hidden" class="form-control id" value='' id='id'>
          </div>
        </div>
        <hr class="m-y-2">
        <div class="form-group">
          <label for="pname" class="control-group col-sm-5">Product Name: </label>
          <div class="col-sm-6">
          <input type="text" class="form-control pname" id='pname' value=''>
          </div>
        </div>
        <hr class="m-y-2">
        <div class="form-group">
          <label for="pctgy" class="control-group col-sm-5">Product Category: </label>
          <div class="col-sm-6">
          <select name="" id="pctgy" class="form-control product_ctgy"></select>
          </div>
        </div>
        <hr class="m-y-2">
        <div class="form-group">
          <label for="pprice" class="control-group col-sm-5">Product Price: </label>
          <div class="col-sm-6">
          <p class="input-group"> 
          <span class='input-group-addon'>&#8358;</span>
          <input type="text" class="form-control pprice" id='pprice' value=''>
          </p>
          </div>
        </div>
      </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger delete_product pull-left" name="delete">Delete</button>
      <div class="before_msg pull-left"></div>
      <button type="button" class="btn btn-success edit_product" name="edit">Edit</button>
      <button type="button" class="btn btn-warning" data-dismiss="modal" name="close">Close</button>
      </div>
    <div>
</div>