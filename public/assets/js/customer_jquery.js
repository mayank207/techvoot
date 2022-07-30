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

$.validator.addMethod("mobile_number", function (value, element) {
    return this.optional(element) ||
        value.match(/^[0-9,\-]+$/);
}, "Please enter a valid number");

$.validator.addMethod("input_mask_mobile_number", function (value, element) {
    return /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/is.test(value);

}, "Please enter a valid number");

$.validator.addMethod("validateAddress", function(value, element) {
    if ($("#edit_latitude").val().length > 0 && $('#edit_latitude').val().length > 0) {
        return true;
    }else{
        return false;
    }
}, "Please enter valid address");

$.validator.addMethod("pwcheck", function (value) {
    return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(value);
}, "The password should contain minimum 8 characters at least 1 uppercase alphabet, 1 lowercase alphabet, 1 special character, 1 numeric value.");

$.validator.addMethod("username", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._]+$/.test(value);
},"Please enter valid username");

$.validator.addMethod("checkurl", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._:/]+$/.test(value.trim());
},"Please enter valid url");

$.validator.addMethod("checkWebsiteUrl", function(value, element) {
    return this.optional(element) || /^((https?|ftp|smtp):\/\/)?(\www\.[a-z0-9]{5,})+(\.[a-z]{2,}){1,3}(#?\/?[a-zA-Z0-9#]+)*\/?(\?[a-zA-Z0-9-_]+=[a-zA-Z0-9-%]+&?)?$/.test(value.trim());
},"Please enter valid url");



/* Toaster JQuery */
toastr.options = {
    closeButton: true,
    progressBar: true,
    showMethod: 'slideDown',
    timeOut: 4000
};
/* END - Toaster JQuery*/

/* Business pagination */
$(document).on('click', '.business-list-pagination a', function (e) {
    e.preventDefault();
    var page_number = $(this).attr('href').split('page=')[1];
    $('#search-page').val(page_number);
    $('#business-filter').trigger('submit');
});
/* END Filter Ajax*/


/* Business pagination */
$(document).on('click', '.cust-sorting-item', function () {
    var value = $(this).attr('data-value');
    var title = $(this).attr('data-title');
    $('.show-sorting-title').html(title);
    $('#search-sorting').val(value);
    $('#business-filter').trigger('submit');
});
/* END Filter Ajax*/

/* Business pagination */
$(document).on('click', '.location_business', function () {
    var value = $(this).attr('data-value');
    var location=$('#input_location').val(value);
    $('#business-filter').trigger('submit');
});
/* END Filter Ajax*/

/* Business Fliter */
$(document).on('submit', '#business-filter', function (e) {
    e.preventDefault();
    var action_url = $(this).attr('action');
    var form_data = $(this).serialize();
    var search_keyword = $('#search_keyword').val();
    var input_location = $('#input_location').val();
    if(search_keyword != ""){
        $('#show-search').parent().removeClass('d-none');
        $('#show-search').html(search_keyword);
    }else{
        $('#show-search').html('Business Listing');
    }
    if(input_location != ""){
        $('#show-search-location').html('in '+input_location).removeClass('d-none');
    }else{
        $('#show-search-location').addClass('d-none');
    }
    $.blockUI({ message: '<h1>Loading, Please wait...</h1>', css: { 'border-radius': '50px', border: '1px solid #ffffff' } });
    $.ajax({
        url: action_url,
        type: "GET",
        dataType: 'json',
        data: form_data,
        success: function (data) {
            $.unblockUI();
            window.history.pushState({href: this.url}, '', this.url);
            if (data.status == 200) {
                $('.load-business-list').html(data.content);
                $('.show-total-listing').removeClass('d-none');
                $('.total-listing').html(data.total_records);
                if(data.total_records <= 5){
                    $('#filter_text').text(data.text);
                }
            } else {
                toastr.error(data.message);
            }
        },
        error: function () {
            $.unblockUI();
            window.history.pushState({href: this.url}, '', this.url);
            toastr.error('Something went wrong');
        }
    });
});
/* END Filter Ajax*/

$(function () {
    $("#price_range").val("$1 - $10000");
    $("#price-range").slider({
        range: true,
        min: 1,
        max: 10000,
        values: [1, 10000],
        slide: function (event, ui) {
            $("#price_range").val("$" + ui.values[0] + " - $" + ui.values[1]);
        }
    });
    $("#price_range").val("$" + $("#price-range").slider("values", 0) + " to   $" + $("#price-range").slider("values", 1));
});
/* End Business pagination */

/* Add favourite Jquery */
$(document).on('click','.favourite',function(e){
    e.preventDefault();
    var URL  = $(this).data('href');
    var id  = $(this).data('id');
    var is_favourites =$(this).data('is_favourite');
    $(this).data('is_favourite','20');
        if(is_favourites == 1){
            $(this).removeClass("btn-following");
            $(this).addClass("btn-follow");
            $(this).data('is_favourite','0');
        }
        else{
            $(this).removeClass("btn-follow");
            $(this).addClass("btn-following");
            $(this).data('is_favourite','1');
        }
    $.ajax({
        url:URL,
        type: 'post', // replaced from put
        dataType: "JSON",
        data: {'_token': $("input[name=_token]").val(),'id':id ,'is_favourites':is_favourites},
        success: function (response)
        {
            if(is_favourites=='1'){
                toastr.success('Business remove from favourite successfully.');
            }
            else{
                toastr.success('Business add to favourite successfully.');
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText); // this line will save you tons of hours while debugging
            Swal.fire({ text: "Something went wrong!", icon: "error", buttonsStyling: !1, confirmButtonText: "Okay", customClass: { confirmButton: "btn fw-bold btn-primary" } });
        }
    });
    });
/* Add favourite Jquery */

/* Business pagination */
    /*Ajax Pagination*/
    $(document).on('click','.business-list-pagination a',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: "GET",
            dataType: 'json',
            cache: false,
            success: function(data) {
                if(data.status == 200){
                    $('.load-business-list').html(data.content);
                }else{
                    // toastr.error(data.message);
                }
            },
            error: function(){
                blockUI.release();
                // toastr.error('Something went wrong');
            }
        });
    });
    /* END Filter Ajax*/

    /* End Business pagination */

    /* start Business contact now */
    $(document).on('click', '.contact_now', function () {
        var id = $(this).attr('id');
        $('#business_id').val(id);
        $('#name').val('');
        $('#email').val('');
        $('#mobile').val('');
        $('#description').val('');
        $('#contactModal').modal('show');
    });


      $("#contact_now_form").validate({
    rules: {
        name: {
            required:true ,
        },
        email: {
            checkemail:true,
            required: true,
                },
        mobile_number:  {
            required:true,
            input_mask_mobile_number:true,
        },
        description:{
            required:true ,
        },
    },
    messages: {
        name: 'Please enter name',
        email:{
            required:"Please enter email",
            remote:"Email is already exists",
            checkemail:"Please enter valid email",
        },
        mobile_number: {
            required:"Please enter mobile number",
            input_mask_mobile_number:"Please enter a valid number",
        },
        description:{
            required:"Please enter description",
        }
    },
    submitHandler: function (form) {

        return true;
    },
    success: function(label,element) {
        label.parent().removeClass('has-danger');
    },
    });

    /*Begin add review Ajax*/
    $(document).on('submit','#contact_now_form',function(e){
        e.preventDefault();
        $(this).find('.submit-form-btn').append(' <i class="fa fa-spin fa-spinner"></i>').attr('disabled',true);
        var form_url    = $(this).attr('action');
        var form_data   = $(this).serialize();
        $.ajax({
            url: form_url,
            type: 'POST',
            data: form_data,
            success: function(response){
                $('#contact_now_form').find('.submit-form-btn').html('Submit').attr('disabled',false);
                if(response.success == true){
                    location.reload();
                }else{
                    toastr.error(response.message);
                }
            },
        });
    });

    /* End Business contact now  */

    /* start Business ask quote  */
    $("#ask_quote_form").validate({
        rules: {
            name: {
                required:true ,
            },
            email: {
                checkemail:true,
                required: true,
                    },
                mobile_number:  {
                    required:true,
                    input_mask_mobile_number:true,
                },
            description:{
                required:true ,
            },
        },
        messages: {
            name: 'Please enter name',
            email:{
                required:"Please enter email",
                remote:"Email is already exists",
                checkemail:"Please enter valid email",
            },
            mobile_number: {
                required:"Please enter mobile number",
                input_mask_mobile_number:"Please enter a valid number",
            },
            description:{
                required:"Please enter description",
            }
        },
        submitHandler: function (form) {

            return true;
        },
        success: function(label,element) {
            label.parent().removeClass('has-danger');
        },
        });


    $(document).on('click', '.ask_quote', function () {
        var id = $(this).attr('id');
        $('#business_id_ask_quote').val(id);
        $('#name').val('');
        $('#email').val('');
        $('#mobile').val('');
        $('#description').val('');
        $('#askQuoteModal').modal('show');
    });

     /*Begin add review Ajax*/
     $(document).on('submit','#ask_quote_form',function(e){
        e.preventDefault();
        $(this).find('.submit-form-btn').append(' <i class="fa fa-spin fa-spinner"></i>').attr('disabled',true);
        var form_url    = $(this).attr('action');
        var form_data   = $(this).serialize();
        $.ajax({
            url: form_url,
            type: 'POST',
            data: form_data,
            success: function(response){
                $('#ask_quote_form').find('.submit-form-btn').html('Submit').attr('disabled',false);
                if(response.success == true){
                    location.reload();
                }else{
                    toastr.error(response.message);
                }
            },
        });
    });

     /* End Business ask quote  */

     /* start Business give review  */

     $("#review_form").validate({
        rules: {
            rating: {
                required:true,
            },
            review:{
                required:true,
                noSpace:true,
            },
        },
        messages: {
            rating:{
                required:"Please give rating to this business.",
            },
            review:{
                required:"Please add your review.",
                noSpace: 'White space not allowed',
            }
        },
        submitHandler: function (form) {

            return true;
        },
        success: function(label,element) {
            label.parent().removeClass('has-danger');
        },
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
            $('#form-step-one').addClass('error');
        }
    });

    $(document).on('click', '.give_review', function () {
        var id = $(this).data('id');
        $('#review_form').trigger('reset');
        $("#review_form").validate().resetForm();
        $('#review_form').find('#hidden_business_id').val(id);
        $('#reviewModal').modal('show');
    });

    /*Begin add review Ajax*/
    $(document).on('submit','#review_form',function(e){
        e.preventDefault();
        $(this).find('.submit-form-btn').append(' <i class="fa fa-spin fa-spinner"></i>').attr('disabled',true);
        var form_url    = $(this).attr('action');
        var form_data   = $(this).serialize();
        $.ajax({
            url: form_url,
            type: 'POST',
            data: form_data,
            success: function(response){
                $('#review_form').find('.submit-form-btn').html('Submit').attr('disabled',true);
                if(response.success == true){
                    location.reload();
                }else{
                    toastr.error(response.message);
                }
            },
        });
    });
    /* End Business review  */

  $('#country_code').select2({
     placeholder: "Select Country Code",
  });

  $('#denomination').select2({
    placeholder: "Select Denomination",
 });
 $('#leader').select2({
    placeholder: "Select Pastor/Leader",
 });
 $('#category').select2({
    placeholder: "Select Category",
 });
 $('#sub_category').select2({
    placeholder: "Select Services",
    maximumSelectionLength: 5,
    language: {
        maximumSelected: function (e) {
            var t = "You can only select 5 services";
            return t ;
        }
    }
 });


   /* mobile number field input mask */
    $(document).ready(function(){
        $('.mobile_input_mask').inputmask('(999)-999-9999');
    });

$(document).on('keyup','#filter_form input',function(e){
    if($(this).val().length > 2 || $(this).val().length == 0){
        $('#filter_page').val(0);
        $('#filter_form').trigger('submit');
    }
});

$(document).on('submit','#filter_form',function(e){
    e.preventDefault();
    var form_data = $(this).serialize();
    var form_url = $(this).attr('action');
    $.ajax({
        type: "GET",
        url: form_url,
        dataType: 'json',
        cache: false,
        data: form_data,

        success: function(data) {
            if(data.status == 200){
                $('#load_content').html(data.content);
            }else{
                toastr.error(data.message);
            }
        },
        error: function(){
            toastr.error('Something went wrong');
        }
    });
});

  /* contact now button popover */
  $('.contact_popover').popover({
    container: 'body'
  })


  $(document).on('click','.signup-second-step',function(){
      var step = $(this).data('step');
      var url = $(this).data('url');

        $.ajax({
            url: url,
            type: "get",
            dataType: 'json',
            success: function (response) {
                alert(response);
                $('#main_form').html(response.html_form);
                formValidation();
            }
        });


        $('#form-step-two').addClass('active');

});

// read more javascript start
$('.read-more-content').addClass('hide_content')
    $('.read-more-show, .read-more-hide').removeClass('hide_content')

// Set up the toggle effect:
$('.read-more-show').on('click', function(e) {
    $(this).next('.read-more-content').removeClass('hide_content');
    $(this).addClass('hide_content');
    e.preventDefault();
});

// Changes contributed by @diego-rzg
$('.read-more-hide').on('click', function(e) {
    var p = $(this).parent('.read-more-content');
    p.addClass('hide_content');
    p.prev('.read-more-show').removeClass('hide_content'); // Hide only the preceding "Read More"
    e.preventDefault();
});
// read more javascript End
