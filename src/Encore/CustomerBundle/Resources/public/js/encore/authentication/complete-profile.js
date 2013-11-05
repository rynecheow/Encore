require(['parsley'], function () {
    "use strict";
    var form = $('.complete-profile-container').find('.complete-profile-form');
    form.parsley();
    form.submit(function (e) {
        if (!form.parsley('validate')) {
            e.preventDefault();
            return false;
        }
    });
});