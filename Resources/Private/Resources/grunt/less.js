/*jslint node: true */
/*global module*/
'use strict';
module.exports = {
    development: {
        options: {
            relativeUrls: true
        },
        files: {
            '../../Public/Build/Main.css': 'Css/Main.less'
        }
    },
    production: {
        options: {
            compress: true,
            yuicompress: true,
            optimization: 2,
            relativeUrls: true,
            cleancss: true
        },
        files: {
            '../../Public/Build/Main.min.css': 'Css/Main.less'
        }
    }
};