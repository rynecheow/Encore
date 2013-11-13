//require(['parsley'], function () {
//    "use strict";
//    var form = $('.edit-event-container').find('.merchant-edit-form');
//    form.parsley();
//    form.submit(function (e) {
//        if (!form.parsley('validate')) {
//            e.preventDefault();
//            return false;
//        }
//    });
//});


require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                var count = 0;
                var nowTemp = new Date();
                var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

                var saleStart = $('#start-sale').datepicker(
                    {
                        format: "yyyy-mm-dd",
                        onRender: function (date) {
                            return date.valueOf() < now.valueOf() ? 'disabled' : '';
                        }
                    }
                ).on('changeDate',function (ev) {
                        if (ev.date.valueOf() > saleEnd.date.valueOf()) {
                            var newDate = new Date(ev.date)
                            newDate.setDate(newDate.getDate() + 1);
                            saleEnd.setValue(newDate);
                        }
                        saleStart.hide();
                        $('#end-sale')[0].focus();
                    }
                ).data('datepicker');

                var saleEnd = $('#end-sale').datepicker(
                    {
                        format: "yyyy-mm-dd",
                        onRender: function (date) {
                            return date.valueOf() <= saleStart.date.valueOf() ? 'disabled' : '';
                        }
                    }
                ).on('changeDate',function (ev) {
                        var newDate = new Date(ev.date);
                        newDate.setDate(newDate.getDate() + 1);
                        $(".held-date-minor-wrapper").remove();
                        addNewHeldDate();
                        $('.held-date-class').datepicker(
                            {
                                format: "yyyy-mm-dd",
                                onRender: function (date) {
                                    return date.valueOf() <= saleEnd.date.valueOf() ? 'disabled' : '';
                                }
                            }
                        ).data('datepicker').setValue(newDate);
                        $('.held-date-class').val('');
                        saleEnd.hide();
                    }
                ).data('datepicker');

                $('.held-time-class').timepicker(
                    {
                        minuteStep: 30,
                        defaultTime: false,
                        template: 'modal'
                    }
                );

//                $("#add-held").on("click", addNewHeldDate);

                function addNewHeldDate() {
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
                    divWrapper.attr("class", "added-held-date");
                    dateInput.attr({
                        type: "text",
                        class: "heldpicker held-date-class",
                        name: "event_held_date[" + count + "]",
                        "data-required": "true",
                        "data-trigger": "change",
                        "data-required-message": "Please enter date.",
                        "readonly": ""
                    });

                    timeInput.attr(
                        {
                            type: "text",
                            class: "timepicker held-time-class",
                            name: "event_held_time[" + count + "]",
                            "data-required": "true",
                            "data-trigger": "change",
                            "data-required-message": "Please enter time.",
                            "readonly": ""
                        }
                    );

                    dateInput.parsley('validate');
                    timeInput.parsley('validate');

                    minusEvent.attr(
                        {
                            id: count + "event_hdate",
                            class: "logo-action"
                        }
                    );

                    minusEvent.on("click",
                        function (e) {
                            var parent = e.target.parentNode;
                            var index = parseInt($(parent).attr("id"), 10);
                            $("#newHeldDate" + index).remove();
                        }
                    );

                    minusLogo.attr(
                        {
                            class: "icon-remove icon-gray"
                        }
                    );

                    minusLogo.appendTo(minusEvent);

                    divWrapper.append(dateSpan).append(dateInput).append(timeSpan).append(timeInput)
                        .append(minusEvent);

                    parentDiv.append(divWrapper);

                    var newDate = new Date(saleEnd.date)
                    newDate.setDate(newDate.getDate() + 1);
                    dateInput.datepicker(
                        {
                            format: "yyyy-mm-dd",
                            onRender: function (date) {
                                return date.valueOf() <= saleEnd.date.valueOf() ? 'disabled' : '';
                            }
                        }
                    ).data('datepicker').setValue(newDate);

                    dateInput.val("");

                    timeInput.timepicker(
                        {
                            minuteStep: 30,
                            defaultTime: false,
                            template: 'modal'
                        }
                    );

                }

            }

        );
    }
);