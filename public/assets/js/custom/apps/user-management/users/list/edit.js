"use strict";
var KTUsersAddUser = (function () {
    const t = document.getElementById("kt_content_container"),
        e = t.querySelector("#edit_business_form"),
        n = new bootstrap.Modal(t);
    return {
        init: function () {
            (() => {
                var o = FormValidation.formValidation(e, {
                    fields: {
                        business_name:{validators:{notEmpty:{message:"Please enter business name"}}},
                    business_email:{validators:{notEmpty:{message:"Please enter business email"}}},
                    city:{validators:{notEmpty:{message:"Please enter city"}}},
                    state:{validators:{notEmpty:{message:"Please enter state"}}},
                    zip_code:{validators:{notEmpty:{message:"Please enter zip code "}}},
                    country:{validators:{notEmpty:{message:"Please select a country"}}},
                },
                    plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                });
                const i = t.querySelector('#edit_business_form_submit');
                i.addEventListener("click", (t) => {

                        o &&
                        o.validate().then(function (t) {
                            console.log("validated!"),
                               "";
                        });
                });
            })();
        },
    };

    function submitForm(){

    };

})();
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddUser.init();
});
