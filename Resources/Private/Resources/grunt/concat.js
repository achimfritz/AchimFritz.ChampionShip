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
            'bower_components/php-date-formatter/js/php-date-formatter.js',
            'bower_components/datetimepicker/jquery.datetimepicker.js',
            'bower_components/bootstrap/js/tab.js',
            'bower_components/bootstrap/js/dropdown.js',
            'bower_components/bootstrap/js/collapse.js'
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
            'bower_components/flag-icon-css/css/flag-icon.css',
            'bower_components/datetimepicker/jquery.datetimepicker.css'
        ],
        dest: '../../Public/Build/Libs.css'
    },
    cssapp: {
        src: [
            'Css/*.css'
        ],
        dest: '../../Public/Build/App.css'
    }
};
