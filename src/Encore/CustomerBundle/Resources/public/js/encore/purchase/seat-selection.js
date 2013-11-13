require(['domReady'],
    function (domReady) {
        "use strict";
        domReady(
            function () {
                /**
                 * Set empty/selected to selected seat
                 * @param target
                 */
                function tickDiv(target) {
                    if (target.hasClass("empty")) {
                        target.attr("class", "selected");
                    } else {
                        target.attr("class", "empty");
                    }
                }

                /**
                 * Check if leave single gap space
                 * @param next1
                 * @param next2
                 * @returns {boolean}
                 */
                function checkNext(next1, next2) {
                    if (next1.hasClass("empty")) {
                        return !next2.hasClass("selected");
                    }
                    return true;
                }

                /**
                 * Called when a seat is selected
                 */
                $("table.seatTable tbody tr td").click(function (e) {
                    var target, str, endOfRow, endOfCol, colValue, rowValue, totalCol, previousCol, nextCol, middlePreviousCol, middleNextCol, previousDiv, previousTwoDiv, nextDiv, nextTwoDiv, difference, selectedSeats;
                    target = $(e.target);
                    str = target.attr("id");
                    endOfRow = str.indexOf("row") + 3;
                    endOfCol = str.indexOf("col") + 3;
                    colValue = parseInt(str.substring(endOfCol, str.length), 10);
                    rowValue = parseInt(str.substring(endOfRow, str.indexOf("col")), 10);

                    totalCol = parseInt($("table.seatTable tbody tr[id='row" + rowValue + "'] td").length, 10) - 1;
                    previousCol = parseInt(colValue - 2, 10);
                    nextCol = parseInt(colValue + 2, 10);

                    middlePreviousCol = parseInt(colValue - 1, 10);
                    middleNextCol = parseInt(colValue + 1, 10);

                    previousDiv = $("#row" + rowValue + "col" + middlePreviousCol);
                    previousTwoDiv = $("#row" + rowValue + "col" + previousCol);

                    nextDiv = $("#row" + rowValue + "col" + middleNextCol);
                    nextTwoDiv = $("#row" + rowValue + "col" + nextCol);

                    if (target.hasClass("empty")) {
                        difference = parseInt($("#ticketQtySelector").val() - $("table.seatTable tbody tr td.selected").length, 10);
                        if (difference !== 0) {
                            if (previousDiv.hasClass("empty")) {
                                if (previousTwoDiv.hasClass("selected")) {
                                    popupMessageError("You cannot select a seat which leaves a single seat gap.");
                                } else {
                                    if (checkNext(nextDiv, nextTwoDiv)) {
                                        tickDiv(target);
                                    } else {
                                        popupMessageError("You cannot select a seat which leaves a single seat gap.");
                                    }
                                }
                            } else {
                                if (checkNext(nextDiv, nextTwoDiv)) {
                                    tickDiv(target);
                                } else {
                                    popupMessageError("You cannot select a seat which leaves a single seat gap.");
                                }
                            }
                        } else {
                            popupMessageError("You have reached your max amount of selected tickets.");
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
                                popupMessageError("You cannot un-select a seat which leaves a single seat gap.");
                            }
                        } else if (nextDiv.hasClass("sold") || nextDiv.hasClass("locked")) {
                            if (totalCol === middlePreviousCol || middlePreviousCol < 0) {
                                target.attr("class", "empty");
                            } else if (previousDiv.hasClass("sold") || previousDiv.hasClass("locked")) {
                                target.attr("class", "empty");
                            } else {
                                popupMessageError("You cannot un-select a seat which leaves a single seat gap.");
                            }
                        } else {
                            popupMessageError("You cannot un-select a seat which leaves a single seat gap.");
                        }
                    } else if (target.hasClass("sold")) {
                        popupMessageError("You cannot select a seat which has already been sold.");
                    } else if (target.hasClass("locked")) {
                        popupMessageError("You cannot select a seat which is currently locked.");
                    }

                    selectedSeats = $("table.seatTable tbody tr td.selected");
                    selectedSeats.sort();
                    $("#seatAllocationInput").val("");
                    $("#seatAllocationLabel").val("");
                    $.each(selectedSeats, function (index, target) {
                        str = $(target).attr("id");
                        endOfRow = str.indexOf("row") + 3;
                        endOfCol = str.indexOf("col") + 3;
                        colValue = parseInt(str.substring(endOfCol, str.length), 10);
                        rowValue = parseInt(str.substring(endOfRow, str.indexOf("col")), 10);
                        $("#seatAllocationInput").val($("#seatAllocationInput").val() + "Row : " + rowValue + "; Seat No. : " + colValue + "\n");
                        $("#seatAllocationLabel").val($("#seatAllocationLabel").val() + str + "\n");
                    });

                    difference = $("#ticketQtySelector").val() - $("table.seatTable tbody tr td.selected").length;
                    $("#ticketQtyInput").val(difference + " unselected ticket(s)");
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
                    $("table.seatTable tbody tr td.selected").each(function () {
                        $(this).attr("class", "empty");
                    });
                    $("#seatAllocationInput").val("");
                    $("#seatAllocationLabel").val("");
                }

                /**
                 * Called when reset button for seat allocation is pressed
                 * Reset selected seats and change ticket quantity label
                 */
                $("#resetButton").click(function () {
                    resetSeats();
                    $("#ticketQtyInput").val(parseInt($("#ticketQtySelector").val(), 10) + " unselected ticket(s)");
                    $("input:submit").attr("hidden", "hidden");
                    $("#seatAllocComplete").attr("class", "incomplete");
                });

                /**
                 * Hides/Display ticket quantity step and set ticket quantity to 0
                 * @param hideFlag
                 */
                function hideTicketQtyStep(hideFlag) {
                    $("#ticketQtyInput").val("");
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
                 * Called when radio button for section changes
                 * Displays ticket quantity step and hides seat allocation step
                 */
                $("button.selectSection").click(function (e) {
                    hideTicketQtyStep(false);
                    $("#sectionLabel").html($(e.target).val());
                    hideSeatAllocateStep(true);
                });

                /**
                 * Called when ticket quantity selector changes
                 */
                $("#ticketQtySelector").change(function (e) {
                    var value, selectedLength, difference, qty;
                    hideSeatAllocateStep(false);

                    qty = $("#ticketQtySelector").val();
                    value = parseInt(qty, 10);
                    selectedLength = $("table.seatTable tbody tr td.selected").length;
                    difference = value - selectedLength;
                    if (value < selectedLength) {
                        difference = 0
                        $("#ticketQtySelector").val(selectedLength);
                        popupMessageError("You have selected " + selectedLength + " seat(s). You cannot reduce the number of ticket quantity.");
                    } else if (value === 0) {
                        hideSubmitButton(true);
                        hideSeatAllocateStep(true);
                    } else {
                        if (difference > 0) {
                            $("input:submit").attr("hidden", "hidden");
                            $("#seatAllocComplete").attr("class", "incomplete");
                        } else {
                            $("input:submit").removeAttr("hidden");
                            $("#seatAllocComplete").attr("class", "complete");
                        }
                    }
                    $("#ticketQtyInput").val(difference + " unselected ticket(s)");
                });

                /**
                 * Form submission after all steps completed
                 */
                $("form").submit(function () {
                    var form, selectedSeats, seatFlag;
                    selectedSeats = $("table.seatTable tbody tr td.selected");
                    seatFlag = true;
                    if (selectedSeats.length > 0) {
                        $.each(selectedSeats, function (index, target) {
                            var str, endOfRow, endOfCol, colValue, rowValue, previousCol, nextCol, middlePreviousCol, middleNextCol, previousDiv, previousTwoDiv, nextDiv, nextTwoDiv;
                            str = $(target).attr("id");
                            endOfRow = str.indexOf("row") + 3;
                            endOfCol = str.indexOf("col") + 3;
                            colValue = parseInt(str.substring(endOfCol, str.length), 10);
                            rowValue = parseInt(str.substring(endOfRow, str.indexOf("col")), 10);

                            previousCol = parseInt(colValue - 2, 10);
                            nextCol = parseInt(colValue + 2, 10);

                            middlePreviousCol = parseInt(colValue - 1, 10);
                            middleNextCol = parseInt(colValue + 1, 10);

                            previousDiv = $("#row" + rowValue + "col" + middlePreviousCol);
                            previousTwoDiv = $("#row" + rowValue + "col" + previousCol);

                            nextDiv = $("#row" + rowValue + "col" + middleNextCol);
                            nextTwoDiv = $("#row" + rowValue + "col" + nextCol);

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
                            popupMessageError("You cannot select a seat which leaves a single seat gap.");
                            return false;
                        }
                    } else {
                        popupMessageError("You have not selected any seats.");
                        return false;
                    }
                });

                /**
                 * Custom Popup Message
                 * @param message
                 */
                function popupMessageError(message) {
                    $("#errorMessage").html(message);
                    $("#errorMessageContainer").fadeIn("slow");
                }

                /**
                 * Closing Custom Popup Message box by clicking anywhere
                 */
                $("#errorMessageContainer").click(function () {
                    $("#errorMessageContainer").fadeOut("fast");
                });
            }
        );
    }
);
