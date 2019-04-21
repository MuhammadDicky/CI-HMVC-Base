<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('get_assets')) {
    function get_assets($dir, $r_con = FALSE, $from = NULL)
    {
        $_this->CI =& get_instance()->controller;
        $Config = $_this->CI->app_config;
        $url = $Config->_assets_path . $dir;
        
        return create_assets_url($url, $r_con, $from);
    }
}

if (! function_exists('get_theme_assets')) {
    function get_theme_assets($dir, $r_con = FALSE, $from = NULL)
    {
        $_this->CI =& get_instance()->controller;
        $Config = $_this->CI->app_config;
		$theme = 'adminlte';
		if (isset($_this->CI->active_theme)) {
			$theme = $_this->CI->active_theme . '/';
        }

        $url = $Config->_template_assets . $theme . $dir;
        
        return create_assets_url($url, $r_con, $from);
    }
}

if (! function_exists('get_components')) {
    function get_components($dir, $r_con = FALSE, $from = NULL)
    {
        $_this->CI =& get_instance()->controller;
        $Config = $_this->CI->app_config;
        $url = $Config->_components_path . $dir;
        
        return create_assets_url($url, $r_con, $from);
    }
}

if (! function_exists('get_custom_assets')) {
    function get_custom_assets($dir, $r_con = FALSE, $from = NULL)
    {
        $_this->CI =& get_instance()->controller;
        $Config = $_this->CI->app_config;
        $url = $Config->_template_assets . $_this->CI->active_theme . '/custom/' . $_this->CI->user->active_user . '/' . $dir;

        return create_assets_url($url, $r_con, $from);
    }
}

if (! function_exists('get_web_image')) {
    function get_web_image($image_dir, $r_con = FALSE, $from = NULL)
    {
        $_this->CI =& get_instance()->controller;
        $Config = $_this->CI->app_config;
        $url = $Config->_image_assets . $image_dir;

        return create_assets_url($url, $r_con, $from);
    }
}

if (! function_exists('get_dist_assets')) {
    function get_dist_assets($file, $r_con = FALSE, $from = NULL)
    {
        $dist = [
            'css' => 'css',
            'js' => 'js',
            'png' => 'img',
            'jpeg' => 'img',
            'jpg' => 'img',
            'icon' => 'img',
        ];

        $_this->CI =& get_instance()->controller;
        $Config = $_this->CI->app_config;
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $url = $Config->_assets_path . 'dist/' . $dist[$ext] . '/' . $file;

        return create_assets_url($url, FALSE, $from);
    }
}

if (! function_exists('get_custom_dist')) {
    function get_custom_dist($file, $user = FALSE, $from = NULL)
    {
        $_this->CI =& get_instance()->controller;
        $Config = $_this->CI->app_config;

        if ($user) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $file = str_replace($ext, $_this->CI->user->active_user, $file) . '.' . $ext;
        }
        $url = $_this->CI->active_theme . '/' . $file;

        return get_dist_assets($url, FALSE, $from);
    }
}

if (! function_exists('create_assets_url')) {
    function create_assets_url($dir, $r_con = FALSE, $from = NULL)
    {
        $_this->CI =& get_instance()->controller;
        $Config = $_this->CI->app_config;

        if (strtolower($from) === 'webpack') {
            $webpack = $Config->_pkg->options->webpack;

            if (strtolower($Config->_webpack_env) === 'development') {
                $url = 'http://localhost:' . $webpack->port . '/' . $dir;
            } else {
                $manifest = $Config->_webpack_manifest;
                $url = base_url($manifest->$dir);
            }
        } else {
            // Put hash
            if ($r_con) {
                $dir = $dir . '?nC=' . $Config->_prefix_link;
            }

            $url = base_url($dir);
        }
        
        return $url;
    }
}

if (! function_exists('web_detail')) {
    function web_detail($str)
    {
		global $Config;
		return $Config->$str;
	}
}

if (! function_exists('app_title')) {
    function app_title()
    {
		$_this->CI =& get_instance()->controller;
		if (!isset($_this->CI->data['page_title'])) {
            return $_this->CI->data['app_title'];
        } else {
            return $_this->CI->data['page_title'] . ' | ' . $_this->CI->data['app_title'];
        }
    }
}

if (! function_exists('active_page')) {
    function active_page($page, $class){
		$_this->CI =& get_instance()->controller;
		if ($page === @$_this->CI->data['menu'] || $page === @$_this->CI->data['sub_menu']) {
            return $class;
        }
	}
}

if (! function_exists('content_header')) {
    function content_header()
    {
		$_this->CI =& get_instance()->controller;
		global $Config;
		$array_page = array(
            'dashboard' => 'Dashboard',
            'data_master'             => 'Data Master',
            'data_identitas_pt'       => 'Data Identitas Perguruan Tinggi',
            'data_fakultas_pstudi'       => 'Data Fakultas & Program Studi',
		);
        
        if (array_key_exists($_this->CI->data['sub_menu'], $array_page)) {
            return $array_page[$_this->CI->data['sub_menu']];
        } elseif (array_key_exists($_this->CI->data['menu'], $array_page)) {
            return $array_page[$_this->CI->data['menu']];
        }
	}
}

if (! function_exists('create_breadcrumb')) {
    function create_breadcrumb()
    {
        $_this->CI =& get_instance()->controller;

		$array_page = [
			'admin'                   => [
                'title' => 'Dashboard',
                'link' => 'dashboard',
                'icon' => '<i class="fa fa-dashboard"></i>',
                'color' => 'text-aqua'
            ],
			'dashboard'               => [
                'title' => 'Dashboard',
                'link' => 'dashboard',
                'icon' => '<i class="fa fa-dashboard"></i>',
                'color' => 'text-aqua'
            ],
			'data_master'             => [
                'title' => 'Data Master',
                'link' => 'data_master',
                'icon' => '<i class="fa fa-archive"></i>',
                'color' => 'text-red'
            ],
			'data_identitas_pt'       => [
                'title' => 'Data Identitas Perguruan Tinggi',
                'link' => 'data_identitas_pt',
                'icon' => '',
                'color' => ''
            ],
			'data_fakultas_pstudi'    => [
                'title' => 'Data Fakultas dan Program Studi',
                'link' => 'data_fakultas_pstudi',
                'icon' => '',
                'color' => ''
            ],
			'data_thn_akademik'       => [
                'title' => 'Data Tahun Akademik',
                'link' => 'data_thn_akademik',
                'icon' => '',
                'color' => ''
            ],
			'data_angkatan'           => [
                'title' => 'Data Tahun Angkatan',
                'link' => 'data_angkatan',
                'icon' => '',
                'color' => ''
            ],
			'data_kelas'              => [
                'title' => 'Data Kelas',
                'link' => 'data_kelas',
                'icon' => '',
                'color' => ''
            ],
			'data_pengguna'           => [
                'title' => 'Data Pengguna',
                'link' => 'data_pengguna',
                'icon' => '<i class="fa fa-users"></i>',
                'color' => 'text-green'
            ],
			'data_pengguna_mahasiswa' => [
                'title' => 'Data Pengguna Mahasiswa',
                'link' => 'data_pengguna_mahasiswa',
                'icon' => '',
                'color' => ''
            ],
			'data_pengguna_ptk'       => [
                'title' => 'Data Pengguna Tenaga Pendidik',
                'link' => 'data_pengguna_ptk',
                'icon' => '',
                'color' => ''
            ],
			'data_pengunjung'         => [
                'title' => 'Data Pengunjung <sup class="text-aqua">BETA</sup>',
                'link' => 'data_pengunjung',
                'icon' => '',
                'color' => ''
            ],
			'data_akademik'           => [
                'title' => 'Data Akademik',
                'link' => 'data_akademik',
                'icon' => '<i class="fa fa-list-alt"></i>',
                'color' => 'text-yellow'
            ],
			'data_mahasiswa'          => [
                'title' => 'Data Mahasiswa',
                'link' => 'data_mahasiswa',
                'icon' => '',
                'color' => ''
            ],
			'data_ptk'                => [
                'title' => 'Data Tenaga Pendidik',
                'link' => 'data_ptk',
                'icon' => '',
                'color' => ''
            ],
			'data_mata_kuliah'        => [
                'title' => 'Data Mata Kuliah',
                'link' => 'data_mata_kuliah',
                'icon' => '',
                'color' => ''
            ],
			'data_jadwal_kuliah'      => [
                'title' => 'Data Jadwal Kuliah dan Data Kelas',
                'link' => 'data_jadwal_kuliah',
                'icon' => '',
                'color' => ''
            ],
			'data_nilai_mhs'          => [
                'title' => 'Data Nilai Mahasiswa',
                'link' => 'data_nilai_mhs',
                'icon' => '',
                'color' => ''
            ],
			'data_alumni_do'          => [
                'title' => 'Data Alumni & Mahasiswa Drop Out',
                'link' => 'data_alumni_do',
                'icon' => '',
                'color' => ''
            ],
			'data_mhs'                => [
                'title' => 'Data Mahasiswa',
                'link' => 'data_mhs',
                'icon' => '',
                'color' => ''
            ],
			'data_jadwal'             => [
                'title' => 'Jadwal Kuliah',
                'link' => 'data_jadwal',
                'icon' => '',
                'color' => ''
            ],
			'profil_pt'               => [
                'title' => 'Identitas Perguruan Tinggi',
                'link' => 'profil_pt',
                'icon' => '<i class="fa fa-university"></i>',
                'color' => 'text-red'
            ],
			'beranda_mhs'             => [
                'title' => 'Beranda Mahasiswa',
                'link' => 'beranda_mhs',
                'icon' => '<i class="fa fa-list-alt"></i>',
                'color' => 'text-yellow'
            ],
			'beranda_ptk'             => [
                'title' => 'Beranda Tenaga Pendidik',
                'link' => 'beranda_ptk',
                'icon' => '<i class="fa fa-list-alt"></i>',
                'color' => 'text-yellow'
            ],
			'data_tenaga_pendidik'    => [
                'title' => 'Data Tenaga Pendidik',
                'link' => 'data_tenaga_pendidik',
                'icon' => '',
                'color' => ''
            ],
			'jadwal_mengajar'         => [
                'title' => 'Jadwal Mengajar',
                'link' => 'jadwal_mengajar',
                'icon' => '',
                'color' => ''
            ],
			'nilai_mhs'               => [
                'title' => 'Nilai Mahasiswa',
                'link' => 'nilai_mhs',
                'icon' => '',
                'color' => ''
            ],
			'pengolahan_database'     => [
                'title' => 'Pengolahan Database <sup class="text-aqua">BETA</sup>',
                'link' => 'pengolahan_database',
                'icon' => '<i class="fa fa-database"></i>',
                'color' => 'text-muted'
            ],
			'pengaturan'              => [
                'title' => 'Pengaturan <sup class="text-aqua">BETA</sup>',
                'link' => 'pengaturan',
                'icon' => '<i class="fa fa-gears"></i>',
                'color' => 'text-muted'
            ],
			'about'                   => [
                'title' => 'Tentang',
                'link' => 'about',
                'icon' => '<i class="fa fa-exclamation-circle"></i>',
                'color' => 'text-muted'
            ]
        ];
        
        $breadcrumb = [];
        if (isset($_this->CI->data['breadcrumb']) && is_array($_this->CI->data['breadcrumb'])) {
            $level_page = 1;
            $temp_link = '';
            foreach ($_this->CI->data['breadcrumb'] as $page) {
                // Check if index breadcrumb array exists
                if (array_key_exists($page, $array_page)) {
                    // Check if link exists
                    $full_url = '';
                    if (@$array_page[$page]['link'] != '') {
                        if ($level_page == 1) {
                            $full_url = $temp_link = site_url($_this->CI->user->active_user . '/' . $array_page[$page]['link']);
                        } elseif ($level_page != 1 && $temp_link != '') {
                            $full_url = $temp_link = $temp_link . '/' . $array_page[$page]['link'];
                        }
                    }
                    if ($full_url == '') {
                        $temp_link = '';
                        $full_url = current_url();
                    }

                    $breadcrumb[] = [
                        'link' => $full_url,
                        'icon' => (@$array_page[$page]['icon'] != '')? $array_page[$page]['icon'] : '<i class="fa fa-circle-o"></i>',
                        'color' => (@$array_page[$page]['color'] != '')? $array_page[$page]['color'] : 'text-muted',
                        'style' => @$option['style'],
                        'title' => (@$array_page[$page]['title'] != '')? $array_page[$page]['title'] : 'Halaman Web',
                    ];

                    $level_page++;
                }
            }
        }

        return $breadcrumb;
    }
}

if (! function_exists('create_menu')) {
    function create_menu($menu_list, $level_menu = 1)
    {

        $html_menu = '';
        foreach ($menu_list as $key) {

            $html_sub_menu = $treeview_class = $add = '';
            
            // Check what level menu
            if ($level_menu != 1) {
                $key->icon_menu = 'fa fa-circle-o';
                $key->color_menu = '';

                if (count($key->sub_menu) > 0) {
                    $len = 30 - $level_menu;
                    $len_sub = 25 - $level_menu;
                } else {
                    $len = 32 - $level_menu;
                    $len_sub = 30 - $level_menu;
                }
                

                if (strlen($key->nm_menu) > $len) {
                    $key->nm_menu = substr($key->nm_menu, 0, $len_sub).'...';
                }

                $nm_menu = $key->nm_menu;
            } else {
                $nm_menu = '<span style="color: ' . $key->color_menu . '">' . $key->nm_menu . '</span>';
            }
            

            // Get status menu
            if ($key->status_access_menu == 'develop') {
                $menu_attr = array('text' => 'Soon', 'color' => 'bg-green');
            } elseif ($key->status_access_menu == 'beta') {
                $menu_attr = array('text' => 'BETA', 'color' => 'bg-blue');
            } elseif ($key->status_access_menu == 'repair') {
                $menu_attr = array('text' => 'Repair', 'color' => 'bg-red');
            }
    
            // Check if menu have sub menu
            if ($key->status_access_menu != 'active' && isset($menu_attr)) {
                $add = 
                '<span class="pull-right-container">
                    <small class="label pull-right ' . $menu_attr['color'] . '">' . $menu_attr['text'] . '</small>
                </span>';
            } elseif (count($key->sub_menu) > 0) {
                $add = 
                '<span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>';

                //Create sub menu
                $sub_menu = create_menu($key->sub_menu, $level_menu + 1);
                $treeview_class = 'treeview';
                $html_sub_menu =
                '<ul class="treeview-menu">
                    ' . $sub_menu . '
                </ul>';
            }
    
            $menu = 
            '<li class="' . active_page($key->sort_link, 'active') . ' ' . @$treeview_class . '">
                <a href="' . $key->link_menu . '">
                    <i class="' . $key->icon_menu . '" style="color: ' . $key->color_menu . '"></i>
                    ' . @$nm_menu . '
                    ' . @$add . '
                </a>
                ' . @$html_sub_menu . '
            </li>';

            $html_menu .= $menu;
            
        }

        return $html_menu;
    }
}