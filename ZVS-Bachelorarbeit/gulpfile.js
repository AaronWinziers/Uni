var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.less('sb-admin-2.less');
    mix.webpack('sb-admin-2.js');

    mix.copy('vendor/bootstrap', 'public/vendor/bootstrap');
    mix.copy('vendor/metisMenu', 'public/vendor/metisMenu');
    mix.copy('vendor/morrisjs', 'public/vendor/morrisjs');
    mix.copy('vendor/font-awesome', 'public/vendor/font-awesome');
    mix.copy('vendor/jquery', 'public/vendor/jquery');
    mix.copy('vendor/raphael', 'public/vendor/raphael');
    mix.copy('vendor/datatables', 'public/vendor/datatables');
    mix.copy('vendor/datatables-responsive', 'public/vendor/datatables-responsive');
    mix.copy('vendor/datatables-plugins', 'public/vendor/datatables-plugins');

});