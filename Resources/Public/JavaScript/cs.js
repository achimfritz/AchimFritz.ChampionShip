(function ($) {
	$(function () {
		$('.datetimepicker').datetimepicker({
			timeformat: 'H:i',
			dateFormat: 'dd.mm.yy',
			stepMinute: 5
		});

		$('div.cs-col').equalHeight();
	});
}(jQuery));

