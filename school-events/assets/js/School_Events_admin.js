/*
*
*/
jQuery(document).ready(function($){

	jQuery("#form_school_events").validate({
		rules: {
			churchschoolname: {
				required: true,
			},
			churchschoolcity: {
				required: true,
			},
			state: {
				required: true,
			},
			name: {
				required: true,
			},
			email: {
				required: true,
				email: true
			},
			phone: {
				required:true,
				minlength:10,
				maxlength:12,
				//number: true
			},
			eventname: {
				required: true,
			},
			eventstart: {
				required: true,
			},
			eventend: {
				required: true,
			},
			onlinelink: {
				required: true,
			},
			message: {
				required: true,
			}
		}
	});

});