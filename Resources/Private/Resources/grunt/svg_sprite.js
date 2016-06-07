/* global module,require */

(function () {
    'use strict';
    module.exports = {
            target: {

                expand: true,
                cwd: 'bower_components/flag-icon-css/flags/4x3',
                src: ['de.svg'],
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
    };
}
());
//src: ['de.svg', 'es.svg', 'fr.svg'],
