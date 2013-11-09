require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                $(function () {
                        $('#datepicker-from').datepicker();
                        $('#datepicker-to').datepicker();
                    }
                );

            }
        );
    }
);