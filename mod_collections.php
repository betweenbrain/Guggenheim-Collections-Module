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
// Module class suffix
$moduleclass_sfx = $params->get('moduleclass_sfx');
// Render module output
require JModuleHelper::getLayoutPath('mod_collections');
