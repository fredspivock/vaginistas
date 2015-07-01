var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass("app.scss");


    mix.styles([
    		'vendor/jquery-ui/jquery-ui.min.css',
    		'app.css'
    	], 'public/output/final.css', 'public/css');

    mix.scripts([
    		'jrac/jrac/jquery.jrac.js',
			'select2.min.js'

    	]);

});
