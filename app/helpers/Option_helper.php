<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('list_fields')) {
    function list_fields($tables, $other_field=NULL){
        $_this =& get_instance();
        $list_fields = array();
        foreach ($tables as $key) {
            $table_fields = $_this->db->list_fields($key);

            $fields_prefix = [];
            foreach ($table_fields as $field) {
                $fields_prefix[] = $key . '.' . $field;
            }
            
            $list_fields = array_merge($fields_prefix, $list_fields);
        }

        if ($other_field != NULL) {
            $list_fields = array_merge($list_fields,$other_field);
        }
        return $list_fields;
    }
}

if (! function_exists('rand_val')) {
    function rand_val($num = 20)
    {
	    $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	    $len = strlen($string)-1;
        $pass = '';
        
	    for ($i=1; $i <= $num ; $i++) { 
	      $start = rand(0,$len);
	      $pass .= $string{$start};
        }
        
	    return $pass;
    }
}

if (! function_exists('date_convert')) {
    function date_convert($tgl = NULL, $separator = NULL)
    {
        if ($tgl != NULL && $tgl != '') {
            if($separator != NULL && $separator != '') {
                $var = explode($separator, $tgl);
            } else {
                $var = explode('-',$tgl);
            }

            $day = $var[2];
            $month = $var[1];
            $year = $var[0];
            $array_month = [
                '00' => '00',
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ];

            return $day.' '.$array_month[$month].' '.$year;
        } else {
            return "-";
        }
    }
}

if (! function_exists('color_pd_static')) {
    function color_static($no){
        $array_color = [
            '0' => '#3c8dbc',
            '1' => '#00c0ef',
            '2' => '#00a65a',
            '3' => '#f39c12',
            '4' => '#f56954',
            '5' => '#ff7701',
            '6' => '#001F3F',
            '7' => '#39CCCC',
            '8' => '#605ca8',
            '9' => '#ff851b',
            '10' => '#D81B60',
            '11' => '#111111',
            '12' => '#357ca5',
            '13' => '#00a7d0',
            '14' => '#008d4c',
            '15' => '#db8b0b',
            '16' => '#d33724',
            '17' => '#555299',
        ];

        if (array_key_exists($no, $array_color)) {
            return $array_color[$no];
        } else {
            $_this =& get_instance();
            $_this->load->helper('color_helper');
            return getColor('border');
        }
    }
}

if (! function_exists('create_script')) {
    function create_script($links = NULL, $attr = NULL){
        $script = '';
        if ($links && is_array($links) && count($links) > 0) {
            foreach ($links as $link) {
                $script .= '<script src="' . $link . '" ' . $attr . '></script>';
            }
        } elseif ($links && $links != '') {
            $script = '<script src="' . $links . '" ' . $attr . '></script>';
        }
        
        return $script;
    }
}