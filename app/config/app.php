<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

global $Config;

/*
|--------------------------------------------------------------------------
| Default timezone
|--------------------------------------------------------------------------
|
*/
date_default_timezone_set('Asia/Makassar');

/*
|--------------------------------------------------------------------------
| Application title
|--------------------------------------------------------------------------
|
| application title
|
*/
$config['app_title'] = $Config->_web_name;

/*
|--------------------------------------------------------------------------
| Application description
|--------------------------------------------------------------------------
|
| application description
|
*/
$config['app_description'] = $Config->_app_description;

/*
|--------------------------------------------------------------------------
| Application version
|--------------------------------------------------------------------------
|
| application version number
|
*/
$config['app_version'] = $Config->_app_version;

/*
|--------------------------------------------------------------------------
| Admin theme
|--------------------------------------------------------------------------
|
| WARNING: You MUST set this value!
|
| admin theme directory name
|
| 	Default: 'default'
|
*/
$config['default_theme'] = 'default';