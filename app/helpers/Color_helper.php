<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Generate random color
 * return array random rgba color
 */

if (! function_exists('getColor')) {
    function getColor($type = NULL)
    {
        $color = "rgba(". rand(10,255) .", ". rand(10,255) .", ". rand(10,255) .",";
        $return_color = [
            "border" => $color . " 1)",
            "bg" => $color . " 0.2)"
        ];
        
        if ($type) {
            return $return_color[$type];
        } else {
            return $return_color;
        }
	}
}