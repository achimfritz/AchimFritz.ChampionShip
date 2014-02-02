(function ($) {
	$(function () {
		$('.datetimepicker').datetimepicker({
			timeformat: 'H:i',
			dateFormat: 'dd.mm.yy',
			stepMinute: 5
		});

		$('div.cs-col').equalHeight();

		$('ul.nav li a').on('shown', function() {
			//alert('foo');
			//$('div.cs-col').equalHeight();
		});

		// delete action
		$('form.deleteAction').each(function() {
			var form = $(this);
			$('input.btn', form).hide();
			$('span.icon-trash', form).bind('click', function(ev) {
				$('input.btn', form).trigger('click');
				//form.trigger('submit');
				//ev.preventDefault();
			});
		});
/*
		$('form.deleteAction span.icon-trash').bind('click', function(ev) {
			var form = $(this).parent('form');
			form.trigger('submit');
		});
		*/
	});
}(jQuery));

