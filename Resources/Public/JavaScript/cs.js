(function ($) {
	$(function () {
		// datepicker
		$('.datetimepicker').datetimepicker({
			timeformat: 'H:i',
			dateFormat: 'dd.mm.yy',
			stepMinute: 5
		});

		// equal height
		$('div.cs-col').equalHeight();



		// delete action
		$('span.deleteAction').bind('click', function() {
			var self = $(this);
			$( "#dialog-confirm" ).dialog({
				resizable: false,
				height:140,
				modal: true,
				title: 'Confirm Delete Action',
				buttons: {
					"Yes": function() {
						var form = self.next('form.deleteAction');
						$('input.btn', form).trigger('click');
					},
					'No': function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});

		// data tables
		var oTable = $('.dataTable').dataTable({
          "bJQueryUI": true,
          "aLengthMenu": [ 20, 50, 200 ],
          'aaSorting': [ [0, 'asc'] ],
          'iDisplayLength': 20
     });

	  // fullscreen
	  $('#fullscreen').bind('click', function(ev) {
			if ($(this).hasClass('full')) {
				$('.cs-main').addClass('span8');
				$('.cs-main').removeClass('span12');
				$('.cs-right').show();
				$('.cs-menu').show();
				$(this).removeClass('full');
			} else {
				$('.cs-main').removeClass('span8');
				$('.cs-main').addClass('span12');
				$('.cs-right').hide();
				$('.cs-menu').hide();
				$(this).addClass('full');
			}
	  });
	});
}(jQuery));

