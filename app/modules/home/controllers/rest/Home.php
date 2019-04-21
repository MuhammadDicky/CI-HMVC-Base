<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Default_Rest_Controller
{

	public function __construct()
	{
        parent::__construct();

		$this->config->load('ion_auth');
        $this->load->model('ion_auth_model');
        
	}

	/**
	 * api/home with method post go to this method
	 */
	public function index_post()
	{
        $this->response([
            'metadata' => [
                'code' => "200",
                'message' => "this ajax with post method"
            ],
            'status' => 'success'
        ], 200);
    }

    /**
	 * api/home with method post go to this method
	 */
	public function index_get()
	{
        $this->response([
            'metadata' => [
                'code' => "200",
                'message' => "this ajax with get method"
            ],
            'status' => 'success'
        ], 200);
    }

    /**
	 * api/home with method post go to this method
	 */
	public function index_put()
	{
        $this->response([
            'metadata' => [
                'code' => "200",
                'message' => "this ajax with put method"
            ],
            'status' => 'success'
        ], 200);
    }

    /**
	 * api/home with method post go to this method
	 */
	public function index_delete()
	{
        $this->response([
            'metadata' => [
                'code' => "200",
                'message' => "this ajax with delete method"
            ],
            'status' => 'success'
        ], 200);
    }

}

/* End of file Home.php */
/* Location: ./app/modules/home/controllers/rest/Home.php */