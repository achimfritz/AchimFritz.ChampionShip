/*jslint node: true */
/*global module*/
'use strict';
module.exports = {
    app: {
        files: {
            '../../Public/Build/App.min.js': ['../../Public/Build/App.js']
        },
        options: {
            mangle: true
        }
    },
    libs: {
        files: {
            '../../Public/Build/Libs.min.js': ['../../Public/Build/Libs.js']
        },
        options: {
            mangle: true
        }
    }
};