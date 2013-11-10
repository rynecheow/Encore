/**
 * Created by kelvin on 11/10/13.
 */
require(['parsley'], function () {
        "use strict";
        var form = $('.payment-form').find('.fill-form');
        form.parsley();
        form.submit(function (e) {
                if (!form.parsley('validate')) {

                    e.preventDefault();
                    return false;
                }
            }
        );
    }
);
