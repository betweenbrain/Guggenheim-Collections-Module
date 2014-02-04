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
		$accessKey      = htmlspecialchars($this->params->get('accessKey'));
		$connectTimeout = htmlspecialchars($this->params->get('connectTimeout'));
		$curlTimeout    = htmlspecialchars($this->params->get('curlTimeout'));
		$endpoint       = $this->params->get('endpoint');
		$endpointID     = $this->params->get('endpointID');
		$resultsLimit   = htmlspecialchars($this->params->get('resultsLimit'));
		$userAgent      = htmlspecialchars($this->params->get('userAgent'));

		// Build the search URL
		$url = 'http://api.guggenheim.org/collections/' . $endpoint;
		$url .= $endpointID ? '/' . $endpointID : NULL;
		$url .= '?per_page=' . $resultsLimit;
		$url .= '&key=' . $accessKey;

		$curl = curl_init();

		curl_setopt_array($curl, Array(
			CURLOPT_USERAGENT      => $userAgent,
			CURLOPT_HTTPHEADER     => array('Accept: application/vnd.guggenheim.collection+json'),
			CURLOPT_URL            => $url,
			CURLOPT_TIMEOUT        => $curlTimeout,
			CURLOPT_CONNECTTIMEOUT => $connectTimeout,
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
		$endpoint   = $this->params->get('endpoint');
		$collection = json_decode($json);
		$item       = NULL;

		if ($collection) {
			if ($endpoint == 'acquisitions') {

				if (isset($collection->objects->items)) {

					foreach ($collection->objects->items as $key => $items) {

						if (isset($items->media[0])) {

							foreach ($items->media[0] as $media) {

								if (isset($media->medium->_links->_self->href)) {
									$item[$key]['media'] = $media->medium->_links->_self->href;
									$imageWidth          = $media->medium->width;
									$imageHeight         = $media->medium->height;
								}

								$imageMaxWidth  = $this->params->get('imageMaxWidth');
								$imageMaxHeight = $this->params->get('imageMaxHeight');
								$logErrors      = $this->params->get('logErrors');

								if ($logErrors) {
									jimport('joomla.error.log');
									$log     =& JLog::getInstance('mod_collections.log');
									$headers = get_headers($item[$key]['media'], 1);
									if ($headers[0] == 'HTTP/1.1 404 Not Found') {
										$log->addEntry(array('LEVEL' => '1', 'STATUS' => '404 ERROR: ', 'COMMENT' => $item[$key]['media'] . ' returns a 404 error.'));
									}
									if ($imageWidth == '0') {
										$log->addEntry(array('LEVEL' => '1', 'STATUS' => 'IMAGE DIM: ', 'COMMENT' => $items->accession . ' has a zero image width dimension.'));
									}
									if ($imageHeight == '0') {
										$log->addEntry(array('LEVEL' => '1', 'STATUS' => 'IMAGE DIM: ', 'COMMENT' => $items->accession . ' has a zero image height dimension.'));
									}
								}

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
				if ($this->params->get('cache') && !$this->validateCache($cache)) {
					$this->compileCache($json, $cache);
				} else {
					$this->validateCache($cache);
				}
			} elseif (file_exists($cache)) {
				$json  = file_get_contents($cache);
				$items = $this->compileCollectionItems($json);
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
	protected function compileCache($json, $cache) {
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