<?php

	class Config{

		/*Server Config*/
		var $_site_url            = 'http://localhost/';
		var $_sub_path            = 'ci-hmvc/public';
		var $_document_root       = __DIR__;
		var $_app_environment     = 'Development';
        var $_site_name           = '';
        var $_pkg                 = '';

        /*Web Assets Path*/
        var $_assets_path         = '';
		var $_components_path     = 'components/';
        var $_template_assets     = 'templates/';
        var $_image_assets        = 'web-images/';

		/*Database Config*/
		var $_hostname            = 'localhost';
		var $_database_user       = 'root';
		var $_database_password   = '';
		var $_database_name       = 'siakad_pt_hmvc';
		var $_table_prefix        = 'tbl_';
		var $_dbdriver            = 'mysqli';
		var $_table_swap_prefix   = '{PRE}';

		/*Web Detail Config*/
		var $_app_name;
        var $_app_version         = '1.0';
        var $_app_description     = 'Codeigniter Base with Modular Extension';
		var $_dev_name            = 'Muhammad Dicky Hidayat Latif';
		var $_web_name            = 'Codeigniter-HMVC';

		public function __construct(){
            // Set Base Url
            $sub_path = $this->_sub_path;
			if ($sub_path != '') {
				$this->_site_url = $this->_site_url . $sub_path . '/';
            }

            // Set app environment
            $app_env = array('Development','Testing','Production');
			if ($this->_app_environment != $app_env[0] && $this->_app_environment != $app_env[1] && $this->_app_environment != $app_env[2]) {
				$this->_app_environment = 'Development';
			}
        }

	}

 ?>
