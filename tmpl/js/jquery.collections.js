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

/*global $, jQuery*/

(function ($) {
	"use strict";
	$().ready(function () {
		// Initiate zero height
		var maxHeight = 0;
		// Since we're using absolute positioning, check the height of each image
		$(".sd-strip li img").each(function () {
			var itemHeight = $(this).outerHeight();
			if (itemHeight > maxHeight) {
				// Add 110px for the content div
				maxHeight = itemHeight + 110;
			}
		});
		// Set heights
		$(".collections, .sd-strip,  .sd-strip li").height(maxHeight);
		// Set top coordinate of controls based on height
		$(".sd-strip-controls").css("top", ((maxHeight / 2) - 30));

		// Initialize Gugg StripDeck
		$(".sd-strip-container").StripDeck({
			autoPlay       : false,
			speed          : 1000,
			transitionSpeed: 500,
			deck           : false
		});
	});
}(jQuery));