/*jslint node: true */
/*global module*/
'use strict';
module.exports = {
    scripts: {
        files: [
            'JavaScript/**/*.js',
            'JavaScript/*.js'
        ],
        tasks: ['concat' ],
        options: {
            nospawn: true
        }
    },
    css: {
        files: ['Css/**/*.less'],
        tasks: ['less'],
        options: {
            nospawn: true
        }
    }
};
