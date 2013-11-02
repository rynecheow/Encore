require.config({
    baseUrl: jsUrl,
    paths: {
        domReady: 'libs/require/domReady',
        jquery: 'libs/jquery.min',
        'jquery-ui': 'libs/jquery-ui',
        'backbone.d': 'libs/backbone-min',
        parsley: 'libs/parsley.min',
        'bootstrap': 'libs/bootstrap.min'
    },
    urlArgs: 'bust=' + (new Date()).getTime()
});

require(['encore/common']);