(function ($) {
    $(function () {
        $('.tip').each(function () {


            //create tip
            var hostTip = $('.hostTip', this);
            var guestTip = $('.guestTip', this);
            var tipId = $('.tipId', this);
            var submit = $('button', this);
            var inputs = $('input', this);
            var tip = {
                hostTip: hostTip,
                guestTip: guestTip,
                tipId: tipId,
                submit: submit,
                inputs: inputs,
                container: $(this)
            };

            var validate = function () {
                if (Math.floor(tip.hostTip.val()) == tip.hostTip.val()
                    && $.isNumeric(tip.hostTip.val())
                    && Math.floor(tip.guestTip.val()) == tip.guestTip.val()
                    && $.isNumeric(tip.guestTip.val()))
                {
                    tip.submit.removeAttr('disabled');
                    return true;
                } else {
                    tip.submit.attr('disabled', 'disabled');
                    return false;
                }

            };

            var update = function () {
                tip.container.addClass('loading');

                var data = {
                    tip: {
                        result: {
                            hostTeamGoals: tip.hostTip.val(),
                            guestTeamGoals: tip.guestTip.val()
                        },
                        __identity: tip.tipId.val()
                    }
                };


                $.ajax({
                    type: 'PUT',
                    url: '/achimfritz.championship/tip/tip/index',
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        tip.container.removeClass('loading');
                        $('div.alert', tip.container).remove();
                        if (response.flashMessages.length) {
                            var html = '<span class="alert-inline alert alert-success"><strong>OK</strong></span>';
                            tip.container.append(html);
                        }
                    },
                    error: function () {
                        tip.container.removeClass('loading');
                        $('div.alert', tip.container).remove();
                        var html = '<span class="alert-inline alert alert-danger"><strong>ERROR</strong></span>';
                        tip.container.append(html);
                    }
                });
            };

            validate();

            tip.submit.bind('click', function(ev) {
                if (validate() === true) {
                    update();
                }
            })

            tip.inputs.bind('change', function (ev){
                validate();
            });

        });
    });
}(jQuery));

