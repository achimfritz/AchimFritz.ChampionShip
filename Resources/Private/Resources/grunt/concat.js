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
    csslibs: {
        src: [
            'bower_components/jquery-ui/themes/base/jquery-ui.css',
            'bower_components/bootstrap/dist/css/bootstrap.css',
        ],
        dest: '../../Public/Build/Libs.css'
    }
};
