<?php

/**
 * Model for Achievements
 * php version 7.4
 *
 * @category Helper
 * @package  Helpers
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

if (! function_exists('formatMilliseconds')) {


    /**
     * Convert milliseconds into minutes/seconds/milliseconds
     *
     * @param int $milliseconds Number of Milliseconds
     *
     * @return string
     */
    function formatMilliseconds($milliseconds)
    {
        $seconds = floor($milliseconds / 1000);
        $minutes = floor($seconds / 60);
        $milliseconds = $milliseconds % 1000;
        $seconds = $seconds % 60;
        $minutes = $minutes % 60;

        $format = '%02u:%02u.%03u';
        $time = sprintf($format, $minutes, $seconds, $milliseconds);
        //return rtrim($time, '0');
        return $time;
    }
}
