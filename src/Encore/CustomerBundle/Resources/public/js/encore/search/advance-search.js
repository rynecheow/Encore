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


                        function filterTypeEvent(e) {
                            "use strict";
                            var target = $(e.target);
                            var divParent = $(".label-div");

                            if (target.hasClass("active")) {
                                target.css("border", "2px solid #e2e2e2");
                                $.each($(".new-label"), function (index, valueData) {
                                    if ($(this).html() === target.html()) {
                                        $(this).remove();
                                    }
                                });
                            }
                            else {
                                var a = $(document.createElement("a")),
                                    span = $(document.createElement("span"));

                                a.html(target.html()).appendTo(divParent);
                                a.attr("class", "new-label");
                                a.attr("href", "javascript:void(0)");
                                a.on("click", function (e) {
                                    "use strict";

                                    $.each($(".type-div button"), function (index, valueData) {
                                        if ($(this).html() === $(e.target).html()) {
                                            $(this).css("border", "2px solid #e2e2e2");
                                            $(this).removeClass("active");
                                        }
                                    });
                                    e.target.remove();
                                });
                                target.css("border", "2px solid #da4f49");
                            }

                        }

                        function filterLocationEvent(e) {
                            "use strict";
                            var target = $(e.target);
                            var divParent = $(".label-div");

                            if (target.hasClass("active")) {
                                target.css("border", "2px solid #e2e2e2");
                                $.each($(".new-label"), function (index, valueData) {
                                    if ($(this).html() === target.html()) {
                                        $(this).remove();
                                    }
                                });
                            }
                            else {
                                if($(".location-div .active").length > 1 )
                                {

                                    $(target).popover();
                                    $(target).removeClass("active");
                                    return;
                                }


                                var a = $(document.createElement("a")),
                                    span = $(document.createElement("span"));

                                a.html(target.html()).appendTo(divParent);
                                a.attr("class", "new-label");
                                a.attr("href", "javascript:void(0)");
                                a.on("click", function (e) {
                                    "use strict";

                                    $.each($(".location-div button"), function (index, valueData) {
                                        if ($(this).html() === $(e.target).html()) {
                                            $(this).css("border", "2px solid #e2e2e2");
                                            $(this).removeClass("active");
                                        }
                                    });
                                    e.target.remove();
                                });
                                target.css("border", "2px solid #da4f49");
                            }

                        }

                        $(".type-div button").on("click", filterTypeEvent);


                        $(".location-div button").on("click", filterLocationEvent);


                    }
                );

            }
        );
    }
);