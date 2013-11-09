require(['domReady'],
    function (domReady) {
        "use strict";
        domReady(
            function () {

                var seatsMatrix = {
                    col: 10,
                    row: 5
                };

                function tickDiv(target) {
                    if (target.hasClass("empty")) {
                        target.attr("class", "selected");
                    } else {
                    }
                }

                function checkNext(next1, next2) {
                    if (next1.hasClass("empty")) {
                        return !next2.hasClass("selected");
                    }
                    return true;
                }

                function checkSeatPlan(target) {
                    var str, endOfRow, endOfCol, colValue, rowValue, totalCol, previousCol, nextCol, middlePreviousCol, middleNextCol, previousDiv, previousTwoDiv, nextDiv, nextTwoDiv;
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
                                if (totalCol === middlePreviousCol) {
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
                }

                $(document).click(function (e) {
                    var target, str, endOfRow, endOfCol, colValue, rowValue, totalCol, previousCol, nextCol, middlePreviousCol, middleNextCol, previousDiv, previousTwoDiv, nextDiv, nextTwoDiv;
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

                    if ($("table.seatTable tbody tr td div.selected").length > 0) {
                        $("input[type='submit']").removeAttr("disabled");
                        $("input#resetButton").removeAttr("disabled");
                    } else {
                        $("input[type='submit']").attr("disabled", "disabled");
                        $("input#resetButton").attr("disabled", "disabled");
                    }

                });

                $("#resetButton").click(function () {
                    $("table.seatTable tbody tr td div.selected").each(function () {
                        $(this).attr("class", "empty");
                    });
                    $("input[type='submit']").attr("disabled", "disabled");
                    $("input#resetButton").attr("disabled", "disabled");
                });

                $("form").submit(function (e) {
                    var form, selectedSeats, seatFlag;
                    form = $("form");
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
                            form.attr("method", "post");
                        } else {
                            alert("You cannot select a seat which leaves a single seat gap.");
                            return false;
                        }
                    }
                });
            }

        );
    }
    );