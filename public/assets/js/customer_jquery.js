/*
*
* Created By : Pankaj Mathavadiya
* Created At : 2022-03-08
*
*/

$.validator.addMethod('checkemail', function (value) {
    return /^([\w-\.]+@([\w-]+\.)+[a-z]{2,10})?$/.test(value);
}, 'Please enter a valid email');

$.validator.addMethod("noSpace", function(value, element) {
    if($.trim(value) == 0) {
        return false;
    }
    return true;
}, "Space are not allowed");

$.validator.addMethod("pwcheck", function (value) {
    return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(value);
}, "The password should contain minimum 8 characters at least 1 uppercase alphabet, 1 lowercase alphabet, 1 special character, 1 numeric value.");

$.validator.addMethod("username", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._]+$/.test(value);
},"Please enter valid username");




/* Toaster JQuery */
toastr.options = {
    closeButton: true,
    progressBar: true,
    showMethod: 'slideDown',
    timeOut: 4000
};
/* END - Toaster JQuery*/

