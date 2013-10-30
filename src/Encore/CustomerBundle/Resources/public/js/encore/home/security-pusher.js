require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                "use strict";
                var container = $('.st-container');
                var bodyFn = function () {
                    $('.st-pusher').on('click', function () {
                        if (container.hasClass('st-menu-open')) {
                            container.removeClass('st-menu-open');
                            container.off("click", bodyFn);
                        }
                    });
                };
                $("#effect").on("click", function (e) {
                    console.log("Got In Function");
                    e.stopPropagation();
                    container.addClass("st-menu-open");
                    container.on("click", bodyFn);
                });
            }
        );
    }
);