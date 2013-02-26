<?php defined('_JEXEC') or die;

/**
 * File       diagnostic.php
 * Created    2/12/13 11:59 AM
 * Author     Matt Thomas
 * Website    http://betweenbrain.com
 * Email      matt@betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2012 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

class JElementDiagnostic extends JElement {

	function fetchElement() {

		// Fetch parameters via database query
		$db  = JFactory::getDBO();
		$sql = 'SELECT params
          FROM #__modules
          WHERE module = "mod_collections"';
		$db->setQuery($sql);
		$params = $db->loadResult();

		// In Joomla 1.5, parameters are stored as a string, so we need to match condition with strpos.
		$displayDiagnostic = strpos($params, 'displaydiagnostic=1');
		$cache             = strpos($params, 'cache=1');

		// JPATH_CACHE is relative to where it is being called from, as we want the site cache, /administrator is removed.
		$cacheDir = JPATH_CACHE . '/mod_collections/';
		$cacheDir = preg_replace("/administrator\//", '', $cacheDir);
		// Determine cache maximum age as set by parameter
		preg_match("/cachemaxage=([0-9]*)/", $params, $cacheMaxAge);

		// Initialize variables
		$result   = NULL;
		$messages = NULL;
		$errors   = NULL;

		if ($displayDiagnostic) {

			// Check cache stuff
			if (!$cache) {
				$messages[] = "Caching is disabled.";
			}

			if ($cache) {

				$messages[] = "Caching is enabled.";

				$cache    = $cacheDir . 'objects.json';
				$cacheAge = date("F d Y H:i:s", filemtime($cache));

				if (file_exists($cache)) {
					$messages[] = "The cache file exists at $cache.";
					$messages[] = "The cache file was created $cacheAge.";
				}

				$messages[] = "Cache lifetime is $cacheMaxAge[1] minute(s).<br/>";

				if (is_dir($cacheDir)) {
					$messages[] = "Cache directory exists at $cacheDir.";
				} else {
					$errors[] = "The cache directory at $cacheDir does not exist!";
				}
			}

			if ($messages[0]) {
				$result .= '<dl id="system-message"><dt>Information</dt><dd class="message fade"><ul>';
				foreach ($messages as $message) {
					$result .= '<li>' . $message . '</li>';
				}
				$result .= '</ul></dd></dl>';
			}

			if ($errors[0]) {
				$result .= '<dl id="system-message"><dt>Errors</dt><dd class="error message fade"><ul>';
				foreach ($errors as $error) {
					$result .= '<li>' . $error . '</li>';
				}
				$result .= '</ul></dd></dl>';
			}

			if ($result) {
				return print_r($result, FALSE);
			}

			return FALSE;
		}

		return FALSE;
	}
}