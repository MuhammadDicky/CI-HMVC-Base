<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Controller extends MX_Controller
{

    public $data = [];
    public $active_theme = 'default';
    public $app_config;
    public $app_assets;
    public $app_components;

	public function __construct()
	{
        parent::__construct();

        // Load resources
        // $this->load->helper([
        //     'theme_dir_helper'
        // ]);
        // $this->load->library([
        //     'theme'
        // ]);
        // $this->load->model([
        //     'menu/menu_model'
        // ]);

        global $Config;
        $this->app_config = $Config;

        // Load app information
        $this->data['app_title'] = $this->config->item('app_title');
		$this->data['app_description'] = $this->config->item('app_description');
        $this->data['app_version'] = $this->config->item('app_version');
        $this->data['web_detail'] = $this->app_config;

	}

}

/* End of file Main_Controller.php */
/* Location: ./app/core/Main_Controller.php */