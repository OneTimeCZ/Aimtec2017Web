process.env.DISABLE_NOTIFIER = true;

require('laravel-elixir-bowerbundle');

var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.bower();
    mix.sass('app.scss');
    mix.coffee('app.coffee');
    mix.copy('bower_components/bootstrap/fonts', 'public/fonts');
    mix.copy('bower_components/components-font-awesome/fonts/', 'public/bundles');
    mix.browserSync({
        proxy: "laravel.loc"
    });
});
