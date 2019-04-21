<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ .  DIRECTORY_SEPARATOR . 'REST_Controller.php';

class Main_Rest_Controller extends REST_Controller
{

    public $data = [];
    public $no_respon_data = [
        'status' => 'not_found_action'
    ];

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('option_helper'));

		$this->data['app_title'] = $this->config->item('app_title');
		$this->data['app_description'] = $this->config->item('app_description');
		$this->data['app_version'] = $this->config->item('app_version');
        $this->form_validation->CI =& $this;
    }

}

/* End of file Main_Rest_Controller.php */
/* Location: ./app/core/Main_Rest_Controller.php */