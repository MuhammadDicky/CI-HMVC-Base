<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content_dir {

	protected $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
	}

	public function createAvatarDir($username)
	{
		$avatar_path = "content/uploads/{$username}/avatar";
		$complete_path = APPPATH . "../{$avatar_path}";

		if ( ! is_dir(APPPATH . "../content/uploads") ) {
			if ( ! $this->createUploadDir() ) {
				return FALSE;
			} else {
				if ( ! is_dir(APPPATH . "../content/uploads/{$username}") ) {
					if ( ! $this->createUserDir($username) ) {
						return FALSE;
					} else {
						if ( ! is_dir($complete_path) ) {
							if ( ! mkdir($complete_path, 0777) ) {
								return FALSE;
							} else {
								if ( ! write_file("{$complete_path}/index.html", "Access forbidden") ) {
									return FALSE;
								}
							}
						}
					}
				}
			}
		}

		return $avatar_path;
	}

	public function createUserDir($username)
	{
		$user_path = "content/uploads/{$username}";
		$complete_path = APPPATH . "../{$user_path}";

		if ( ! is_dir(APPPATH . "../content/uploads") ) {
			if ( ! $this->createUploadDir() ) {
				return FALSE;
			} else {
				if ( ! is_dir($complete_path) ) {
					if ( ! mkdir($complete_path, 0777) ) {
						return FALSE;
					} else {
						if ( ! write_file("{$complete_path}/index.html", "Access forbidden") ) {
							return FALSE;
						}
					}
				}
			}
		}

		return $user_path;
	}

	private function createUploadDir()
	{
		$upload_path = "content/uploads";
		$complete_path = APPPATH . "../{$upload_path}";

		if ( ! is_dir($complete_path) ) {
			if ( ! mkdir($complete_path, 0777) ) {
				return FALSE;
			} else {
				if ( ! write_file("{$complete_path}/index.html", "Access forbidden") ) {
					return FALSE;
				}
			}
		}

		return $upload_path;
	}

}

/* End of file Content_dir.php */
/* Location: ./app/libraries/Content_dir.php */