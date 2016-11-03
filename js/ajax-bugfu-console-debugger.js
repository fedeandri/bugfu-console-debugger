(function($) {
	
	var bugfu_previous_log;
	var bugfu_read_log_interval;

	$( document ).ready( function() {

		bugfu_read_log_interval = setInterval( bugfu_read_log, 300 );
	});

	function bugfu_read_log() {

		var data = {
			action: 'bugfu_ajax_read_debug_log'
		}

		$.ajax({
			url: bugfu_console_debugger_ajax_params.ajaxurl,
			type: 'get',
			data: data,
			success: function( response ) {

				var preheader = "\n";
				var header = response.data.header;
				var log = response.data.log;

				if( (log && log != bugfu_previous_log) || bugfu_previous_log == null ) {
					
					console.log(preheader.concat(header, "\n\n", log, "\n\n\n"));

					bugfu_previous_log = log;
				}

			}
		})
	}

})( jQuery );