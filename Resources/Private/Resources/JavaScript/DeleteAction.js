(function ($) {
    $(function () {
        // delete action
        $('span.deleteAction').bind('click', function () {
            var self = $(this);
            $("#dialog-confirm").dialog({
                resizable: false,
                height: 140,
                modal: true,
                title: 'Confirm Delete Action',
                buttons: {
                    "Yes": function () {
                        var form = self.next('form.deleteAction');
                        $('input.btn', form).trigger('click');
                    },
                    'No': function () {
                        $(this).dialog("close");
                    }
                }
            });
        });
    });
}(jQuery));

