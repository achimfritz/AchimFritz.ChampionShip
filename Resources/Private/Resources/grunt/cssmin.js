/*jslint node: true */
/*global module*/
'use strict';
module.exports = {
    target: {
        files: [{
            expand: true,
            cwd: '../../Public/Build',
            src: ['Libs.css', '!*.min.css'],
            dest: 'r../../Public/Build',
            ext: '.min.css'
        }]
    }
};