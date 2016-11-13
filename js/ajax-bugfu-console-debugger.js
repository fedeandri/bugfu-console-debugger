(function($) {
	
	var bugfu_previous_log = null;
	var bugfu_is_reading_log = false;
	
	$( document ).ready( function() {

		bugfu_read_log();

		$( document ).ajaxSend( function() {

    		if( bugfu_previous_log !== null ) {
    			bugfu_read_log();
    		}
    	});
    	
	});

	function bugfu_read_log() {

		if( !bugfu_is_reading_log ) {

			bugfu_is_reading_log = true;

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

					if( log.length > 0 || bugfu_previous_log === null ) {
						
						console.log(preheader.concat(header, "\n\n", log, "\n\n\n"));
				    	bugfu_previous_log = log;
					}

					bugfu_is_reading_log = false;
				},
				error: function(){

					bugfu_is_reading_log = false;
				} 
			});
		}
	}

})( jQuery );