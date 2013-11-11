require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                $(function () {
                        $('input.datepicker').datepicker();
                        $('#search a').click(function (e) {
                            e.preventDefault();
                            
                            $(this).tab('show');
                        });

                        $('#filter a').click(function (e) {
                            e.preventDefault();
                            $(this).tab('show');
                        });
                    }
                );

            }
        );
    }
);