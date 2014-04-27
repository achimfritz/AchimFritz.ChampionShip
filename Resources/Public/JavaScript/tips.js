(function ($) {
	$(function () {
		$('.tip').each(function() {


			//create tip
			var hostTip = $('.hostTip', this);
			var guestTip = $('.guestTip', this);
			var tipId = $('.tipId', this);
			var tip = {
				'hostTip' : hostTip,
				'guestTip' : guestTip,
				'tipId': tipId,
				'container': $(this)
			};
			// bind tip

			// bind homeTip
			tip.hostTip.bind('keyup', function(ev) {
				// compile tip
				var cTip = {
					'tip': {
						'result': {
							'hostTeamGoals': tip.hostTip.val(),
							'guestTeamGoals': tip.guestTip.val()
						},
						'__identity': tip.tipId.val()
					}
				};

				// valide
				if(
					ev.keyCode >= 48
					&& ev.keyCode <= 57
					&& Math.floor(cTip.tip.result.hostTeamGoals) == cTip.tip.result.hostTeamGoals 
					&& $.isNumeric(cTip.tip.result.hostTeamGoals)
					&& Math.floor(cTip.tip.result.guestTeamGoals) == cTip.tip.result.guestTeamGoals 
					&& $.isNumeric(cTip.tip.result.guestTeamGoals)
					) {

					tip.container.addClass('loading');

					$.ajax({
							'type': 'PUT',
							'url': '/achimfritz.championship/usertip/index',
							'data': cTip,
							'dataType': 'json',
							'success': function (response) {
								if (response.success == true) {
									tip.container.removeClass('loading');
									tip.container.append($('<span />').addClass('icon-ok'));
								} else {
									tip.container.removeClass('loading');
									tip.container.append($('<span />').addClass('icon-exclamation-sign'));
								}
							},
							'error': function() {
									tip.container.removeClass('loading');
									tip.container.append($('<span />').addClass('icon-exclamation-sign'));
							}
						});
				}
			});
			// bind guestTip
			tip.guestTip.bind('keyup', function(ev) {
				// compile tip
				var cTip = {
					'tip': {
						'result': {
							'hostTeamGoals': tip.hostTip.val(),
							'guestTeamGoals': tip.guestTip.val()
						},
						'__identity': tip.tipId.val()
					}
				};

				// valide
				if(
					ev.keyCode >= 48
					&& ev.keyCode <= 57
					&& Math.floor(cTip.tip.result.hostTeamGoals) == cTip.tip.result.hostTeamGoals 
					&& $.isNumeric(cTip.tip.result.hostTeamGoals)
					&& Math.floor(cTip.tip.result.guestTeamGoals) == cTip.tip.result.guestTeamGoals 
					&& $.isNumeric(cTip.tip.result.guestTeamGoals)
					) {

					tip.container.addClass('loading');

					$.ajax({
							'type': 'PUT',
							'url': '/achimfritz.championship/usertip/index',
							'data': cTip,
							'dataType': 'json',
							'success': function (response) {
								if (response.success == true) {
									tip.container.removeClass('loading');
									tip.container.append($('<span />').addClass('icon-ok'));
								} else {
									tip.container.removeClass('loading');
									tip.container.append($('<span />').addClass('icon-exclamation-sign'));
								}
							},
							'error': function() {
									tip.container.removeClass('loading');
									tip.container.append($('<span />').addClass('icon-exclamation-sign'));
							}
						});
				}
			});
		});
	});
}(jQuery));

