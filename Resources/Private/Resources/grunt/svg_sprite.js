/* global module,require */

(function () {
    'use strict';
    module.exports = {
        svg_sprite: {
            files: {ax: ['bower_components/flag-icon-css/flags/**/*.svg']},
            x: {

                // Target basics
                expand: true,
                cwd: 'bower_components/flag-icon-css/flags',
                src: ['bower_components/flag-icon-css/flags/**/*.svg'],
                dest: '../../Public/Build/',

                // Target options
                options: {
                    mode: {
                        css: {
                            render: {
                                css: true
                            }
                        }
                    }
                }
            }
        }
    };
}
());
