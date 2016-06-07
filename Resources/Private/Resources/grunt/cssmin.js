/*jslint node: true */
/*global module*/
'use strict';
module.exports = {
    target: {
        files: [{
            expand: true,
            cwd: '../../Public/Build',
            src: ['Libs.css', 'css/sprite.css'],
            dest: '../../Public/Build',
            ext: '.min.css'
        }]
    }
};