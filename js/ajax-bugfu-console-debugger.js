(function($) {
	
	var bugfu_can_read_log = true;
	var bugfu_previous_log = null;
	var bugfu_read_log_interval = null;
	var bugfu_interval_millisec = 350;

	$( document ).ready( function() {

		bugfu_read_log_interval = setInterval( bugfu_read_log, bugfu_interval_millisec );
	});

	$( document ).ajaxSend( function() {

		if( bugfu_read_log_interval == null ) {

			bugfu_read_log_interval = setInterval( bugfu_read_log, bugfu_interval_millisec );
		}
	});

	function bugfu_read_log() {

		if( bugfu_can_read_log ) {

			bugfu_can_read_log = false;

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

					if( log || bugfu_previous_log == null ) {
						
						console.log(preheader.concat(header, "\n\n", log, "\n\n\n"));
						bugfu_previous_log = log;
					}

					clearInterval(bugfu_read_log_interval);
					bugfu_read_log_interval = null;
					bugfu_can_read_log = true;
				},
				error: function(){
					
					clearInterval(bugfu_read_log_interval);
					bugfu_read_log_interval = null;
					bugfu_can_read_log = true;
				} 
			});
		}
	}

})( jQuery );