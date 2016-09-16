<?php require "includes\processor.php"; ?>

<?php
start_session();
var_dump($_SESSION['laundry_cart']);
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title></title>
     <?php require 'resources.php';?>
   </head>
   <body>
     <p class=" a b">

     </p>
<script type="text/javascript">
$('p').append("abc");
$('p').append("<p>123</p>");
if($('p').hasClass('a b')){
  alert("a");
}
</script>
   </body>
 </html>
<!-- 
 <a href="#" class="back-to-top">Back to Top</a>
 a.back-to-top {
  display: none;
  width: 60px;
  height: 60px;
  text-indent: -9999px;
  position: fixed;
  z-index: 999;
  right: 20px;
  bottom: 20px;
  background: #27AE61 url("up-arrow.png") no-repeat center 43%;
  -webkit-border-radius: 30px;
  -moz-border-radius: 30px;
  border-radius: 30px;
}
var amountScrolled = 300;

$(window).scroll(function() {
  if ( $(window).scrollTop() > amountScrolled ) {
    $('a.back-to-top').fadeIn('slow');
  } else {
    $('a.back-to-top').fadeOut('slow');
  }
});
to animate
$('a.back-to-top').click(function() {
  $('html, body').animate({
    scrollTop: 0
  }, 700);
  return false; -->
<!-- }); -->
