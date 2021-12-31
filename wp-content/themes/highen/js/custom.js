
const phoneInputField = document.querySelector("#phone");
const phoneInput = window.intlTelInput(phoneInputField, {
 utilsScript:
    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
});



$(".panel-collapse").on("show.bs.collapse", function () {
 $(this).siblings(".panel-heading").addClass("active");
});

$(".panel-collapse").on("hide.bs.collapse", function () {
 $(this).siblings(".panel-heading").removeClass("active");
});


// window.onload = function() {
//   document.querySelector(".button > a").className = "btn-top";
// }


