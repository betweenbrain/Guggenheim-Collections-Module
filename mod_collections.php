<?php defined('_JEXEC') or die;

/**
 * File       mod_collections.php
 * Created    2/12/13 12:04 PM
 * Author     Matt Thomas
 * Website    http://betweenbrain.com
 * Email      matt@betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2012 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

// Include the helper file
require_once(dirname(__FILE__) . DS . 'helper.php');
// Application object
$app = JFactory::getApplication();
// Global document object
$doc = JFactory::getDocument();
// Instantiate our class
$collection = new modCollectionsHelper($params);
// Call the foo function
$items = $collection->fetchCollectionItems();
// Module class suiffix
$moduleclass_sfx = $params->get('moduleclass_sfx');
// Render module output
require JModuleHelper::getLayoutPath('mod_collections');

$js = '<script type="text/javascript">
(function ($) {
	$().ready(function () {
		$(".sd-strip-container").StripDeck({
			autoPlay       : false,
			speed          : 1000,
			transitionSpeed: 500
		});
	});
})(jQuery)
</script>';

$doc->addCustomTag($js);

/**
 * Load CSS files, first checking for template override of CSS.
 *
 * JPATH_SITE: Absolute path to the installed Joomla! site Checking absolute path helps security.
 *
 * JURI::base():  Base URI of the Joomla site. If TRUE, then only the path, trailing "/" omitted, to the Joomla site is returned;
 * otherwise the scheme, host and port are prepended to the path.
 */

if (file_exists(JPATH_SITE . '/templates/' . $app->getTemplate() . '/css/mod_collections/collections.css')) {
	$doc->addStyleSheet(JURI::base(TRUE) . '/templates/' . $app->getTemplate() . '/css/mod_collections/collections.css');
} elseif (file_exists(JPATH_SITE . '/modules/mod_collections/tmpl/css/collections.css')) {
	$doc->addStyleSheet(JURI::base(TRUE) . '/modules/mod_collections/tmpl/css/collections.css');
}