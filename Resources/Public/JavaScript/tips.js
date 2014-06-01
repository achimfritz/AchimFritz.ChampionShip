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
					((ev.keyCode >= 48 && ev.keyCode <= 57) || ev.keyCode == 8 || ev.keyCode == 46 || ev.keyCode == 13)
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
									$('span', tip.container).remove();
									var result = tip.hostTip.val() + ':' + tip.guestTip.val();
									//tip.container.append($('<span />').text(result)).append($('<span />').addClass('icon-ok'))
									tip.container.append($('<span />').addClass('icon-ok'))
									if (response.messages.length) {
										var html = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>OK</strong>';
										for (var i = 0; i < response.messages.length; i++) {
											html += ' ' + response.messages[i].message;
										}
										html += '</div>';
										$('#flashMessageContainer').empty().append(html);
										//$('#flashMessageContainer').append(html);
									}
								} else {
									tip.container.removeClass('loading');
									//tip.container.append($('<span />').addClass('icon-exclamation-sign'));
									if (response.messages.length) {
										var html = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error</strong>';
										for (var i = 0; i < response.messages.length; i++) {
											html += ' ' + response.messages[i].message;
										}
										html += '</div>';
										tip.container.append(html);
									}
								}
							},
							'error': function() {
									tip.container.removeClass('loading');
									var html = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Fatal Error</strong></div>';
									tip.container.append(html);
									//tip.container.append($('<span />').addClass('icon-exclamation-sign'));
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
					((ev.keyCode >= 48 && ev.keyCode <= 57) || ev.keyCode == 8 || ev.keyCode == 46 || ev.keyCode == 13)
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
									$('span', tip.container).remove();
									var result = tip.hostTip.val() + ':' + tip.guestTip.val();
									tip.container.append($('<span />').addClass('icon-ok'))
									if (response.messages.length) {
										var html = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>OK</strong>';
										for (var i = 0; i < response.messages.length; i++) {
											html += ' ' + response.messages[i].message;
										}
										html += '</div>';
										$('#flashMessageContainer').empty().append(html);
										//$('#flashMessageContainer').append(html);
									}
									//tip.container.append($('<span />').text(result)).append($('<span />').addClass('icon-ok'))
								} else {
									tip.container.removeClass('loading');
									if (response.messages.length) {
										var html = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error</strong>';
										for (var i = 0; i < response.messages.length; i++) {
											html += ' ' + response.messages[i].message;
										}
										html += '</div>';
										tip.container.append(html);
									}
								}
							},
							'error': function() {
									tip.container.removeClass('loading');
									var html = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Fatal Error</strong></div>';
									tip.container.append(html);
							}
						});
				}
			});
		});
	});
}(jQuery));

