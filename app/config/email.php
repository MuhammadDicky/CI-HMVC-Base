<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Default mail service
|--------------------------------------------------------------------------
*/
$config['protocol']     = 'smtp';
$config['smtp_host']    = 'smtp.gmail.com';
$config['smtp_port']    = 465;
$config['smtp_user']    = 'simpadapos@gmail.com';
$config['smtp_pass']    = 'Semutsakti@1993';
$config['smtp_timeout'] = 60;
$config['smtp_crypto']  = 'ssl';
$config['mailtype']     = 'html';
$config['wordwrap']     = TRUE;
$config['newline']      = "\r\n";