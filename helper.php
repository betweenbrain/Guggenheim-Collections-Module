<?php defined('_JEXEC') or die;

/**
 * File       helper.php
 * Created    2/12/13 12:25 PM
 * Author     Matt Thomas
 * Website    http://betweenbrain.com
 * Email      matt@betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2012 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

class modCollectionsHelper {

	/**
	 * Module parameters
	 *
	 * @var    boolean
	 * @since  0.0
	 */
	protected $params;

	/**
	 * Constructor
	 *
	 * @param   JRegistry  $params  The module parameters
	 *
	 * @since  1.0
	 */
	public function __construct($params) {
		// Store the module params
		$this->params = $params;
	}

	/**
	 * Protected function to do something. Protected as it is only used within this class.
	 *
	 * @internal param $result
	 * @return array
	 * @since    1.0
	 */
	protected function fetchCollection() {

		// Get parameters from the module's configuration
		$accessKey  = htmlspecialchars($this->params->get('accessKey'));
		$endpoint   = $this->params->get('endpoint');
		$endpointID = $this->params->get('endpointID');

		// Build the search URL
		$url = 'http://api.guggenheim.org/collections/' . $endpoint;
		$url .= $endpointID ? '/' . $endpointID : NULL;
		$url .= '?key=' . $accessKey;

		$curl = curl_init();

		curl_setopt_array($curl, Array(
			CURLOPT_USERAGENT      => "JoomlaCollectionsModule",
			CURLOPT_HTTPHEADER     => array('Accept: application/vnd.guggenheim.collection+json'),
			CURLOPT_URL            => $url,
			CURLOPT_TIMEOUT        => 300,
			CURLOPT_CONNECTTIMEOUT => 60,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_SSL_VERIFYHOST => FALSE,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_ENCODING       => 'UTF-8'
		));

		$json = curl_exec($curl);
		$data = json_decode($json, TRUE);

		if ($data) {
			return $json;
		}

		return FALSE;
	}

	/**
	 * Function to compile collection items for rendering
	 *
	 * @internal param $json
	 * @param $json
	 * @return array
	 * @since    1.0
	 */
	function compileCollectionItems($json) {
		$endpoint = $this->params->get('endpoint');
		//$json       = $this->fetchCollection();
		$collection = json_decode($json);
		$item       = NULL;

		//die('<pre>' . print_r($collection, TRUE) . '</pre>');

		if ($collection) {
			if ($endpoint == 'acquisitions') {

				if (isset($collection->objects->items)) {

					foreach ($collection->objects->items as $key => $items) {

						if (isset($items->media)) {
							foreach ($items->media as $media) {
								$item[$key]['media'] = $media->assets->full->_links->_self->href;
								$imageWidth          = $media->assets->full->width;
								$imageHeight         = $media->assets->full->height;
								$imageMaxWidth       = $this->params->get('imageMaxWidth');
								$imageMaxHeight      = $this->params->get('imageMaxHeight');

								if (($imageWidth > $imageMaxWidth) || ($imageHeight > $imageMaxHeight)) {
									$scale                = ($imageWidth > $imageHeight) ? ($imageMaxWidth / $imageWidth) : ($imageMaxHeight / $imageHeight);
									$item[$key]['width']  = round($imageWidth * $scale);
									$item[$key]['height'] = round($imageHeight * $scale);
								}
							}
						}

						if (isset($items->titles->primary)) {
							$item[$key]['title'] = $items->titles->primary->title;
							$limit               = $this->params->get('titleLimit');
							if ($limit) {
								preg_match("/(\S+\s*){0,$limit}/", $item[$key]['title'], $matches);
								if ($matches[0] != $item[$key]['title']) {
									$item[$key]['title'] = trim($matches[0]) . '&hellip;';
								}
							}
						}

						if (isset($items->constituents[0])) {
							foreach ($items->constituents as $constituents) {
								if ($constituents->role == "Artist") {
									$item[$key]['name'] = $constituents->constituent->display;
									if ($constituents->constituent->has_bio == '1') {
										$item[$key]['bioUrl'] = 'http://www.guggenheim.org/new-york/collections/collection-online/show-full/bio/?artist_name=' . str_replace(' ', '%20', $constituents->constituent->display);
									}
								}
							}
						}

						if (isset($items->_links->web)) {
							$item[$key]['link'] = $items->_links->web->href;
						}

						if (isset($items->dates->display)) {
							$item[$key]['date'] = $items->dates->display;
						}

						if (isset($items->essay)) {
							$item[$key]['essay'] = $items->essay;
						}
					}
				}
			}

			return $item;
		}

		return FALSE;
	}

	/**
	 * Function to fetch collection items
	 *
	 * @since  1.0
	 */
	function fetchCollectionItems() {
		$cache = JPATH_CACHE . '/mod_collections/objects.json';
		if ($this->params->get('cache') && $this->validateCache($cache)) {
			$json  = file_get_contents($cache);
			$items = $this->compileCollectionItems($json);
		} else {
			$json = $this->fetchCollection();
			if ($json) {
				$items = $this->compileCollectionItems($json);
				if ($this->params->get('cache')) {
					$this->compileCache($json, $cache);
				}
				if (!$this->params->get('cache')) {
					$this->validateCache($cache);
				}
			} else {
				return FALSE;
			}
		}

		return $items;
	}

	/**
	 * Function to compile cache file
	 *
	 * @since  1.0
	 */
	protected
	function compileCache($json, $cache) {
		if (json_decode($json)) {
			file_put_contents($cache, $json);
			if (file_exists($cache)) {
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Function to validate cache file
	 *
	 * @since  1.0
	 */
	function validateCache($cache) {
		if ($this->params->get('cache')) {
			if (file_exists($cache)) {
				$cacheTime = ($this->params->get('cachetime', 15)) * 60;
				$cacheAge  = filemtime($cache);
				if ((time() - $cacheAge) >= $cacheTime) {
					unlink($cache);

					return FALSE;
				}

				return TRUE;
			}
		} elseif (!$this->params->get('cache') && file_exists($cache)) {
			unlink($cache);
		}

		return FALSE;
	}
}