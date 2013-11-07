require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                /* Global Variable */
                window.prevSelectedSeat = null;

                $(function () {
                    var sections = loadSection();
                    $.each(sections, addSection);
                });

                function addSection(sectionIndex, section) {
                    var body = document.getElementsByTagName("body")[0];
                    var table = document.createElement("table");
                    table.setAttribute("class", "section");
                    var tableBody = document.createElement("tbody");
                    var row = section["row"];
                    var col = section["col"];

                    for (var currRow = 0; currRow < row; currRow++) {
                        var tableRow = document.createElement("tr");

                        for (var currCol = 0; currCol < col; currCol++) {
                            var tableCol = document.createElement("td");
                            var tableDiv = document.createElement("div");
                            tableDiv.setAttribute("data-row", currRow + '');
                            tableDiv.setAttribute("data-col", currCol + '');
                            tableDiv.setAttribute("data-sec", sectionIndex + '');
                            tableDiv.setAttribute("class", "empty");
                            tableCol.appendChild(tableDiv);
                            tableRow.appendChild(tableCol);
                        }

                        tableBody.appendChild(tableRow);
                    }

                    table.appendChild(tableBody);
                    body.appendChild(table);
                }

                function loadSection() {
                    var sectionArrays = [
                        {row: 10, col: 5},
                        {row: 8, col: 8},
                        {row: 6, col: 10}
                    ];

                    return sectionArrays;
                }

                $(document).click(function (e) {
                        var selectedElement;
                        if (!e) {
                            var e = window.event;
                        }

                        if (e.target) {
                            selectedElement = e.target;
                        }
                        else if (e.srcElement) {
                            selectedElement = e.srcElement;
                        }

                        if (selectedElement.tagName == "DIV") {
                            var col = selectedElement.parentNode;

                            if (col.tagName == "TD") {
                                var row = col.parentNode;

                                if (row.tagName == "TR") {
                                    var table = row.parentNode.parentNode;
                                    if (table.tagName == "TABLE" && table.classList.contains("section")) {

                                        console.log(prevSelectedSeat);

                                        if (selectedElement.classList.contains("selected")) {
                                            selectedElement.setAttribute("class", "empty");
                                            window.prevSelectedSeat = selectedElement;
                                        }
                                        else {

                                            var selectedFlag = true;


                                            if(selectedFlag)
                                            {
                                                selectedElement.setAttribute("class", "selected");
                                                window.prevSelectedSeat = selectedElement;
                                            }
                                            else
                                            {
                                                alert("Must select adjacent seats");
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                );
            }
        );
    }
);