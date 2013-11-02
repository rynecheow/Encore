require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                "use strict";
                var a = function () {
                    var b = $(window).scrollTop();
                    var d = $("#header-anchor").offset().top;
                    var c = $("#header");
                    if (b > d) {
                        c.css({
                            position: "fixed",
                            top: "0px"
                        })
                    } else {
                        c.css({
                            position: "absolute",
                            top: ""
                        })
                    }
                };
                $(window).scroll(a);
                a();
            }
        );
    }
);