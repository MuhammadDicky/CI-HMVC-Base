<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Ion_auth {

    protected $ci;
    public $active_user;

	public function __construct()
	{
		$this->ci =& get_instance()->controller;
	}

	public function data($id = NULL)
	{
        $this->ci->load->model('users/users_model');
        
        if (!$id) {
            $user_id = $this->ion_auth->user()->row();
            $id = $user_id->id;
        }

        $user = $this->ci->users_model->get([
            'id' => $user_id->id
        ]);

        if ($user) {
            return $user;
        } else {
            return FALSE;
        }
    }

    public function rest_auth($group = NULL, $param = NULL)
    {
        // check group
        if (is_array($group) && isset($group['exclude'])) {
            // Check exclude access to module
            foreach ($group['exclude'] as $key_exclude => $exclude_controller) {
                $exclude_group = $key_exclude;

                // Check current login group
                if ($this->ion_auth->in_group($exclude_group)) {

                    $exclude_controller = array_map(function ($url) {
                        return "api/" . $url;
                    }, $exclude_controller);

                    if (in_array($this->uri->uri_string(), $exclude_controller)) {
                        // Add new group
                        if (is_array($group["group"])) {
                            array_push($group["group"], $exclude_group);
                        } else {
                            $group["group"] = [$group["group"], $exclude_group];
                        }
                    }

                }

            }

            if ($group["group"] == NULL) {
                $group["group"] = $this->active_user;
            }

            $check_user_group = $this->check_group($group["group"]);

            
        } else {
            if ($group == NULL) {
                $group = $this->active_user;
            }

            $check_user_group = $this->check_group($group);
        }

        if ($check_user_group && $check_user_group['status'] == FALSE) {
            // Check Params
            if ($param) {
                $code = $param['code'];
                $message = $param['message'];
            } else {
                $code = @$check_user_group['code'];
                $message = @$check_user_group['message'];
            }

            $this->ci->response([
                'metadata' => [
                    'code' => $code,
                    'message' => $message
                ]
            ], $code);
        }
    }

    public function check_group()
    {
        // Check if user already logged
        if ($this->ion_auth->logged_in()) {
            $lvl = $this->ci->user->active_user;
            $check = $this->ion_auth->in_group($lvl);
            if (!$check){
                if ($this->ci->input->is_ajax_request()) {
                    $this->ci->response([
                        'metadata' => [
                            'code' => 401,
                        ],
                        'status' => 'unauthorized',
                        'message' => 'Maaf, anda tidak bisa mengakses/melakukan manipulasi pada data ini'
                    ], 401);
                } else {
                    $this->session->set_flashdata('message', 'Maaf, anda tidak bisa mengakses halaman tadi!');
                    redirect($this->redirect_default_page());
                }
            }
        } else {
            if ($this->ci->input->is_ajax_request()) {
                $this->ci->response([
                    'metadata' => [
                        'code' => 401,
                    ],
                    'status' => 'not_logged',
                    'message' => 'Maaf, anda harus login terlebih dahulu...'
                ], 401);
            } else {
                redirect("login");
            }
        }
    }

    public function redirect_default_page()
    {
        $user = $this->data();
        $this->load->helper('array');
        $redirect = [
            "admin" => site_url("admin/dashboard"),
        ];
        return element($user->group_name, $redirect, site_url("dashboard"));
    }

}