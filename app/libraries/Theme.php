<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Theme
{

    public $CI;

    public function __construct()
	{
        $this->CI =& get_instance()->controller;
    }

    public function setTheme($layout_theme)
	{
		$this->CI->template->set_theme($this->CI->config->item($layout_theme.'_theme'));
    }
    
    public function buildTheme($view_theme, $data)
    {
        $this->CI->template->build($this->CI->active_theme . '/' . $view_theme, $data);
    }

    public function setPartial($name, $view, $data = array())
    {
        $this->CI->template->set_partial($name, $this->CI->active_theme . '/' . $view, $data);
    }

    public function setLayout($view, $_layout_subdir = '')
    {
        $this->CI->template->set_layout($this->CI->active_theme . '/' . $view, $_layout_subdir);
    }

}