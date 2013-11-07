require(['domReady'],
    function (domReady) {
        domReady(
            function () {
                $(function () {
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
                                    interval: 6000,
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