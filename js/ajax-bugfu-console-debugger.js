(function($) {
	
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
				
				if( response ) {
					console.log(response);
					clearInterval( bugfu_read_log_interval );
				}

			}
		})
	}

})( jQuery );