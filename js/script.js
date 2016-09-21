(function() {
    "use strict";
    var val = $('result_txt').parent().find('input').val();
    if ($.trim(val) == "" && $('.result_txt').html() == "") {
        $('.result_txt').hide();
    };
    if($(window).width()<=480){
        $(".delete_item").html("Del");
    };
    $(window).resize(function(){
        if($(window).width()<=480){
            $(".delete_item").html("Del");
        }
    });
})();

function add($item) {
    "use strict";
    var val = parseInt($item.parentsUntil(".qty").find(".quantity").val());
    val += 1;
    $item.parentsUntil(".qty").find(".quantity").val(val);
}

function minus($item) {
    "use strict";
    var val = parseInt($item.parentsUntil(".qty").find(".quantity").val());
    if (val > 0) {
        val -= 1;
        $item.parentsUntil(".qty").find(".quantity").val(val);
    }
}
/*******************************/
/*   Cart Functions   */
/*******************************/
function add_to_cart($item) {
    "use strict";
    var val = parseInt($item.parent().find('.quantity').val());
    var name = $item.parent().find('.name').val();
    var price = $item.parent().find('.price').val();
    var id = $item.parent().find('.cloth_id').val();
    var category = $item.parent().find('.category').val();
    if (val > 0) {
        var data = 'name=' + name + '&cloth_id=' + id + '&price=' + price + '&quantity=' + val + '&category=' + category + '&send';
        // console.log(data);
        $.ajax({
            type: "POST",
            url: 'includes/process_cart.php',
            data: data,
            dataType: 'json',
            success: function(data) {
                $(".cart_body").html(data.txt);
                $(".num_of_items").html(data.count);
            }
        });
    }
    $item.parent().find('.quantity').val("0");
}

//Removes item from cart
function remove_from_cart($item) {
    "use strict";
    var id = parseInt($item.parent().find('input').val());
    var data = 'id=' + id;
    $.ajax({
        type: 'POST',
        url: 'includes/process_cart.php',
        data: data,
        dataType: 'json',
        success: function(data) {
            $(".num_of_items").html(data.count);
            $(".cart_body").html(data.txt);
            if ($(".cart_body tbody").html() === "") {
                $('#laundry_cart').modal('hide');
            }
        }
    });
}
// display laundry cart modal
function view_cart() {
    "use strict";
    var data = 'view';
    $.ajax({
        type: 'GET',
        url: 'includes/process_cart.php',
        data: data,
        dataType: 'json',
        success: function(data) {
            $(".num_of_items").html(data.count);
            if (data.count == 0) {
                $(".clear_cart, .chk_out").hide();
            } else {
                $(".clear_cart, .chk_out").show();
            }
            $(".cart_body").html(data.txt);

        }
    });
}
//Empties the cart
function clear_cart() {
    "use strict";
    var data = 'clear';
    $.ajax({
        type: 'POST',
        url: 'includes/process_cart.php',
        data: data,
        dataType: 'json',
        success: function(data) {
            $(".num_of_items").html(data.count);
            $(".cart_body").html(data.txt);
            $('#laundry_cart').modal('hide');
        }

    });
}
function checkout(){
    "use strict";
    var data = "checkout";
    $.ajax({
        type:'POST',
        url: 'includes/process_cart.php',
        data: data,
        dataType: 'json',
        success: function(data){
            if(data.code == "!logged"){
                $(".alert_msg").html("<div class='alert alert-danger alert-dismissible text-center' role='alert'><button type='button' class='close close_alert' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>Please log in to access checkout function</div></div>");
                $('#laundry_cart').modal('hide');
            };
            console.log("wkin");
        }
    })
}

/****************/
/*        End   */
/****************/
/*******************************/
/*   Beginning of AJAX Validation   */
/*******************************/
//registeration
function validate_icn(icon, parent) { // toggle Validation Icon
    "use strict";
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

$("#name_up").blur(function() {
    "use strict";
    var name = $(this).val();
    var p = $(this).parent();
    var data = "name=" + name;
    $.ajax({
        type: "POST",
        url: "includes/validate.php",
        data: data,
        dataType: 'json',
        success: function(data) {
            validate_icn(data.icon, p);
            p.find('.result_txt').show();
            p.find('.result_txt').html(data.txt);
        }
    });
});
$("#email_up").blur(function() {
    "use strict";
    var email = $(this).val();
    var p = $(this).parent();
    var data = "email=" + email;
    $.ajax({
        type: "POST",
        url: 'includes/validate.php',
        data: data,
        dataType: 'json',
        success: function(data) {
            validate_icn(data.icon, p);
            p.find('.result_txt').show();
            p.find('.result_txt').html(data.txt);
        }
    })
});

$("#tel_up").blur(function() {
    "use strict";
    var phone = $(this).val();
    var p = $(this).parent();
    var data = "phone=" + phone;
    $.ajax({
        type: "POST",
        url: "includes/validate.php",
        data: data,
        dataType: 'json',
        success: function(data) {
            validate_icn(data.icon, p);
            p.find('.result_txt').show();
            p.find('.result_txt').html(data.txt);
            console.log(data);
        }
    });
});
$("#address_up").blur(function() {
    "use strict";
    var address = $(this).val();
    var p = $(this).parent();
    var data = "address=" + address;
    $.ajax({
        type: "POST",
        url: "includes/validate.php",
        data: data,
        dataType: 'json',
        success: function(data) {
            p.find('.result_txt').show();
            p.find('.result_txt').html(data.txt);
        }
    });
});

$("#pwd_up").blur(function() {
    "use strict";
    var password = $(this).val();
    var p = $(this).parent();
    var data = "password=" + password;
    $.ajax({
        type: "POST",
        url: "includes/validate.php",
        data: data,
        dataType: 'json',
        success: function(data) {
            validate_icn(data.icon, p);
            p.find('.result_txt').show();
            p.find('.result_txt').html(data.txt);
        }
    });
});

$("#confrm_password").blur(function(){
    "use strict";
    var pwd = $("#rst_password").val();
    var cnfrm_pwd = $("#confrm_password").val();
    if(cnfrm_pwd === pwd){
        $(".result_icn").removeClass("glyphicon glyphicon-remove text-danger").addClass("glyphicon glyphicon-ok text-success");
    }else{
        $(".result_icn").removeClass("glyphicon glyphicon-ok text-success").addClass("glyphicon glyphicon-remove text-danger");
    }
});
/*******************************/
/*   End of AJAX Validation   */
/*******************************/

//Reloads Page
$(".close_alert").click(function() {
    location.assign("index.php");
});
$(".reset_body form").submit(function() {
console.log("aaa");
 event.preventDefault();
});
