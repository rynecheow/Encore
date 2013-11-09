require(['parsley'], function () {
    "use strict";
    var form = $('.signIn-container').find('.signIn-form');
    form.parsley();
    form.submit(function (e) {
        if (!form.parsley('validate')) {
            e.preventDefault();
            return false;
        }
    });
});