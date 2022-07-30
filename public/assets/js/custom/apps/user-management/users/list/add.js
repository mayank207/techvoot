"use strict";
var KTUsersAddUser = (function () {
    const t = document.getElementById("kt_modal_edit_user"),
        e = t.querySelector("#edit_user_form"),
        n = new bootstrap.Modal(t);
    return {
        init: function () {
            (() => {
                var o = FormValidation.formValidation(e, {
                    fields: {
                        name: { validators: { notEmpty: { message: "Name is required" } } },username: { validators: { notEmpty: { message: "Username is required" }, regexp: { regexp: /^[a-zA-Z0-9._]+$/, message: 'The username can only consist of alphabetical, number, dot and underscore' }, stringLength: { max: 30,message: 'Username must be less than 30 characters'} } },
                        email: { validators: { notEmpty: { message: "Email is required" }, stringLength: { max: 100,message: 'Email must be less than 100 characters'} } }
                },
                    plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                });
                const i = t.querySelector('[data-kt-users-modal-action="submit"]');
                i.addEventListener("click", (t) => {
                    t.preventDefault(),
                        o &&
                        o.validate().then(function (t) {
                            // console.log("validated!"),
                                "Valid" == t
                                    ? (i.setAttribute("data-kt-indicator", "on"),
                                        (i.disabled = !0),
                                        submitForm(),
                                        setTimeout(function () {
                                            i.removeAttribute("data-kt-indicator"),
                                                (i.disabled = !1);
                                        }, 2e3))
                                    : "";
                        });
                }),
                    t.querySelector('[data-kt-users-modal-action="cancel"]').addEventListener("click", (t) => {
                        n.hide();
                    }),
                    t.querySelector('[data-kt-users-modal-action="close"]').addEventListener("click", (t) => {
                        n.hide();
                    });
            })();
        },
    };

    function submitForm(){
        var URL = $('#edit_user_form').attr('action');
        var formData = new FormData($('#edit_user_form')[0]);
        $.ajax({
            url: URL,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
               if(response.status == 'success'){
                    Swal.fire({ text: "User updated successfully.", icon: "success", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn fw-bold btn-primary" } });
                    $('#kt_modal_add_user').find('[data-kt-users-modal-action="close"]').trigger('click');
                    $('#filter_form').trigger('submit');
                    n.hide();
               }else{
                    Swal.fire({ text: response.message, icon: "error", buttonsStyling: !1, confirmButtonText: "Okay", customClass: { confirmButton: "btn fw-bold btn-primary" } });
                    $('#kt_modal_add_user').find('[data-kt-users-modal-action="close"]').trigger('click');
               }
            },
         });
    };

})();
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddUser.init();
});
