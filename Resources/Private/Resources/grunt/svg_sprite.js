/* global module,require */

(function () {
    'use strict';
    module.exports = {
        svg_sprite: {
            options: {
            },
            flags: {
                src: ['bower_components/flag-icon-css/flags/**/*.svg'],
                dest: '../../Public/Build/',
                options: {
                    // Target-specific options
                }
            }
        }
    };
}());