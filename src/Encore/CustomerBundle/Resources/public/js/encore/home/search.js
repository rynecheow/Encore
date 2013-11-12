require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                "use strict";
                var searchbox = $('#search');
                var hauntedText = String(searchbox.data("value"));
                var haunt = ghostwriter.haunt(
                    {
                        input: '#search',
                        manuscript: hauntedText,
                        interval: 100
                    }
                );

                haunt.start();

                $(document).on('click keydown', function(e) {
                    !e.ghostwriter && haunt.pause();
                });

                searchbox.on('focus', function (e) {
                    var $form = $(".home-search-wrapper").find('.search-form');
                    if (!($form.hasClass("user-focused"))) {
                        $form.addClass("user-focused");
                        var button = $form.find("#search-submit");
                        button.removeAttr('disabled');
                    }

                });
                searchbox.on('blur', function (e) {
                    var $form = $(".home-search-wrapper").find('.search-form');
                    $form.removeClass("user-focused");
                    if ($form.hasClass("user-focused")) {
                        $form.removeClass("user-focused");
                        var button = $form.find("#search-submit");
                        button.attr("disabled", "true");
                    }
                });
            }
        );
    }
);