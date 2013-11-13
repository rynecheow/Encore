require(['parsley'], function () {
    "use strict";
    var form = $('.create-event-container').find('.merchant-add-form');
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
                var count = 0;
                $(function () {
                        $('.datepicker').datepicker(
                            {
                                format: "yyyy-mm-dd",
                                onRender: function (date) {
                                    var now = new Date();
                                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                                }
                            }
                        );

                        $('.held-date-class').datepicker({
                            format: "yyyy-mm-dd"
                        });

                        $('.held-time-class').timepicker({
                            minuteStep: 1,
                            defaultTime: false,
                            template: 'modal'
                        });
                    }
                );

                $("#add-held").on("click", addNewHeldDate);
//                $(document).on("submit",$(".merchant-add-form"),checkAllDate);



                function addNewHeldDate(e) {
                    "use strict";

                    var timeSpan = $(document.createElement("span")),
                        dateSpan = $(document.createElement("span")),
                        dateInput = $(document.createElement("input")),
                        timeInput = $(document.createElement("input")),
                        minusEvent = $(document.createElement("a")),
                        divWrapper = $(document.createElement("div")),
                        minusLogo = $(document.createElement("i")),
                        parentDiv = $("#held-date-groups");


                    timeSpan.addClass("time-span").html("Time : ");
                    dateSpan.addClass("date-span").html("Date : ");


                    count++;
                    divWrapper.attr("id", "newHeldDate" + count);
                    dateInput.attr({
                        type: "text",
                        class: "heldpicker held-date-class",
                        name: "event_held_date[" + count + "]",
                        "data-required": "true",
                        "data-trigger": "change",
                        "data-required-message": "Please enter date.",
                        "readonly": ""
                    });

                    timeInput.attr({
                        type: "text",
                        class: "timepicker held-time-class",
                        name: "event_held_time[" + count + "]",
                        "data-required": "true",
                        "data-trigger": "change",
                        "data-required-message": "Please enter time.",
                        "readonly": ""
                    });

                    dateInput.parsley('validate');
                    timeInput.parsley('validate');

                    minusEvent.attr({
                        id: count + "event_hdate",
                        class: "logo-action"
                    });

                    minusEvent.on("click", function (e) {
                        var parent = e.target.parentNode;
                        var index = parseInt($(parent).attr("id"), 10);
                        $("#newHeldDate" + index).remove();
                    });

                    minusLogo.attr({
                        class: "icon-remove icon-gray"
                    });

                    minusLogo.appendTo(minusEvent);

                    divWrapper.append(dateSpan).append(dateInput).append(timeSpan).append(timeInput)
                        .append(minusEvent);

                    parentDiv.append(divWrapper);

                    $('.held-date-class').datepicker({
                        format: "yyyy-mm-dd"
                    });

                    $('.held-time-class').timepicker({
                        minuteStep: 1,
                        defaultTime: false,
                        template: 'modal'
                    });

                }

            }

        )
        ;
    }
);