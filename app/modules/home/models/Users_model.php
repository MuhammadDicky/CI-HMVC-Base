<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends My_Models
{

	protected $_table_name = 'users';
	protected $_primary_key = 'id';
	protected $_view = 'v_users';

	public function __construct()
	{
		parent::__construct();
	}

}

/* End of file User_model.php */
/* Location: ./app/modules/users/models/Users_model.php */