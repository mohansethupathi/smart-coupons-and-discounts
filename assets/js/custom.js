$(document).ready(function(){

$(".userroles,.freeproducts").select2({"width":"100%"});

$(document).on( 'click', '#copylink', function()
 {
     myFunction();
 });
 
 function myFunction() {
   
    var copyText = document.getElementById("couponlink");
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices
    navigator.clipboard.writeText(copyText.value);
    alert("Link Copied");

  }

  $(document).on( 'click', '#custom_coupon_field', function()
 {
    togglecouponlink();
 });

 function togglecouponlink()
 {
    if($("#custom_coupon_field").prop("checked") == true)
    {
        $(".couponsdiv").css("display","block");
    }else{
        $(".couponsdiv").css("display","none");
    }
 }

 togglecouponlink();

})