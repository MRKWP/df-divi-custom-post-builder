jQuery(document).ready(function($) {
	// trigger click
	setTimeout(function(){
		var el = jQuery('#et_pb_toggle_builder');

		if(!el.hasClass('et_pb_builder_is_used')){
			el.click();
		}
	}
	, 1200);
});