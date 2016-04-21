/*jslint browser:true, nomen: true*/
/*global jQuery, console/*/

(function ($) {
    'use strict';

    $(function () {
        $('.datetimepicker').datetimepicker({
            formatTime: 'H:i',
            formatDate: 'd.m.Y',
            format: 'd.m.Y H:i',
            step: 5
        });
    });
}(jQuery));