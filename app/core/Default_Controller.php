<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Default_Controller extends Main_Controller
{

	public function __construct()
	{
        parent::__construct();

        // Set theme: app/config/app.php
        $this->template->set_theme($this->config->item('default_theme'));
        // Set layout: app/themes/default/views/layouts/index.php
        $this->template->set_layout('index');
	}

}

/* End of file Default_Controller.php */
/* Location: ./app/core/Default_Controller.php */