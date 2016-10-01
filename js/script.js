/* global $ */
(function () {
  'use strict';
  var val = $('result_txt').parent().find('input').val();
  if ($.trim(val) === '' && $('.result_txt').html() === '') {
    $('.result_txt').hide();
  }
  if ($(window).width() <= 480) {
    $('.delete_item').html('Del');
  }
  $(window).resize(function () {
    if ($(window).width() <= 480) {
      $('.delete_item').html('Del');
    }
  });
  $('.close_alert').click(function () {
    $('.alert').alert('close');
  });
  if ($('form .alert_msg strong').html() === '') {
    $('form .alert').hide();
  }
})();

function add ($item) {
  'use strict';
  var val = parseInt($item.parentsUntil('.qty').find('.quantity').val());
  val += 1;
  $item.parentsUntil('.qty').find('.quantity').val(val);
}

function minus ($item) {
  'use strict';
  var val = parseInt($item.parentsUntil('.qty').find('.quantity').val());
  if (val > 0) {
    val -= 1;
    $item.parentsUntil('.qty').find('.quantity').val(val);
  }
}
/* ******************************/
/*   Cart Functions   */
/* ******************************/
function add_to_cart ($item) {
  'use strict';
  var val = parseInt($item.parent().find('.quantity').val());
  var name = $item.parent().find('.name').val();
  var price = $item.parent().find('.price').val();
  var id = $item.parent().find('.cloth_id').val();
  var category = $item.parent().find('.category').val();
  if (val > 0) {
    var data = 'name=' + name + '&cloth_id=' + id + '&price=' + price + '&quantity=' + val + '&category=' + category + '&send';
    $.ajax({
      type: 'POST',
      url: 'includes/process_cart.php',
      data: data,
      dataType: 'json',
      success: function (data) {
        $('.cart_body').html(data.txt);
        $('.num_of_items').html(data.count);
      }
    });
  }
  $item.parent().find('.quantity').val('0');
}

// Removes item from cart
function remove_from_cart ($item) {
  'use strict';
  var id = parseInt($item.parent().find('input').val());
  var data = 'id=' + id;
  $.ajax({
    type: 'POST',
    url: 'includes/process_cart.php',
    data: data,
    dataType: 'json',
    success: function (data) {
      $('.num_of_items').html(data.count);
      $('.cart_body').html(data.txt);
      if ($('.cart_body tbody').html() === '') {
        $('#laundry_cart').modal('hide');
      }
    }
  });
}
// display laundry cart modal
function view_cart () {
  'use strict';
  var data = 'view';
  $.ajax({
    type: 'POST',
    url: 'includes/process_cart.php',
    data: data,
    dataType: 'json',
    success: function (data) {
      $('.num_of_items').html(data.count);
      if (!(data.count > 0)) {
        $('.clear_cart, .chk_out').hide();
      } else {
        $('.clear_cart, .chk_out').show();
      }
      $('.cart_body').html(data.txt);
    }
  });
}
// Empties the cart
function clear_cart () {
  'use strict';
  var data = 'clear';
  $.ajax({
    type: 'POST',
    url: 'includes/process_cart.php',
    data: data,
    dataType: 'json',
    success: function (data) {
      $('.num_of_items').html(data.count);
      $('.cart_body').html(data.txt);
      $('#laundry_cart').modal('hide');
    }
  });
}

function checkout () {
  'use strict';
  var data = 'checkout';
  $.ajax({
    type: 'POST',
    url: 'includes/process_cart.php',
    data: data,
    dataType: 'json',
    beforeSend: function () {
      $('.before_msg').show();
    },
    success: function (data) {
      $('.before_msg').hide();
      if (data.code === '!logged') {
        $('.alert_msg').html("<div class='alert alert-danger alert-dismissible text-center' role='alert'><button type='button' class='close close_alert' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>Please log in to access checkout function</div></div>");
        $('#laundry_cart').modal('hide');
        // window.location = '#alert_msg';
        window.scrollTo(10, 150);
      }
      if (data.code === 'logged') {
        $('#laundry_cart').modal('hide');
        $('.num_of_items').html('0');
        $('.alert_msg').html('<div class="alert alert-success alert-dismissible text-center" role="alert"><button type="button" class="close close_alert" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span><p>' + data.txt + '</p></div></div>');
      }
    }
  });
}

/* ***************/
/*        End   */
/* ***************/

// Funnction to toggle Validation icon
function validateIcn (icon, parent) { // toggle Validation Icon
  'use strict';
  if (parent.find('.result_icn').hasClass('glyphicon-remove')) {
    if (icon === 'glyphicon glyphicon-ok text-success') {
      parent.find('.result_icn').removeClass('glyphicon-remove text-danger').addClass('glyphicon-ok text-success');
    }
  } else if (parent.find('.result_icn').hasClass('glyphicon-ok')) {
    if (icon === 'glyphicon glyphicon-remove text-danger') {
      parent.find('.result_icn').removeClass('glyphicon-ok text-warning').addClass('glyphicon-remove text-danger');
    }
  } else {
    parent.find('.result_icn').addClass(icon);
  }
}
(function () {
  /* ******************************/
  /*   Beginning of AJAX Validation   */
  /* ******************************/
  $('#name_up').blur(function () {
    'use strict';
    var name = $(this).val();
    var p = $(this).parent();
    var data = 'name=' + name;
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      data: data,
      dataType: 'json',
      success: function (data) {
        validateIcn(data.icon, p);
        p.find('.result_txt').show();
        p.find('.result_txt').html(data.txt);
      }
    });
  });
  $('#email_up').blur(function () {
    'use strict';
    var email = $(this).val();
    var p = $(this).parent();
    var data = 'email=' + email;
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      data: data,
      dataType: 'json',
      success: function (data) {
        validateIcn(data.icon, p);
        p.find('.result_txt').show();
        p.find('.result_txt').html(data.txt);
      }
    });
  });

  $('#tel_up').blur(function () {
    'use strict';
    var phone = $(this).val();
    var p = $(this).parent();
    var data = 'phone=' + phone;
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      data: data,
      dataType: 'json',
      success: function (data) {
        validateIcn(data.icon, p);
        p.find('.result_txt').show();
        p.find('.result_txt').html(data.txt);
      }
    });
  });

  $('#address_up').blur(function () {
    'use strict';
    var address = $(this).val();
    var p = $(this).parent();
      // var data = 'address=' + address;
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      data: {
        address: address
      },
      dataType: 'json',
      success: function (data) {
        p.find('.result_txt').show();
        p.find('.result_txt').html(data.txt);
      }
    });
  });

  $('#pwd_up').blur(function () {
    'use strict';
    var password = $(this).val();
    var p = $(this).parent();
    var data = 'password=' + password;
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      data: data,
      dataType: 'json',
      success: function (data) {
        validateIcn(data.icon, p);
        p.find('.result_txt').show();
        p.find('.result_txt').html(data.txt);
      }
    });
  });

  // Reset Password Validation
  $('#rst_password').blur(function () {
    'use strict';
    var resetPwd = $('#rst_password').val();
    var p = $(this).parent();
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      data: {
        reset_pwd: resetPwd
      },
      dataType: 'json',
      success: function (data) {
        validateIcn(data.icon, p);
        p.find('.result_txt').show();
        p.find('.result_txt').html(data.txt);
      }
    });
  });

  $('#confrm_password').blur(function () {
    'use strict';
    var resetPwd = $('#rst_password').val();
    var cnfrmPwd = $('#confrm_password').val();
    var p = $(this).parent();
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      data: {
        reset_pwd: resetPwd,
        cnfrm_pwd: cnfrmPwd
      },
      dataType: 'json',
      success: function (data) {
        validateIcn(data.icon, p);
        p.find('.result_txt').show();
        p.find('.result_txt').html(data.txt);
      }
    });
  });
  /* ******************************/
  /*   End of AJAX Validation   */
  /* ******************************/

  // Registeration Submission Function
  $('#sign_up').click(function () {
    var name = $('#name_up').val();
    var email = $('#email_up').val();
    var phone = $('#tel_up').val();
    var address = $('#address_up').val();
    var password = $('#pwd_up').val();
    $.ajax({
      url: 'includes/sign_up.php',
      type: 'POST',
      dataType: 'json',
      data: {
        name: name,
        email: email,
        phone: phone,
        address: address,
        password: password,
        signUp: ''
      },
      beforeSend: function () {
        $('.signUp .before_msg').html('Processing...');
        $('.signUp .before_msg').show();
      },
      success: function (data) {
        $('.signUp .before_msg').hide();
        if (data.color === 'alert-success') {
          $('.signUp form .alert').removeClass('alert-danger').addClass('alert-success');
          $('.signUp form .alert_icon').removeClass('glyphicon-exclamation-sign').addClass(data.icn);
        } else if (data.color === 'alert-danger') {
          $('.signUp form .alert').removeClass('alert-success').addClass('alert-danger');
          $('.signUp form .alert_icon').removeClass(data.icn).addClass('glyphicon-exclamation-sign');
        } else {
          $('.signUp form .alert').addClass(data.color);
          $('.signUp form .alert_icon').addClass(data.icn);
        }
        $('.signUp form .alert_msg').html('<strong>' + data.txt + '</strong>');
        $('.signUp form .alert').show();

        // Reloads the page if login Successful
        if (data.color === 'alert-success') {
          window.setTimeout(function () {
            window.location.reload(true);
          }, 2000);
        }
      }
    });
    return false;
  });

// Login Function
  $('#log_in').click(function () {
    var email = $('#email').val();
    var password = $('#pwd').val();
    $.ajax({
      url: 'includes/sign_in.php',
      type: 'POST',
      dataType: 'json',
      data: {
        email: email,
        password: password,
        logIn: ''
      },
      beforeSend: function () {
        $('.signIn .before_msg').html('Processing...');
        $('.signIn .before_msg').show();
      },
      success: function (data) {
        $('.signIn .before_msg').hide();
        if (data.color === 'alert-success') {
          $('.signIn form .alert').removeClass('alert-danger').addClass('alert-success');
          $('.signIn form .alert_icon').removeClass('glyphicon-exclamation-sign').addClass(data.icn);
        } else if (data.color === 'alert-danger') {
          $('.signIn form .alert').removeClass('alert-success').addClass('alert-danger');
          $('.signIn form .alert_icon').removeClass(data.icn).addClass('glyphicon-exclamation-sign');
        } else {
          $('.signIn form .alert').addClass(data.color);
          $('.signIn form .alert_icon').addClass(data.icn);
        }
        $('.signIn form .alert_msg').html('<strong>' + data.txt + '</strong>');
        $('.signIn form .alert').show();
        // Reloads the page if login Successful
        if (data.color === 'alert-success') {
          window.setTimeout(function () {
            window.location.reload(true);
          }, 2000);
        }
      }
    });
    return false;
  });

  // Reset Password Function
  $('#reset').click(function () {
    var username = $('#username').val();
    var email = $('#email').val();
    var resetPwd = $('#rst_password').val();
    var cnfrmPwd = $('#confrm_password').val();
    $.ajax({
      type: 'POST',
      url: 'includes/reset_pwd.php',
      data: {
        username: username,
        email: email,
        reset_pwd: resetPwd,
        cnfrm_pwd: cnfrmPwd,
        submit: ''
      },
      dataType: 'json',
      beforeSend: function () {
        $('.reset_body .before_msg').html('Processing...');
        $('.reset_body .before_msg').show();
      },
      success: function (data) {
        $('.reset_body .before_msg').hide();
        if (data.icon !== 'glyphicon glyphicon-ok text-success') {
          $('.reset_body .alert').removeClass('alert-success').addClass('alert-warning');
        } else {
          $('.reset_body .alert').removeClass('alert-warning').addClass('alert-success');
        }
        $('.reset_body .alert p').html(data.txt);
        $('.reset_body .alert').show();
        if (data.icon === 'glyphicon glyphicon-ok text-success') {
          window.setTimeout(function () {
            window.location.replace('index.php');
          }, 2000);
        }
      }
    });
    return false;
  });
})();
