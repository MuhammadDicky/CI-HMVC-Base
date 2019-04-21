<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{

	public $CI;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * check conflict user email
	 * @param  [type] $str        [description]
	 * @param  [type] $exclude_id [description]
	 * @return [type]             [description]
	 */
	
	// function run($module = '', $group = '')
	// {
	// 	(is_object($module)) AND $this->CI = &$module;
	// 	return parent::run($group);
	// }

	public function conflict_user_email($str, $exclude_id=NULL)
	{
		if ( $exclude_id !== NULL ) $this->CI->db->where_not_in('id', $exclude_id);

		$result = $this->CI->db->select('id')->from('users')->where('email', $str)->get();
		
		if ( $result->num_rows() > 0 ) {
			$this->set_message('conflict_user_email', '{field} has been used by other user.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function unique_field($str, $params)
	{
		$params = explode('.', $params);

		$table = $params[0];
		$field = $params[1];

		if (count($params) === 4) {
            $method_ajax = $this->CI->input->method();
			$exclude_field = $params[2];
			$exclude_value = $this->CI->$method_ajax($params[3], TRUE);

			$this->CI->db->where_not_in($exclude_field, $exclude_value);
		}

		$result = $this->CI->db->select($field)->from($table)->where($field, $str)->get();
		
		if ( $result->num_rows() > 0 ) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function check_data($str, $tbl)
	{
		$params = explode('.', $tbl);

		$table = $params[0];
		$field = $params[1];

		$result = $this->CI->db->select()->from($table)->where($field, $str)->get();

		if ( $result->num_rows() > 0 ) {
			return TRUE;
		} else {
			return FALSE;
		}
    }

}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */
