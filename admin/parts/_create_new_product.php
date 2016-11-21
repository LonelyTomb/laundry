<div class="jumbotron jumbotron-fluid well well-sm">
  <div class="container">
    <h1 class="display-3">Create New Product</h1>
  </div>
</div>
<div class="well">
<form  class="form-horizontal createproductForm">
      <div class="alertBlock"></div>
        <div class="form-group">
          <label for="pid" class="control-group col-sm-5">Product Id: </label>
          <div class="col-sm-6">
          <input type="text" class="form-control pid" value='' id='pid'>
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
          <select name="" id="pctgy" class="form-control product_ctgy">
          <?php 
      
          try{
            $stmt = $pdo->query('SELECT * FROM category');
            $stmt->bindColumn('name',$ctgy);
            while($stmt->fetch(PDO::FETCH_BOUND)){
              echo "<option value='{$ctgy}'>{$ctgy}</option>";
            }
          }catch(PDOException $e){
            $error = $e->getMessage();
          }
          ?>
          </select>
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
        <div class="formgroup">
        <button type="button" name="create_product" class="btn btn-primary create_product" id="create_product">Create</button>
        <span class="before_msg"></span>
        </div>
      </form>
</div>