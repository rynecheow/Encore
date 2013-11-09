require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                $(function () {
                        var view = $(".view-profile");
                        var edit = $(".edit-profile");
                        var history = $(".history-profile");

                        view.click(function () {
                            view.attr("class", "view-profile view-selected div-logo");
                            edit.attr("class", "edit-profile div-logo");
                            history.attr("class", "history-profile div-logo");
                        });

                        edit.click(function () {
                            view.attr("class", "view-profile div-logo");
                            edit.attr("class", "edit-profile edit-selected div-logo");
                            history.attr("class", "history-profile div-logo");
                        });
                        $('#view').click(function (e) {
                            e.preventDefault();


                            $(this).tab('show');
                        })
                        $('#edit').click(function (e) {
                            e.preventDefault();


                            $(this).tab('show');
                        })
                    }
                );

            }
        );
    }
);