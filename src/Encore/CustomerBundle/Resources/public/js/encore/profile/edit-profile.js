require(['parsley'], function () {
    "use strict";
    var form = $('.profile-wrap').find('.edit-profile-form');
    form.parsley();
    form.submit(function (e) {
        if (!form.parsley('validate')) {
            e.preventDefault();
            return false;
        }
    });
});