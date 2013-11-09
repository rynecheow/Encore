require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                $(function () {
                        $('input.datepicker').datepicker();
                    }
                );

            }
        );
    }
);