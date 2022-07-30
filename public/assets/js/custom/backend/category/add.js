"use strict";
var KTAddCategory = (function () {
    const t = document.getElementById("kt_content_container"),
        e = t.querySelector("#add_category_form"),
        n = new bootstrap.Modal(t);
    return {
        init: function () {
            (() => {
                var o = FormValidation.formValidation(e, {
                    fields: {
                        title:{validators:{notEmpty:{message:"Please enter category title"}}},

                },
                    plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                });
                const i = t.querySelector('#add_category_form_submit');
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
    KTAddCategory.init();
});
