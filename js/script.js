/* global $ */
// toggles Alert Window on/off
function displayAlert (parent, data, color = 'alert-info', toggle = 'show') {
  var alert = '<div class="alert ' + color + ' alert-dismissible text-center" role="alert"><button type="button" class="close close_alert" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><div class="alert_msg">' + data + '</div></div></div>';

  if ($(parent).children().is('div.alert') && toggle === 'show') {
    $('div.alert_msg').html(data);
  } else if (!($(parent).children().is('div.alert')) && toggle === 'show') {
    $(parent).append(alert);
  } else if (toggle === 'hide') {
    $(alert).detach();
  }
}

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
  var id = $item.parent().find('.cloth_id').val();
  if (val > 0) {
    $.ajax({
      type: 'POST',
      url: 'includes/process_cart.php',
      cache:false,
      data: {
        cloth_id: id,
        quantity: val,
        send:''
      },
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
  $.ajax({
    type: 'POST',
    url: 'includes/process_cart.php',
    cache:false,
    data: {
      id:id
    },
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
  $.ajax({
    type: 'POST',
    url: 'includes/process_cart.php',
    cache:false,
    data:{
      view:''
    },
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
  $.ajax({
    type: 'POST',
    url: 'includes/process_cart.php',
    cache:false,
    data: {
      clear:''
    },
    dataType: 'json',
    success: function (data) {
      $('.num_of_items').html(data.count);
      $('.cart_body').html(data.txt);
      $('#laundry_cart').modal('hide');
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
  $('.chk_out').click(function () {
    'use strict';
    var data = 'checkout';
    $.ajax({
      type: 'POST',
      url: 'includes/process_cart.php',
      data: data,
      cache:false,
      dataType: 'json',
      beforeSend: function () {
        $('.before_msg').show();
      },
      success: function (data) {
        $('.before_msg').hide();
        if (data.code === '!logged') {
          // window.location = '#alert_msg';
          window.scrollTo(10, 150);
        }
        if (data.code === 'logged') {
          $('.num_of_items').html(data.count);
        }
        $('#laundry_cart').modal('hide');
        displayAlert('.mainalertBlock', data.txt, data.color);
      }
    });
  });
  /* ******************************/
  /*   Beginning of AJAX Validation   */
  /* ******************************/
  $('.name_up').blur(function () {
    'use strict';
    var name = $(this).val();
    var p = $(this).parent();
    var data = 'name=' + name;
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      data: data,
      cache:false,
      dataType: 'json',
      success: function (data) {
        validateIcn(data.icon, p);
        p.find('.result_txt').show();
        p.find('.result_txt').html(data.txt);
      }
    });
  });
  $('.email_up').blur(function () {
    'use strict';
    var email = $(this).val();
    var p = $(this).parent();
    var data = 'email=' + email;
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      cache:false,
      data: data,
      dataType: 'json',
      success: function (data) {
        validateIcn(data.icon, p);
        p.find('.result_txt').show();
        p.find('.result_txt').html(data.txt);
      }
    });
  });

  $('.tel_up').blur(function () {
    'use strict';
    var phone = $(this).val();
    var p = $(this).parent();
    var data = 'phone=' + phone;
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      cache:false,
      data: data,
      dataType: 'json',
      success: function (data) {
        validateIcn(data.icon, p);
        p.find('.result_txt').show();
        p.find('.result_txt').html(data.txt);
      }
    });
  });

  $('.address_up').blur(function () {
    'use strict';
    var address = $(this).val();
    var p = $(this).parent();
      // var data = 'address=' + address;
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      cache:false,
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

  $('.pwd_up').blur(function () {
    'use strict';
    var password = $(this).val();
    var p = $(this).parent();
    var data = 'password=' + password;
    $.ajax({
      type: 'POST',
      url: 'includes/ajx_validation.php',
      data: data,
      cache:false,
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
      cache:false,
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
      cache:false,
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
      cache:false,
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
        displayAlert('.signUp .alertBlock', data.txt, data.color);
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
      cache:false,
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
        displayAlert('.signIn .alertBlock', data.txt, data.color);
        // Reloads the page if login Successful
        if (data.color === 'alert-success') {
          window.location.reload(true);
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
      cache:false,
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
        displayAlert('.reset_body>.alertBlock', data.txt, data.color);

        if (data.icon === 'glyphicon glyphicon-ok text-success') {
          window.setTimeout(function () {
            window.location.replace('index.php');
          }, 2000);
        }
      }
    });
    return false;
  });
  $('#editUser').click(function () {
    var name = $('#name_up').val();
    // var email = $('#email_up').val();
    var phone = $('#tel_up').val();
    var address = $('#address_up').val();
    var password = $('#pwd_up').val();

    $.ajax({
      url: 'includes/process_profile.php',
      type: 'POST',
      dataType: 'json',
      cache:false,
      data: {
        name: name,
        phone: phone,
        address: address,
        password: password,
        editUser: ''
      },
      beforeSend: function () {
        $('.before_msg').html('Processing...');
        $('.before_msg').show();
      },
      success: function (data) {
        $(' .before_msg').hide();
        displayAlert('form .alertBlock', data.txt, data.color);
        // Reloads the page if edit Successful
        if (data.color === 'alert-success') {
          window.location.replace('index.php?log_out');
        }
      }
    });
    return false;
  });
})();
