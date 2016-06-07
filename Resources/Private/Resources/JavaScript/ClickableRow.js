/*jslint browser:true, nomen: true*/
/*global jQuery, console/*/

(function ($) {
    'use strict';

    $(function () {
        $('.table tr[data-href]').each(function(){
            $(this).css('cursor','pointer').hover(
                function(){
                    $(this).addClass('active');
                },
                function(){
                    $(this).removeClass('active');
                }).click( function(){
                    document.location = $(this).attr('data-href');
                }
            );
        });
    });
}(jQuery));