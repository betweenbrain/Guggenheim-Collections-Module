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
        $(".collections li img").each(function () {
            var itemHeight = $(this).outerHeight();
            if (itemHeight > maxHeight) {
                // Add 110px for the content div
                maxHeight = itemHeight + 110;
            }
        });
        // Set heights
        $(".collections li").height(maxHeight);
        // Set top coordinate of controls based on height
        $(".collections nav").css("top", ((maxHeight / 2) - 30));
    });
}(jQuery));