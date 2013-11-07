require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                $(function () {
                        var homeFeatured = $('.home-featured'),
                            width = homeFeatured.width(),
                            height = homeFeatured.height();

                        $('#slides').slidesjs(
                            {
                                navigation: {
                                  active: false
                                },
                                pagination: {
                                  active:false
                                },
                                play: {
                                    active: false,
                                    auto: true,
                                    pauseOnHover : true,
                                    restartDelay: 2500,
                                    interval: 5000,
                                    swap: false,
                                    effect: "slide"
                                }

                            }
                        );
                    }
                );

            }
        );
    }
);