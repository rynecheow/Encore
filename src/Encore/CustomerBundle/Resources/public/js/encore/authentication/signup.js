require(['parsley'], function () {
    "use strict";
    var form = $('.signUp-container').find('.signUp-form');
    form.parsley();
    form.submit(function (e) {
        if (!form.parsley('validate')) {
            e.preventDefault();
            return false;
        }
    });
});

