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

                $(document).click(function (e) {
                    var target, str, endOfRow, endOfCol, colValue, rowValue, totalCol, previousCol, nextCol, middlePreviousCol, middleNextCol, previousDiv, previousTwoDiv, nextDiv, nextTwoDiv, difference, selectedSeats, rowLabel;
                    target = $(e.target);
                    if (target.is("table.seatTable tbody tr td div")) {
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
                                alert("You have reached your max amount of seleced tickets.");
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
                        }
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
                });

                $("#resetButton").click(function () {
                    $("table.seatTable tbody tr td div.selected").each(function () {
                        $(this).attr("class", "empty");
                    });
                });

                $('#datepicker-select').datepicker().on('changeDate', function () {
                    $("#dateTimeLabel").html($("#datepicker-select").val());
                });

                $("#ticketQtySelector").change(function () {
                    $("#ticketQtyLabel").html($("#ticketQtySelector").val() + " ticket(s)");
                });

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
