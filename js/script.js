(function() {
    var val = $('result_txt').parent().find('input').val();
    if ($.trim(val) == "" && $('.result_txt').html() == "") {
        $('.result_txt').hide();
    }
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

function add_to_cart($item) {
    "use strict";
    // console.log("aa");
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
            dataType:'json',
            success: function(data) {
                $(".cart_body").html(data.txt);
                $(".num_of_items").html(data.count);
            }
        });
    }
    $item.parent().find('.quantity').val("0");
}

function remove_from_cart($item) {
    var id = parseInt($item.parent().find('input').val());
    var data = 'id=' + id;
    $.ajax({
        type: 'POST',
        url: 'includes/process_cart.php',
        data: data,
        dataType:'json',
        success: function(data) {
            $(".num_of_items").html(data.count);
            $(".cart_body").html(data.txt);
            if ($(".cart_body tbody").html() === "") {
                $('#laundry_cart').modal('hide');
            }
        }
    })
}
// display laundry cart modal
function view_cart() {
    "use strict";
    var data = 'view';
    $.ajax({
        type: 'GET',
        url: 'includes/process_cart.php',
        data: data,
        dataType:'json',
        success: function(data) {
            $(".num_of_items").html(data.count);
            if (data.txt == "<p>Laundry Cart is currently empty</p>") {
                $(".clear_cart, .chk_out").hide();
            } else {
                $(".clear_cart, .chk_out").show();
            }
            $(".cart_body").html(data.txt);

        }
    })
}

function clear_cart() {
    "use strict";
    var data = 'clear';
    $.ajax({
        type: 'GET',
        url: 'includes/process_cart.php',
        data: data,
        dataType:'json',
        success: function(data) {
            $(".num_of_items").html(data.count);
            $(".cart_body").html(data.txt);
            $('#laundry_cart').modal('hide');
        }

    })
}
//registeration
function validate_icn(icon, parent) { // toggle Validation Icon
    if (parent.find('.result_icn').hasClass('glyphicon-remove')) {
        if (icon === 'glyphicon glyphicon-ok text-success') {
            parent.find('.result_icn').removeClass('glyphicon-remove text-danger');
            parent.find('.result_icn').addClass('glyphicon-ok text-success');

        }
    } else if (parent.find('.result_icn').hasClass('glyphicon-ok')) {
        if (icon === 'glyphicon glyphicon-remove text-danger') {
            parent.find('.result_icn').removeClass('glyphicon-ok text-warning');
            parent.find('.result_icn').addClass('glyphicon-remove text-danger');
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
    // console.log(p.attr('class'));
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
$(".close_alert").click(function() {
    location.assign("index.php");
});
