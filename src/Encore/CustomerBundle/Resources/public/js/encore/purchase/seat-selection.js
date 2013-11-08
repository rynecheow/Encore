///*global window */
///*global $ */
///*global alert */
///*global require */
//
//require(['domReady'],
//    function (domReady) {
//        "use strict";
//        domReady(
//            function () {
//                window.prevSelectedSeats = [];
//                window.prevSelectedSec = -1;
//                window.prevSelectedRow = -1;
//
//                function loadSection() {
//                    var sectionArrays = [
//                        {row: 10, col: 5},
//                        {row: 8, col: 8},
//                        {row: 6, col: 10}
//                    ];
//
//                    return sectionArrays;
//                }
//
//                function addSection(sectionIndex, section) {
//                    /*jslint browser:true */
//                    var body, tableTag, tableBody, row, col, currRow, tableRow, currCol, tableCol, tableDiv;
//                    body = document.getElementsByTagName("body")[0];
//                    tableTag = document.createElement("table");
//                    tableTag.setAttribute("class", "section");
//                    tableBody = document.createElement("tbody");
//                    row = parseInt(section.row, 10);
//                    col = parseInt(section.col, 10);
//
//                    currRow = 0;
//                    while (currRow < row) {
//
//                        tableRow = document.createElement("tr");
//
//                        currCol = 0;
//                        while (currCol < col) {
//                            tableCol = document.createElement("td");
//                            tableDiv = document.createElement("div");
//
//                            tableDiv.setAttribute("data-row", String(currRow));
//                            tableDiv.setAttribute("data-col", String(currCol));
//                            tableDiv.setAttribute("data-sec", String(sectionIndex));
//                            tableDiv.setAttribute("class", "empty");
//                            tableCol.appendChild(tableDiv);
//                            tableRow.appendChild(tableCol);
//
//                            currCol = currCol + 1;
//                        }
//
//                        tableBody.appendChild(tableRow);
//                        currRow = currRow + 1;
//                    }
//
//                    tableTag.appendChild(tableBody);
//                    body.appendChild(tableTag);
//                }
//
//                $(document).click(function (e) {
//                    var selectedElement, col, row, table, mostLeftSeat, mostRightSeat, selectedSec, selectedRow, selectedCol, selectedFlag, index;
//
//                    if (!e) {
//                        e = window.event;
//                    }
//
//                    if (e.target) {
//                        selectedElement = e.target;
//                    } else if (e.srcElement) {
//                        selectedElement = e.srcElement;
//                    }
//
//                    if (selectedElement.tagName === "DIV") {
//                        col = selectedElement.parentNode;
//
//                        if (col.tagName === "TD") {
//                            row = col.parentNode;
//
//                            if (row.tagName === "TR") {
//                                table = row.parentNode.parentNode;
//
//                                if (table.tagName === "TABLE" && table.classList.contains("section")) {
//
//                                    window.prevSelectedSeats.sort();
//                                    mostLeftSeat = parseInt(window.prevSelectedSeats[0], 10);
//                                    mostRightSeat = parseInt(window.prevSelectedSeats[window.prevSelectedSeats.length - 1], 10);
//                                    selectedSec = parseInt(selectedElement.getAttribute("data-sec"), 10);
//                                    selectedRow = parseInt(selectedElement.getAttribute(("data-row")), 10);
//                                    selectedCol = parseInt(selectedElement.getAttribute("data-col"), 10);
//                                    selectedFlag = true;
//
//                                    if (selectedElement.classList.contains("selected")) {
//
//                                        if (selectedCol === mostLeftSeat || selectedCol === mostRightSeat) {
//                                            selectedFlag = true;
//                                        } else {
//                                            selectedFlag = false;
//                                        }
//
//
//                                        if (selectedFlag) {
//                                            selectedElement.setAttribute("class", "empty");
//                                            index = parseInt(window.prevSelectedSeats.indexOf(parseInt(selectedElement.getAttribute("data-col"), 10)), 10);
//
//                                            if (index !== -1) {
//                                                window.prevSelectedSeats.splice(index, 1);
//                                            }
//                                        } else {
//                                            alert("Cannot unselect seats in the middle");
//                                        }
//                                    } else {
//
//                                        if (window.prevSelectedSeats.length !== 0) {
//                                            if (selectedSec === window.prevSelectedSec) {
//                                                if (selectedRow === window.prevSelectedRow) {
//                                                    if (selectedCol !== mostLeftSeat - 1 && selectedCol !== mostRightSeat + 1) {
//                                                        selectedFlag = false;
//                                                    }
//                                                } else {
//                                                    selectedFlag = false;
//                                                }
//                                            } else {
//                                                selectedFlag = false;
//                                            }
//                                        }
//
//                                        if (selectedFlag) {
//                                            selectedElement.setAttribute("class", "selected");
//                                            window.prevSelectedSeats.push(selectedCol);
//                                            window.prevSelectedSec = selectedSec;
//                                            window.prevSelectedRow = selectedRow;
//
//                                        } else {
//                                            alert("Must select adjacent seats");
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//                    );
//
//
//                $("#resetButton").click(function (e) {
//                    window.prevSelectedSeats = [];
//                    window.prevSelectedRow = -1;
//                    window.prevSelectedSec = -1;
//
//                    $("div.selected").each(function () {
//                        this.setAttribute("class", "empty");
//                    });
//                });
//
//                $(function () {
//                    var sections = loadSection();
//                    $.each(sections, addSection);
//                });
//            }
//        );
//    }
//    );

require(['domReady'],
    function (domReady) {
        "use strict";
        domReady(
            function () {

                var seatsMatrix = {
                    col: 10,
                    row: 5
                };

                function detectEmptySeat(e) {

                    var str = $(e.target).attr("id");
                    var target = $(e.target);
                    var endOfRow = str.indexOf("row");
                    var endOfCol = str.indexOf("col") + 3;
                    var colValue = parseInt(str.substring(endOfCol, str.length), 10);
                    var rowValue = parseInt(str.substring(0, endOfRow), 10);
                    console.log("row is " + rowValue);
                    console.log("col is " + colValue);

                    var totalCol = parseInt(seatsMatrix.col, 10);
                    var previousCol = parseInt(colValue - 2, 10);
                    var nextCol = parseInt(colValue + 2, 10);

                    var middlePreviousCol = parseInt(colValue - 1, 10);
                    var middleNextCol = parseInt(colValue + 1, 10);

                    console.log("prev col  is " + previousCol);
                    console.log("next col is " + nextCol);

                    var previousDiv = $("#" + rowValue + "rowcol" + middlePreviousCol);
                    var previousTwoDiv = $("#" + rowValue + "rowcol" + previousCol);

                    var nextDiv = $("#" + rowValue + "rowcol" + middleNextCol);
                    var nextTwoDiv = $("#" + rowValue + "rowcol" + nextCol);

                    if (target.hasClass("empty")) {
                        if (previousDiv.hasClass("empty")) {

                            if (previousTwoDiv.hasClass("selected")) {
                                alert("cannot!");
                            }
                            else {
                                if (checkNext(nextDiv, nextTwoDiv)) {
                                    tickDiv(e);
                                }
                                else {
                                    alert("error");
                                }

                            }
                        }
                        else {
                            if (checkNext(nextDiv, nextTwoDiv)) {
                                tickDiv(e);
                            }
                            else {
                                alert("error");
                            }
                        }
                    }
                    else {
                        target.attr("class", "empty");
                    }


                }

                function tickDiv(e) {
                    if ($(e.target).hasClass("empty")) {
                        $(e.target).attr("class", "selected");
                    }
                    else {
                        $(e.target).attr("class", "empty");
                    }
                }

                function checkNext(next1, next2) {
                    if (next1.hasClass("empty")) {
                        return !next2.hasClass("selected");
                    }
                    else {
                        return true;
                    }
                }

                function initSeatsPlan(matrix) {
                    console.log(matrix.row);
                    var i, j;
                    var parent = $("body");
                    var seatTable = $('<table/>', {
                        "class": "seatTable",
                        "id": "section1"
                    }).appendTo(parent);

                    for (i = 0; i < matrix.row; i++) {
                        var seatRow = $('<tr/>', {
                            "id": "row" + i
                        }).appendTo(seatTable);

                        for (j = 0; j < matrix.col; j++) {
                            var seatColumn = $('<td/>').width(30).height(30).appendTo(seatRow);

                            var emptyDiv = $('<div/>', {
                                "id": i + "row" + "col" + j,
                                "class": "empty",
                                width: 20,
                                height: 20,
                                "position": "absolute"
                            }).on("click", detectEmptySeat).appendTo(seatColumn);
                        }
                    }
                }


                $(function () {
                    initSeatsPlan(seatsMatrix);
                });
            }

        )
        ;
    }
);