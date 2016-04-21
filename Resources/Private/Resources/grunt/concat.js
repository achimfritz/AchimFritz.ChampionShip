/*jslint node: true */
/*global module*/
'use strict';
module.exports = {
    options: {
        separator: '\r\n'
    },
    libs: {
        src: [
            'bower_components/jquery/dist/jquery.js',
            'bower_components/jquery-ui/jquery-ui.js',
            'bower_components/jquery-mousewheel/jquery.mousewheel.js',
            'bower_components/php-date-formatter/js/php-date-formatter.js',
            'bower_components/datetimepicker/jquery.datetimepicker.js',
            'bower_components/bootstrap/js/tooltip.js',
            'bower_components/bootstrap/js/modal.js',
            'bower_components/bootstrap/js/tab.js',
            'bower_components/bootstrap/js/dropdown.js',
            'bower_components/bootstrap/js/collapse.js',
            'bower_components/angular/angular.js',
            'bower_components/angular-route/angular-route.js'
        ],
        dest: '../../Public/Build/Libs.js'
    },
    app: {
        src: [
            'JavaScript/*.js'
        ],
        dest: '../../Public/Build/App.js'
    },
    csslibs: {
        src: [
            'bower_components/jquery-ui/themes/base/jquery-ui.css',
            'bower_components/bootstrap/dist/css/bootstrap.css',
            'bower_components/flag-icon-css/css/flag-icon.css',
            'bower_components/datetimepicker/jquery.datetimepicker.css'
        ],
        dest: '../../Public/Build/Libs.css'
    }
};
