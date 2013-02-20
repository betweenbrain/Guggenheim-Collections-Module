/**
 * File
 * Created    2/19/13 4:45 PM
 * Author     Matt Thomas
 * Website    http://betweenbrain.com
 * Email      matt@betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */
(function ($) {
	$().ready(function () {
		$(".sd-strip-container").StripDeck({
			autoPlay       : false,
			speed          : 1000,
			transitionSpeed: 500,
			deck           : false
		});

		// Detect and append total number of items
		var n = $(".sd-strip li").length, p = $(".sd-strip").offset(), l = (p.left - 382);
		$(".collections-module h3").append("<p class='counter'>" + (l + 1) + "-" + (l + 4) + " of " + n + "</p>");

		var maxHeight = 0;

		$(".sd-strip li").each(function () {
			//Store the highest value
			if ($(this).height() > maxHeight) {
				maxHeight = $(this).height();
			}
		});

		//Set the height
		$(".sd-strip li").height(maxHeight);

	});
})(jQuery);