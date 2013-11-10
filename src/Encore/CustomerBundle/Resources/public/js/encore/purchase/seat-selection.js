require(['domReady'],
    function (domReady) {
        "use strict";
        domReady(
            function () {
                var seatsMatrix = {
                    col: 50,
                    row: 20
                };

                function tickDiv(target) {
                    if (target.hasClass("empty")) {
                        target.attr("class", "selected");
                    } else {
                        target.attr("class", "empty");
                    }
                }

                function checkNext(next1, next2) {
                    if (next1.hasClass("empty")) {
                        return !next2.hasClass("selected");
                    }
                    return true;
                }

                /**
                 * Called when a seat is selected
                 */
                $("table.seatTable tbody tr td div").click(function (e) {
                    var target, str, endOfRow, endOfCol, colValue, rowValue, totalCol, previousCol, nextCol, middlePreviousCol, middleNextCol, previousDiv, previousTwoDiv, nextDiv, nextTwoDiv, difference, selectedSeats, rowLabel;
                    target = $(e.target);
                    str = target.attr("id");
                    endOfRow = str.indexOf("row");
                    endOfCol = str.indexOf("col") + 3;
                    colValue = parseInt(str.substring(endOfCol, str.length), 10);
                    rowValue = parseInt(str.substring(0, endOfRow), 10);

                    totalCol = parseInt(seatsMatrix.col, 10);
                    previousCol = parseInt(colValue - 2, 10);
                    nextCol = parseInt(colValue + 2, 10);

                    middlePreviousCol = parseInt(colValue - 1, 10);
                    middleNextCol = parseInt(colValue + 1, 10);

                    previousDiv = $("#" + rowValue + "rowcol" + middlePreviousCol);
                    previousTwoDiv = $("#" + rowValue + "rowcol" + previousCol);

                    nextDiv = $("#" + rowValue + "rowcol" + middleNextCol);
                    nextTwoDiv = $("#" + rowValue + "rowcol" + nextCol);

                    if (target.hasClass("empty")) {
                        difference = parseInt($("#ticketQtySelector").val() - $("table.seatTable tbody tr td div.selected").length, 10);
                        if (difference !== 0) {
                            if (previousDiv.hasClass("empty")) {
                                if (previousTwoDiv.hasClass("selected")) {
                                    alert("You cannot select a seat which leaves a single seat gap.");
                                } else {
                                    if (checkNext(nextDiv, nextTwoDiv)) {
                                        tickDiv(target);
                                    } else {
                                        alert("You cannot select a seat which leaves a single seat gap.");
                                    }
                                }
                            } else {
                                if (checkNext(nextDiv, nextTwoDiv)) {
                                    tickDiv(target);
                                } else {
                                    alert("You cannot select a seat which leaves a single seat gap.");
                                }
                            }
                        } else {
                            alert("You have reached your max amount of selected tickets.");
                        }
                    } else if (target.hasClass("selected")) {
                        if (nextDiv.hasClass("empty") || previousDiv.hasClass("empty")) {
                            target.attr("class", "empty");
                        } else if (nextDiv.hasClass("selected") && !previousDiv.hasClass("selected")) {
                            target.attr("class", "empty");
                        } else if (previousDiv.hasClass("selected") && !nextDiv.hasClass("selected")) {
                            target.attr("class", "empty");
                        } else if (previousDiv.hasClass("sold") || previousDiv.hasClass("locked")) {
                            if (totalCol === middleNextCol) {
                                target.attr("class", "empty");
                            } else if (nextDiv.hasClass("sold") || nextDiv.hasClass("locked")) {
                                target.attr("class", "empty");
                            } else {
                                alert("You cannot un-select a seat which leaves a single seat gap.");
                            }
                        } else if (nextDiv.hasClass("sold") || nextDiv.hasClass("locked")) {
                            if (totalCol === middlePreviousCol || middlePreviousCol < 0) {
                                target.attr("class", "empty");
                            } else if (previousDiv.hasClass("sold") || previousDiv.hasClass("locked")) {
                                target.attr("class", "empty");
                            } else {
                                alert("You cannot un-select a seat which leaves a single seat gap.");
                            }
                        } else {
                            alert("You cannot un-select a seat which leaves a single seat gap.");
                        }
                    } else if (target.hasClass("sold")) {
                        alert("You cannot select a seat which has already been sold.");
                    } else if (target.hasClass("locked")) {
                        alert("You cannot select a seat which is currently locked.");
                    }

                    selectedSeats = $("table.seatTable tbody tr td div.selected");
                    selectedSeats.sort();
                    $("#seatAllocationLabel").html("");
                    $.each(selectedSeats, function (index, target) {
                        str = $(target).attr("id");
                        endOfRow = str.indexOf("row");
                        endOfCol = str.indexOf("col") + 3;
                        colValue = parseInt(str.substring(endOfCol, str.length), 10);
                        rowValue = parseInt(str.substring(0, endOfRow), 10);
                        rowLabel = $("tr[id='row" + rowValue + "'] td div.tableLabel").text();
                        colValue = colValue + 1;
                        rowValue = rowValue + 1;
                        $("#seatAllocationLabel").append("<p>Row : " + rowLabel + "; Seat No. : " + colValue + "</p>");
                    });

                    difference = $("#ticketQtySelector").val() - $("table.seatTable tbody tr td div.selected").length;
                    $("#ticketQtyLabel").html(difference + " unselected ticket(s)");
                    if (difference > 0) {
                        $("input:submit").attr("hidden", "hidden");
                        $("#seatAllocComplete").attr("class", "incomplete");
                    } else {
                        $("input:submit").removeAttr("hidden");
                        $("#seatAllocComplete").attr("class", "complete");
                    }
                });

                /**
                 * Unselects all selected seats
                 * Remove text in seat allocation label at summary form
                 * Reset text in ticket quantity label to value to ticket quantity to purchase
                 */
                function resetSeats() {
                    $("table.seatTable tbody tr td div.selected").each(function () {
                        $(this).attr("class", "empty");
                    });
                    $("#seatAllocationLabel").html("");
                }

                /**
                 * Called when reset button for seat allocation is pressed
                 * Reset selected seats and change ticket quantity label
                 */
                $("#resetButton").click(function () {
                    resetSeats();
                    $("#ticketQtyLabel").html(parseInt($("#ticketQtySelector").val(), 10) + " unselected ticket(s)");
                });

                /**
                 * Hides/Display time selection step and un-check all checked time radio buttons
                 * @param hideFlag
                 */
                function hideTimeStep(hideFlag) {
                    $("#dateTimeLabel").html("");
                    if (hideFlag) {
                        $("#selectTimeDiv").attr("hidden", "hidden");
                    } else {
                        $("input:radio[name='timeGroup']").removeAttr("checked");
                        $("#selectTimeDiv").removeAttr("hidden");
                        $("#datetimeComplete").attr("class", "incomplete");
                    }
                }

                /**
                 * Hides/Display section selection step and un-check all checked section radio buttons
                 * @param hideFlag
                 */
                function hideSectionStep(hideFlag) {
                    $("#sectionLabel").html("");
                    if (hideFlag) {
                        $("#selectSectionDiv").attr("hidden", "hidden");
                        $("#datetimeComplete").attr("class", "incomplete");
                    } else {
                        $("input:radio[name='sectionGroup']").removeAttr("checked");
                        $("#selectSectionDiv").removeAttr("hidden");
                        $("#datetimeComplete").attr("class", "complete");
                    }
                }

                /**
                 * Hides/Display ticket quantity step and set ticket quantity to 0
                 * @param hideFlag
                 */
                function hideTicketQtyStep(hideFlag) {
                    $("#ticketQtyLabel").html("");
                    if (hideFlag) {
                        $("#ticketQtyDiv").attr("hidden", "hidden");
                        $("#sectionComplete").attr("class", "incomplete");
                    } else {
                        $("#ticketQtySelector").val(0);
                        $("#ticketQtyDiv").removeAttr("hidden");
                        $("#sectionComplete").attr("class", "complete");
                    }
                }

                /**
                 * Hides and reset seat allocation step or Displays seat allocation step
                 * @param hideFlag
                 */
                function hideSeatAllocateStep(hideFlag) {
                    if (hideFlag) {
                        resetSeats();
                        $("#seatAllocateDiv").attr("hidden", "hidden");
                        $("input:submit").attr("hidden", "hidden");
                        $("#seatAllocComplete").attr("class", "incomplete");
                        $("#ticketQtyComplete").attr("class", "incomplete");
                    } else {
                        $("#seatAllocateDiv").removeAttr("hidden");
                        $("#ticketQtyComplete").attr("class", "complete");
                    }
                }

                /**
                 * Hides submit button
                 * @param hideFlag
                 */
                function hideSubmitButton(hideFlag) {
                    if (hideFlag) {
                        $("input:submit").attr("hidden", "hidden");
                        $("#submitComplete").attr("class", "incomplete");
                        $("#seatAllocComplete").attr("class", "incomplete");
                    } else {
                        $("input:submit").removeAttr("hidden");
                        $("#seatAllocComplete").attr("class", "complete");
                    }
                }

                /**
                 * Called when drop down list for date changes
                 * If selected date is valid, unhidden time step
                 * Else, reset all other values and hide all other steps
                 */
                $("#dateList").change(function () {
                    var selectedDate = $("#dateList").val();
                    if (selectedDate !== "Select Date") {
                        hideTimeStep(false);
                        $("#dateTimeLabel").html(selectedDate);
                    } else {
                        hideTimeStep(true);
                    }
                    hideSectionStep(true);
                    hideTicketQtyStep(true);
                    hideSeatAllocateStep(true);
                });

                /**
                 * Called when radio button for time changes
                 * Hides section selection step and hides ticket quantity and seat allocation steps
                 */
                $("input:radio[name='timeGroup']").change(function () {
                    hideSectionStep(false);
                    $("#dateTimeLabel").html($("#dateList").val() + " " + $("input:radio[name='timeGroup']:checked").val());
                    hideTicketQtyStep(true);
                    hideSeatAllocateStep(true);
                });

                /**
                 * Called when radio button for section changes
                 * Displays ticket quantity step and hides seat allocation step
                 */
                $("input:radio[name='sectionGroup']").change(function () {
                    hideTicketQtyStep(false);
                    $("#sectionLabel").html($("input:radio[name='sectionGroup']:checked").val());
                    hideSeatAllocateStep(true);
                });

                /**
                 * Called when ticket quantity selector changes
                 */
                $("#ticketQtySelector").change(function () {
                    var value, selectedLength, difference;
                    hideSeatAllocateStep(false);
                    value = parseInt($("#ticketQtySelector").val(), 10);
                    selectedLength = $("table.seatTable tbody tr td div.selected").length;
                    if (value < selectedLength) {
                        parseInt($("#ticketQtySelector").val(selectedLength));
                        alert("You have selected " + selectedLength + " seat(s). You cannot reduce the number of ticket quantity.");
                    } else if (value === 0) {
                        $("#ticketQtyLabel").html("");
                        hideSubmitButton(true);
                        hideSeatAllocateStep(true);
                    } else {
                        difference = $("#ticketQtySelector").val() - $("table.seatTable tbody tr td div.selected").length;
                        $("#ticketQtyLabel").html(difference + " unselected ticket(s)");
                        if (difference > 0) {
                            $("input:submit").attr("hidden", "hidden");
                            $("#seatAllocComplete").attr("class", "incomplete");
                        } else {
                            $("input:submit").removeAttr("hidden");
                            $("#seatAllocComplete").attr("class", "complete");
                        }
                    }
                });

                /**
                 * Form submission after all steps completed
                 */
                $("form").submit(function () {
                    var form, selectedSeats, seatFlag;
                    selectedSeats = $("table.seatTable tbody tr td div.selected");
                    seatFlag = true;
                    if (selectedSeats.length > 0) {
                        $.each(selectedSeats, function (index, target) {
                            var str, endOfRow, endOfCol, colValue, rowValue, previousCol, nextCol, middlePreviousCol, middleNextCol, previousDiv, previousTwoDiv, nextDiv, nextTwoDiv;
                            str = $(target).attr("id");
                            endOfRow = str.indexOf("row");
                            endOfCol = str.indexOf("col") + 3;
                            colValue = parseInt(str.substring(endOfCol, str.length), 10);
                            rowValue = parseInt(str.substring(0, endOfRow), 10);

                            previousCol = parseInt(colValue - 2, 10);
                            nextCol = parseInt(colValue + 2, 10);

                            middlePreviousCol = parseInt(colValue - 1, 10);
                            middleNextCol = parseInt(colValue + 1, 10);

                            previousDiv = $("#" + rowValue + "rowcol" + middlePreviousCol);
                            previousTwoDiv = $("#" + rowValue + "rowcol" + previousCol);

                            nextDiv = $("#" + rowValue + "rowcol" + middleNextCol);
                            nextTwoDiv = $("#" + rowValue + "rowcol" + nextCol);

                            if (previousDiv.hasClass("empty") && previousTwoDiv.hasClass("selected")) {
                                seatFlag = false;
                                return;
                            }

                            if (nextDiv.hasClass("empty") && nextTwoDiv.hasClass("selected")) {
                                seatFlag = false;
                                return;
                            }
                        });

                        if (seatFlag) {
                            $("form").attr("method", "post");
                        } else {
                            alert("You cannot select a seat which leaves a single seat gap.");
                            return false;
                        }
                    } else {
                        alert("You have not selected any seats.");
                        return false;
                    }
                });
            }
        );
    }
);
