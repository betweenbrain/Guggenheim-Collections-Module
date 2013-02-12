<?php defined('_JEXEC') or die;

/**
 * File       helper.php
 * Created    12/31/12 12:25 PM
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
     * @var    boolean
     * @since  0.0
     */
    protected $params;

    /**
     * Constructor
     *
     * @param   JRegistry  $params  The module parameters
     *
     * @since  0.0
     */
    public function __construct($params) {
        // Store the module params
        $this->params = $params;
    }

    /**
     * Protected function to do something. Protected as it is only used within this class.
     *
     * @param $result
     * @return array
     * @since  0.0
     */
    protected function bar($result) {

        // Remove double spaces, tabs, new lines.
        $result = preg_replace(array('/\s{2,}+/', '/\t/', '/\n/'), '', $result);

        // Make vowels uppercase
        $result = str_replace(array('a', 'e', 'i', 'o', 'u'), array('A', 'E', 'I', 'O', 'U'), $result);

        return $result;
    }

    /**
     * Function to compile data cache file
     * @param $json
     * @param string $name
     * @return bool
     * @since  0.0
     */
    function compileCache($json, $name = "raw") {
        $cacheFile = JPATH_CACHE . '/mod_collections/skeleton_' . $name . '_cache.json';
        // Don't compile cache if json has no data.
        if (json_decode($json)) {
            file_put_contents($cacheFile, $json);
            if (file_exists($cacheFile)) {

                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Function to fetch cached
     * @param string $name
     * @return bool|mixed
     * @since  0.0
     */
    function fetchCache($name = "raw") {
        // If cache is enabled, and there is a cache file, use it.
        if ($this->params->get('cache') && $this->validateCache($name)) {
            $json = file_get_contents(JPATH_CACHE . '/mod_collections/skeleton_' . $name . '_cache.json');
            // When json_decode is TRUE, returned objects will be converted into associative arrays. http://php.net/manual/en/function.json-decode.php
            $data = json_decode($json, TRUE);

            return $data;
        }

        return FALSE;
    }

    /**
     * Function foo
     * @return bool
     * @since  0.0
     */
    function foo() {
        $result = htmlspecialchars($this->params->get('sometext'));

        return $this->bar($result);
    }

    /**
     * Function to validate cache file
     * @param string $name
     * @return bool
     * @since  0.0
     */
    function validateCacheAge($name = "raw") {
        $cacheFile = JPATH_CACHE . '/mod_collections/skeleton_' . $name . '_cache.json';
        // If caching is enabled
        if ($this->params->get('cache') && file_exists($cacheFile)) {
            // Convert user input max cache age to minutes
            $cacheMaxAge = ($this->params->get('cachemaxage', 15)) * 60;
            // Get age of cache file
            $cacheAge = filemtime($cacheFile);
            // Check if cache has expired
            if ((time() - $cacheAge) >= $cacheMaxAge) {
                // If it's stale, delete it and...
                unlink($cacheFile);

                // ... return false as cache isn't valid
                return FALSE;
            }

            // Cache is valid
            return TRUE;
        }

        // Remove old cache file if caching is turned off
        if (!$this->params->get('cache') && file_exists($cacheFile)) {
            unlink($cacheFile);
        }

        return FALSE;
    }

}