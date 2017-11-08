  <?php
    function display_category($category = '')
    {
        global $pdo,$stmt;
        $cty = secure($category);
        $text_info = '';

      ####Ensures Category exists in database
        if ($cty != '') {
            $sql = 'SELECT * FROM category WHERE name = :category';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':category', $cty, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                $cty = '';
            }
        }

        $message = "<div class='well clothing_header'>";
        if ($cty == '') {
            $message .= "<h3 class='text-center'>Top Laundry Orders</h3>";
        } else {
            $message .= "<h3 class='text-center'>$cty Laundry. Select Preference Below</h3>";
        }

        $message .= " </div>
        <table class='table table-hover table-responsive table-bordered'>
        <thead>
        <tr>
        <th class='text-center'>Item</th>
        <th class='text-center'>Pricing</th>
        <th class='text-center'>Quantity</th>
        </tr>
        </thead>
        <tbody>";

        if ($cty == '') {
            $sql = 'SELECT * FROM clothing ORDER BY NAME ASC LIMIT 10;';
            $stmt = $pdo->query($sql);
        } else {
            $sql = 'SELECT * FROM clothing WHERE category = :category ORDER BY NAME ASC';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':category', $cty, PDO::PARAM_STR);
            $stmt->execute();
        }

        //If No Products Found
        if($stmt->rowCount() == 0){
            $message = "<div class='well'>
          <p class='lead page-header'>No Products exist under this category yet.</p>
          </div>";
        }else{
        $stmt->bindColumn('clothing_id', $clothing_id);
        $stmt->bindColumn('name', $name);
        $stmt->bindColumn('category', $category);
        $stmt->bindColumn('price', $price);

        while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
          //Converts & to -
            $price = number_format($price);

            if ($cty == '') {
                $text_info = "<small class='text-info'>$category</small>";
            }
            $message .= "<tr class='order-row'>
          <td class='item-name'>
              <p>$name $text_info
              </p>
          </td>
          <td>
              <p class='pricing'>
                  &#8358;$price
              </p>
          </td>
          <td class='qty col-xs-3'>
              <p class='input-group'>
                  <span class='input-group-btn add' onclick='minus($(this))'><a class='btn btn-danger'><i class='glyphicon glyphicon-minus'></i></a></span>
                  <input type='text' name='quantity' class='quantity form-control' value='0'>
                  <input type='hidden' name='cloth_id' class='cloth_id' value='$clothing_id'>
                  <span class='input-group-btn'><a class='btn btn-success' id='add' type='button' onclick='add($(this))'><i class='glyphicon glyphicon-plus'></i></a>
                      <button type='button' class='btn btn-primary' onclick='add_to_cart($(this).parent())' name='button'>Add</button></span>
              </p>
          </td>
      </tr>";
        }
        $message .= '</tbody></table><div class="add_to_cart">
            <button type="button" class="pull-right btn btn-success" onclick="view_cart()" data-target="#laundry_cart" data-toggle="modal" name="button">View Cart</button>
        </div>';
            }
        if($cty != ''){
          $message.='<script>(function(){ window.scrollTo(0, 610);})();</script>';
        }
        echo $message;
    }
    ?>
