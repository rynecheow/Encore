require(['parsley'], function () {
    "use strict";
    var form = $('.create-event-container').find('.create-event-form');
    form.parsley();
    form.submit(function (e) {
        if (!form.parsley('validate')) {
            e.preventDefault();
            return false;
        }
    });
});


require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                $(function () {
                        $('.datepicker').datepicker(
                            {
                                onRender: function(date) {
                                    var now = new Date();
                                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                                }
                            }
                        );
                    }
                );

                $("#add-held").on("click",addNewHeldDate);

                function addNewHeldDate(e) {
                    "use strict";

                }

            }
        );
    }
);