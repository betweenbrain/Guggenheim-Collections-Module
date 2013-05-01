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
// Last item flag
$last = count($items) - 1;
// Module class suffix
$moduleclass_sfx = $params->get('moduleclass_sfx');
// Render module output
require JModuleHelper::getLayoutPath('mod_collections');

$imageMaxWidth  = $params->get('imageMaxWidth');
$imageMaxHeight = $params->get('imageMaxHeight');
$css            = '.collections li img { max-width: ' . $imageMaxWidth . 'px; max-height: ' . $imageMaxHeight . 'px;}';
$doc->addStyleDeclaration($css);

/**
 * Load CSS/JS files, first checking for template override.
 *
 * JPATH_SITE: Absolute path to the installed Joomla! site Checking absolute path helps security.
 *
 * JURI::base():  Base URI of the Joomla site. If TRUE, then only the path, trailing "/" omitted, to the Joomla site is returned;
 * otherwise the scheme, host and port are prepended to the path.
 */

if (file_exists(JPATH_SITE . '/templates/' . $app->getTemplate() . '/css/looper.css')) {
	$doc->addStyleSheet(JURI::base(TRUE) . '/templates/' . $app->getTemplate() . '/css/looper.css');
} elseif (file_exists(JPATH_SITE . '/media/looper/css/looper.css')) {
	$doc->addStyleSheet(JURI::base(TRUE) . '/media/looper/css/looper.css');
}

if (file_exists(JPATH_SITE . '/templates/' . $app->getTemplate() . '/js/looper.js')) {
	$doc->addScript(JURI::base(TRUE) . '/templates/' . $app->getTemplate() . '/js/looper.js');
} elseif (file_exists(JPATH_SITE . '/media/looper/js/looper.js')) {
	$doc->addScript(JURI::base(TRUE) . '/media/looper/js/looper.js');
}

if (file_exists(JPATH_SITE . '/templates/' . $app->getTemplate() . '/js/jquery.collections.js')) {
	$doc->addScript(JURI::base(TRUE) . '/templates/' . $app->getTemplate() . '/js/jquery.collections.js');
} elseif (file_exists(JPATH_SITE . '/modules/mod_collections/tmpl/js/jquery.collections.js')) {
	$doc->addScript(JURI::base(TRUE) . '/modules/mod_collections/tmpl/js/jquery.collections.js');
}