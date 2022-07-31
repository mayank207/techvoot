
$("document").ready(function(){
    setTimeout(function(){
       $("div.alert").remove();
    }, 5000 ); // 5 secs
});

 /* Toastr */
 toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var _token = $("meta[name='_token']").attr('content');

var target = document.querySelector("#load_content");
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});

// $.validator.addMethod('checkemail', function (value) {
//     return /^([\w-\.]+@([\w-]+\.)+[a-z]{2,10})?$/.test(value);
// }, 'Please enter a valid email');

// $.validator.addMethod("noSpace", function(value, element) {
//     if($.trim(value) == 0) {
//         return false;
//     }
//     return true;
// }, "Space are not allowed");

// $.validator.addMethod("pwcheck", function (value) {
//     return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(value);
// }, "The password should contain minimum 8 characters at least 1 uppercase alphabet, 1 lowercase alphabet, 1 special character, 1 numeric value.");

