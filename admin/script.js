/*global $*/
// toggles Alert Window on/off
function displayAlert(parent, data, color = 'alert-info', toggle = 'show') {
  var alert = '<div class="alert ' + color + ' alert-dismissible text-center" role="alert"><button type="button" class="close close_alert" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><div class="alert_msg">' + data + '</div></div></div>';

  if ($(parent).children().is('div.alert') && toggle === 'show') {
    $('div.alert_msg').html(data);
  } else if (!($(parent).children().is('div.alert')) && toggle === 'show') {
    $(parent).append(alert);
  } else if (toggle === 'hide') {
    alert.detach();
  }
}

// Displays  Categories modal
function display_ctgy(ctgy_name) {
  var name = ctgy_name.parent().find('td.ctgy_name p').html();
  $.ajax({
    url: 'process_categories.php',
    type: 'POST',
    cache: false,
    data: {
      name: name,
      display_ctgy: ''
    },
    dataType: 'json',
    beforeSend: function () {
    },
    success: function (data) {
      $('.ctgy_modal .modal-body #ctgy_name').val(data.txt);
      $('.ctgy_modal .modal-body #ctgy_id').val(data.id);
    }
  });
}

// Displays  product modal
function display_product(product_id) {
  var id = product_id.parent().find('td.pid p input.id').val();
  $.ajax({
    url: 'process_product.php',
    type: 'POST',
    cache: false,
    data: {
      id: id,
      display_product: ''
    },
    dataType: 'json',
    beforeSend: function () {
    },
    success: function (data) {
      var selected =false; 
      for(var ctgy in data.allctgy){ 
         if(data.allctgy[ctgy] === data.category){
         selected = true;
      }else{    
        selected = false;
      }    
      $('<option>',{
        value:data.allctgy[ctgy],
        text:data.allctgy[ctgy],
      }).prop({'selected':selected}).appendTo('.product_modal .modal-body .product_ctgy');
     
    }
      $('.product_modal .modal-body .pid').val(data.clothing_id);
      $('.product_modal .modal-body .pname').val(data.name);
      $('.product_modal .modal-body .pprice').val(data.price);
      $('.product_modal .modal-body .id').val(data.id);
    }
  });
}

(function () {
  $('.collapseArrow').click(function () {
    $('#categories').collapse('toggle');
  });
  // Admin Login
  $('button[name="logIn"]').click(function () {
    var email = $('.email').val();
    var pwd = $('.pwd').val();
    var token = $('.token').val();
    $.ajax({
      url: 'process_forms.php',
      type: 'POST',
      cache: false,
      data: {
        email: email,
        password: pwd,
        token: token,
        logIn: ''
      },
      dataType: 'json',
      beforeSend: function () {
        $('.before_msg').html('Processing...');
        $('.before_msg').show();
      },
      success: function (data) {
        $('.before_msg').hide();
        displayAlert('form .alertBlock', data.txt, data.color);
        if (data.txt === 'Login Successfull') {
          window.location.replace('index.php');
        } else if (data.txt !== 'Login Successfull') {
          $('#token').val(data.newToken);
        }
      }
    });
    return false;
  });

  // Admin Registeration
  $('button[name="createAdmin"]').click(function () {
    var name = $('.name').val();
    var email = $('.email').val();
    var pwd = $('.pwd').val();
    var mailReceiver = $('input[name="mailReceiver"]:checked').val();
    $.ajax({
      url: 'process_forms.php',
      type: 'POST',
      cache: false,
      data: {
        name: name,
        email: email,
        password: pwd,
        mailReceiver: mailReceiver,
        create: ''
      },
      dataType: 'json',
      beforeSend: function () {
        $('.before_msg').html('Processing...');
        $('.before_msg').show();
      },
      success: function (data) {
        $('.before_msg').hide();
        displayAlert('form .alertBlock', data.txt, data.color);
        if (data.txt === 'Admin Successfully Created') {
          window.location.replace('index.php');
        }
      }
    });
    return false;
  });

  // Edit admin
  $('button[name="editAdmin"]').click(function () {
    var name = $('.name').val();
    var email = $('.email').val();
    var pwd = $('.pwd').val();
    var mailReceiver = $('input[name="mailReceiver"]:checked').val();
    $.ajax({
      url: 'process_forms.php',
      type: 'POST',
      cache: false,
      data: {
        name: name,
        email: email,
        password: pwd,
        mailReceiver: mailReceiver,
        edit: ''
      },
      dataType: 'json',
      beforeSend: function () {
        $('.before_msg').html('Processing...');
        $('.before_msg').show();
      },
      success: function (data) {
        $('.before_msg').hide();
        displayAlert('form .alertBlock', data.txt, data.color);
        if (data.txt === 'Account Successfully Updated') {
          window.location.replace('index.php?log_out');
        }
      }
    });
    return false;
  });

  // Creates New Category
  $('.create_ctgy').click(function () {
    var name = $('.create_ctgy_modal .modal-body .ctgy_name').val();
    $.ajax({
      url: 'process_categories.php',
      type: 'POST',
      cache: false,
      data: {
        name: name,
        create: ''
      },
      dataType: 'json',
      beforeSend: function () {
        $('.before_msg').html('Processing...');
        $('.before_msg').show();
      },
      success: function (data) {
        $('.before_msg').hide();
        displayAlert('.create_ctgy_modal form .alertBlock', data.txt, data.color);
        if (data.color === 'alert-success') {
          window.location.reload(true);
        }
      }
    });
  });

  // Edit Existing Category
  $('.edit_ctgy').click(function () {
    var name = $('#ctgy_name').val();
    var id = $('#ctgy_id').val();
    var check = 0;
    if ($('input[name="update"]').prop('checked') === true) {
      check = 1;
    }
    $.ajax({
      url: 'process_categories.php',
      type: 'POST',
      cache: false,
      data: {
        name: name,
        check: check,
        id: id,
        edit_ctgy: ''
      },
      dataType: 'json',
      beforeSend: function () {
        $('.before_msg').html('Processing...');
        $('.before_msg').show();
      },
      success: function (data) {
        $('.before_msg').hide();
        displayAlert('.ctgy_modal form .alertBlock', data.txt, data.color);
        if (data.color === 'alert-success') {
          window.location.reload(true);
        }
      }
    });
  });

  //Delete Category
  $('.delete_ctgy').click(function () {
    var name = $('#ctgy_name').val();
    var id = $('#ctgy_id').val();
    var check = 0;
    if ($('input[name="update"]').prop('checked') === true) {
      check = 1;
    }
    $.ajax({
      url: 'process_categories.php',
      type: 'POST',
      cache: false,
      data: {
        name: name,
        check: check,
        id: id,
        delete_ctgy: ''
      },
      dataType: 'json',
      beforeSend: function () {
        $('.before_msg').html('Processing...');
        $('.before_msg').show();
      },
      success: function (data) {
        $('.before_msg').hide();
        displayAlert('.ctgy_modal form .alertBlock', data.txt, data.color);
        if (data.color === 'alert-success') {
          window.location.reload(true);
        }
      }
    });
  });


  //Edit product
  $('.edit_product').click(function () {
    var clothing_id = $('.product_modal .modal-body .pid').val();
    var name = $('.product_modal .modal-body .pname').val();
    var category = $('.product_modal .modal-body .product_ctgy option:selected').val();
    var price = parseInt($('.product_modal .modal-body .pprice').val(), 10);
    var id = $('.product_modal .modal-body .id').val();

    $.ajax({
      url: 'process_product.php',
      type: 'POST',
      cache: false,
      data: {
        clothing_id: clothing_id,
        name: name,
        category: category,
        price: price,
        id: id,
        edit_product: ''
      },
      dataType: 'json',
      beforeSend: function () {
        $('.before_msg').html('Processing');
        $('.before_msg').show();
      },
      success: function (data) {
        $('.before_msg').hide();        
        displayAlert('.alertBlock',data.txt,data.color);
        if (data.color === 'alert-success') {
          window.location.reload(true);
        }
      }
    });
    return false;
  });

//Creates New product
$('.create_product').click(function () {
    var clothing_id = $('.createproductForm .pid').val();
    var name = $('.createproductForm .pname').val();
    var category = $('.createproductForm .product_ctgy option:selected').val();
    var price = parseInt($('.createproductForm .pprice').val(),10);
    $.ajax({
      url: 'process_product.php',
      type: 'POST',
      cache: false,
      data: {
        clothing_id: clothing_id,
        name: name,
        category: category,
        price: price,
        create_product: ''
      },
      dataType: 'json',
      beforeSend: function () {
        $('.before_msg').html('Processing...');
        $('.before_msg').show();
      },
      success: function (data) {
        $('.before_msg').hide();
        displayAlert('.well .alertBlock', data.txt, data.color);
        if (data.color === 'alert-success') {
          window.location.replace('index.php?category='+category);
        }
      }
    });
    return false;
});

  //Delete selected product
  $('.delete_product').click(function () {
    var id = $('.product_modal .modal-body .id').val();
    $.ajax({
      url: 'process_product.php',
      type: 'POST',
      cache: false,
      data: {
        id: id,
        delete_product: ''
      },
      dataType: 'json',
      beforeSend: function () {
        $('.before_msg').html('Processing...');
        $('.before_msg').show();
      },
      success: function (data) {
        $('.before_msg').hide();
        displayAlert('.well .alertBlock', data.txt, data.color);
        if (data.color === 'alert-success') {
          window.location.reload(true);
        }
      }
    });
  });

  //Delete Multiple Products
  $('.multipleDelete').click(function () {  
    var check = $('.check:checked').map(function() {
    return this.value;}).get().join(',');
    $.ajax({
      url: 'process_product.php',
      type: 'POST',
      cache: false,
      data: {
        check: check,
        delete_products: ''
      },
      dataType: 'json',
      beforeSend: function () {
        $('.before_msg').html('Processing...');
        $('.before_msg').show();
      },
      success: function (data) {
        $('.before_msg').hide();
        displayAlert('.well .alertBlock', data.txt, data.color);
        if (data.color === 'alert-success') {
          window.location.reload(true);
        }
      }
    });
  });
})();
