require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                $(function () {
                        /* bootstrap datepicker function */


                        $('input.datepicker').datepicker();

                        /* Bootstrap Tab Pane Function*/
                        $('#search a').click(function (e) {


                            e.preventDefault();
                            $(this).tab('show');
                        });

                        $('#filter a').click(function (e) {

                            e.preventDefault();

                            $(this).tab('show');
                        });

                        /*Search And Filter Button Function*/
                        $('.search-a').click(function () {
                            $(".search-background").css("background", "#F3AEAE");
                            $(".filter-background").css("background", "#FFFFFF");
                        });
                        $('.filter-a').click(function () {
                            $(".search-background").css("background", "#FFFFFF");
                            $(".filter-background").css("background", "#F3AEAE");

                        });

                        $(".main-selection").on("click", function (e) {
                            "use strict";
                            var target = $(e.target),
                                typeDiv = $(".type-div"),
                                locationDiv = $(".location-div"),
                                dateDiv = $(".date-div");

                            if (target.hasClass("filter-type")) {
                                typeDiv.css("display", "block");
                                locationDiv.css("display", "none");
                                dateDiv.css("display", "none");

                            }
                            else if (target.hasClass("filter-location")) {
                                locationDiv.css("display", "block");
                                typeDiv.css("display", "none");
                                dateDiv.css("display", "none");
                            }
                            else {
                                dateDiv.css("display", "block");
                                locationDiv.css("display", "none");
                                typeDiv.css("display", "none");
                            }
                        });

                        $(".type-div button").on("click",function(e){
                            "use strict";
                            var target = $(e.target);
                            if(target.hasClass("active")){
                                target.css("border","2px solid rgb(226, 226 ,226)");
                            }
                            else
                                target.css("border","2px solid #da4f49")
                        });

                        $(".location-div button").on("click",function(e){
                            "use strict";
                            var target = $(e.target);
                            if(target.hasClass("active")){
                                target.css("border","2px solid rgb(226, 226 ,226)");
                            }
                            else
                                target.css("border","2px solid #da4f49")
                        });

                        $(".new-label").on("click",function(e){
                            "use strict";
                            var target = $(e.target);
                            target.css()
                        });

                    }
                );

            }
        );
    }
);