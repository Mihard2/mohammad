(function (j) {
"use strict"; 

	if (typeof popwid == "undefined") return;

	j.post(inforward_global_vars.ajaxurl, {
		postid: popwid.postid,
		action: "popwid_page_view_count"
	});

})(jQuery);
