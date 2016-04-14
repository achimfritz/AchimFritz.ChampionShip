/*jslint node: true */
/*global module*/
'use strict';
module.exports = {
    scripts: {
        files: [
            'JavaScript/**/*.js',
            'Css/**/*.css'
        ],
        tasks: ['concat' ],
        options: {
            nospawn: true
        }
    }
};
