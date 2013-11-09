require(['domReady'],
    function (domReady) {
        "use strict";
        domReady(
            function () {
                var seatsMatrix = {
                    col: 50,
                    row: 20
                };

                initSeatsPlan(seatsMatrix);

                function initSeatsPlan(matrix) {
                    var i, j, parent, seatTable, seatRow, seatColumn;
                    parent = $("body");
                    seatTable = $(document.createElement('table')).attr({
                        "class": "seatTable",
                        "id": "section1"
                    }).appendTo(parent);

                    for (i = 0; i < matrix.row; i = i + 1) {
                        seatRow = $(document.createElement('tr')).attr({
                            "id": "row" + i
                        }).appendTo(seatTable);

                        for (j = 0; j < matrix.col; j = j + 1) {
                            seatColumn = $(document.createElement('td')).appendTo(seatRow);

                            $(document.createElement('div')).attr({
                                "id": i + "row" + "col" + j,
                                "class": "empty"
                            }).on("click", detectEmptySeat).appendTo(seatColumn);
                        }
                    }
                }

                function tickDiv(e) {
                    if ($(e.target).hasClass("empty")) {
                        $(e.target).attr("class", "selected");
                    } else {
                        $(e.target).attr("class", "empty");
                    }
                }

                function checkNext(next1, next2) {
                    if (next1.hasClass("empty")) {
                        return !next2.hasClass("selected");
                    }
                    return true;
                }

                function detectEmptySeat(e) {
                    var str, target, endOfRow, endOfCol, colValue, rowValue, totalCol, previousCol, nextCol, middlePreviousCol, middleNextCol, previousDiv, previousTwoDiv, nextDiv, nextTwoDiv;
                    str = $(e.target).attr("id");
                    target = $(e.target);
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
                                    tickDiv(e);
                                } else {
                                    alert("You cannot select a seat which leaves a single seat gap.");
                                }

                            }
                        } else {
                            if (checkNext(nextDiv, nextTwoDiv)) {
                                tickDiv(e);
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


                $("#resetButton").click(function () {
                    $("table.seatTable tbody tr td div.selected").each(function () {
                        $(this).attr("class", "empty");
                    });
                });
            }

        );
    }
);