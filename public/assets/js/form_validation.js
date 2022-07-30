/* Advertisement Form */
function FORM_add_advertise() {
    // Define form element
    const add_banner_form = document.getElementById('add_banner_form');
    // Init form validation rules.
    var validator = FormValidation.formValidation(
        add_banner_form,
        {
            fields: { 
                name: { 
                    validators: { 
                        notEmpty: { 
                            message: "Name is required" 
                        } 
                    } 
                },
                ads_code: { 
                    validators: { 
                        notEmpty: { 
                            message: "Ads Code is required" 
                        },
                        stringLength: { 
                            max: 200,
                            message: 'Ads code must be less than 200 characters'
                        }
                    } 
                }, 
                ads_type: { 
                    validators: {
                        notEmpty: { 
                            message: "Ads Type is required" 
                        }
                    } 
                }
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }
    );
    // Submit button handler
    const submitButton = document.getElementById('add_banner_form_submit');
    submitButton.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();

        // Validate form before submit
        if (validator) {
            validator.validate().then(function (status) {
                console.log('validated!');

                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    var URL = $('#add_banner_form').attr('action');
                    var formData = new FormData($('#add_banner_form')[0]);
                    $.ajax({
                        url: URL,
                        type: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            // Remove loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;
                            if(response.status == 'success'){
                                window.location.href = response.redirect_url;
                            }else{
                                Swal.fire({ text: response.message, icon: "error", buttonsStyling: !1, confirmButtonText: "Okay", customClass: { confirmButton: "btn fw-bold btn-primary" } });
                            }
                        },
                        error: function(error){
                            // Remove loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;
                            console.log(error);
                            Swal.fire({ text: 'Something went wrong', icon: "error", buttonsStyling: !1, confirmButtonText: "Okay", customClass: { confirmButton: "btn fw-bold btn-primary" } });
                        }
                    });
                }
            });
        }
    });
}

/* Account setting Form */
function FORM_account_setting() {
    // Define form element
    const account_setting_form = document.getElementById('account_setting_form');
    // Init form validation rules.
    var validator = FormValidation.formValidation(
        account_setting_form,
        {
            fields: { 
                name: { 
                    validators: { 
                        notEmpty: { 
                            message: "Name is required" 
                        } 
                    } 
                }, 
                old_password: { 
                    validators: { 
                        notEmpty: { 
                            message: "Old Password is required" 
                        } 
                    } 
                },
                new_password: {
                    validators: {
                        notEmpty: {
                            message: 'Password is required.'
                        },
                        regexp: {
                            regexp: /^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/,
                            message: 'The password should contain Minimum 8 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Special Character.'
                        }
                    }
                },
                password_confirmation: {
                    validators: {
                        notEmpty: {
                            message: 'Confirm password is required.'
                        },
                        identical: {
                            field: 'new_password',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                }
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }
    );
    // Submit button handler
    const submitButton = document.getElementById('account_setting_form_submit');
    submitButton.addEventListener('click', function (e) {
        // Prevent default button action
        e.preventDefault();

        // Validate form before submit
        if (validator) {
            validator.validate().then(function (status) {
                console.log('validated!');

                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    var URL = $('#account_setting_form').attr('action');
                    var formData = new FormData($('#account_setting_form')[0]);
                    $.ajax({
                        url: URL,
                        type: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            // Remove loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;
                            if(response.status == 'success'){
                                Swal.fire({ text: response.message, icon: "success", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn fw-bold btn-primary" } });
                            }else{
                                Swal.fire({ text: response.message, icon: "error", buttonsStyling: !1, confirmButtonText: "Okay", customClass: { confirmButton: "btn fw-bold btn-primary" } });
                            }
                        },
                        error: function(error){
                            // Remove loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;
                            console.log(error);
                            Swal.fire({ text: 'Something went wrong', icon: "error", buttonsStyling: !1, confirmButtonText: "Okay", customClass: { confirmButton: "btn fw-bold btn-primary" } });
                        }
                    });
                }
            });
        }
    });
}

KTUtil.onDOMContentLoaded(function () {
    if($('#add_banner_form').length > 0){
        FORM_add_advertise();
    }
    if($('#account_setting_form').length > 0){
        FORM_account_setting();
    }
});
