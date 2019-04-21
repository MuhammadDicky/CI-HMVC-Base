<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_server
{
	protected $ci;

	protected $tStamp;
	protected $appKey;
	protected $isVerified = FALSE;

	public function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->config->load('api_server');
	}

	public function verifySignature($appKey, $tStamp, $encodedSignature)
	{
		$decodedSignature = base64_decode($encodedSignature);

		// search provider
		$query = $this->ci->db
		                  ->select($this->config->item('app_key_field') . "," . $this->config->item('app_secret_field'))
		                  ->from($this->config->item('provider_table'))
		                  ->where($this->config->item('app_key_field') . "=" . $appKey);

		if ( $query->num_rows() > 0 ) {
			// provider found
			// check authorization
			
		}
	}
}

/* End of file Api_server.php */
/* Location: ./application/libraries/Api_server.php */