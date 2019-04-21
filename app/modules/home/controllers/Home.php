<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Default_Controller
{

	public function __construct()
	{
        parent::__construct();
    }

    public function index()
    {
        $this->data['view'] = 'app/modules/home/views/home.php';
        // Set partial view: app/modules/home/views/test-rest.php;
        $this->template->set_partial('optional', 'test-rest.php', $this->data);

        // Set build view: app/modules/home/views/home.php and passing $this->data
        $this->template->build('home.php', $this->data);
    }

    public function about()
    {
        $this->data['view'] = 'app/modules/home/views/about.php';
        // Set build view: app/modules/home/views/about.php and passing $this->data
        $this->template->build('about.php', $this->data);
    }

}

/* End of file Home.php */
/* Location: ./app/modules/home/controllers/Home.php */