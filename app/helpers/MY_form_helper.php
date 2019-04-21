<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Form Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/form_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('form_multiselect'))
{
	/**
	 * Multi-select menu
	 *
	 * @param	string
	 * @param	array
	 * @param	mixed
	 * @param	mixed
	 * @return	string
	 */
	function form_multiselect($name = '', $options = array(), $selected = array(), $extra = '', $opt_extra = '')
	{
		$extra = _attributes_to_string($extra);
		$opt_extra = _attributes_to_string($opt_extra);

		if (stripos($extra, 'multiple') === FALSE)
		{
			$extra .= ' multiple="multiple"';
		}

		return form_dropdown($name, $options, $selected, $extra, $opt_extra);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('form_dropdown'))
{
	/**
	 * Drop-down Menu
	 *
	 * @param	mixed	$data
	 * @param	mixed	$options
	 * @param	mixed	$selected
	 * @param	mixed	$extra
	 * @return	string
	 */
	function form_dropdown($data = '', $options = array(), $selected = array(), $extra = '', $opt_extra = '')
	{
		$defaults = array();

		if (is_array($data))
		{
			if (isset($data['selected']))
			{
				$selected = $data['selected'];
				unset($data['selected']); // select tags don't have a selected attribute
			}

			if (isset($data['options']))
			{
				$options = $data['options'];
				unset($data['options']); // select tags don't use an options attribute
			}
		}
		else
		{
			$defaults = array('name' => $data);
		}

		is_array($selected) OR $selected = array($selected);
		is_array($options) OR $options = array($options);

		// If no selected state was submitted we will attempt to set it automatically
		if (empty($selected))
		{
			if (is_array($data))
			{
				if (isset($data['name'], $_POST[$data['name']]))
				{
					$selected = array($_POST[$data['name']]);
				}
			}
			elseif (isset($_POST[$data]))
			{
				$selected = array($_POST[$data]);
			}
		}

		$extra = _attributes_to_string($extra);
		$opt_extra = _attributes_to_string($opt_extra);

		$multiple = (count($selected) > 1 && stripos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select '.rtrim(_parse_form_attributes($data, $defaults)).$extra.$multiple.">\n";

		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val))
			{
				if (empty($val))
				{
					continue;
				}

				$form .= '<optgroup label="'.$key."\">\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = in_array($optgroup_key, $selected) ? ' selected="selected"' : '';
					$form .= '<option value="'.html_escape($optgroup_key).'"'.$sel.'>'
						.(string) $optgroup_val."</option>\n";
				}

				$form .= "</optgroup>\n";
			}
			else
			{
				$form .= '<option value="'.html_escape($key).'"'
					.(in_array($key, $selected) ? ' selected="selected"' : '')
					.(string) ((strlen($opt_extra) > 0) ? $opt_extra : '') . '>'
					.(string) $val."</option>\n";
			}
		}

		return $form."</select>\n";
	}
}

// --------------------------------------------------------------------

function dinamyc_dropdown($config=array())
{
	$arr = array();

	if (! is_array($config)) {
		show_error('Parameter pertama harus bertipe array.');
	}

	if (isset($config['empty_first']) && $config['empty_first'] == TRUE) {
		$arr[null] = '[ Pilih ]';
		if (isset($config['empty_first_label']) && ! empty($config['empty_first_label']))
			$arr[null] = $config['empty_first_label'];
	}

	if (isset($config['where'])) {
		_get_instance()->db->where($config['where']);
	}

	if ( isset($config['order_by']) ) {
		_get_instance()->db->order_by($config['order_by']);
	}

	if ( isset($config['group_by']) ) {
		_get_instance()->db->group_by($config['group_by']);
	}

	$attr = ( isset($config['attr']) ) ? $config['attr'] : '';
	$opt_attr = ( isset($config['opt_attr']) ) ? $config['opt_attr'] : '';

	$query = _get_instance()->db->get($config['table']);
	if ($query->num_rows() > 0 OR count($arr) > 0) {
		foreach ($query->result() as $row) {
			if ( is_array($config['label']) ) {
				// separator
				$separator = ' - ';

				if ( isset($config['separator']) ) $separator = $config['separator'];

				foreach ($config['label'] as $key => $label) {
					if ( $key == 0 ) {
						// this is the first label on array of labels
						$labels = $row->$label;
					}
					else {
						$labels .= $separator . $row->$label;
					}
				}
			} else {
				$labels = $row->{$config['label']};
			}

			$arr[$row->{$config['key']}] = $labels;
		}

		$html = form_dropdown($config['name'], $arr, $config['default'], $attr, $opt_attr);

		return $html;
	}

	return FALSE;
}

// --------------------------------------------------------------------

function dinamyc_multiselect($config=array())
{
	if (! is_array($config))
		show_error('Parameter pertama harus bertipe array.');

	if (isset($config['empty_first']) && $config['empty_first'] == TRUE) {
		$arr[null] = '[ Pilih ]';
		if (isset($config['empty_first_label']) && ! empty($config['empty_first_label'])) {
			$arr[null] = $config['empty_first_label'];
		}
	}

	if (isset($config['where'])) {
		_get_instance()->db->where($config['where']);
	}

	if ( isset($config['order_by']) ) {
		_get_instance()->db->order_by($config['order_by']);
	}

	$attr = ( isset($config['attr']) ) ? $config['attr'] : '';
	$opt_attr = ( isset($config['opt_attr']) ) ? $config['opt_attr'] : '';

	$query = _get_instance()->db->get($config['table']);
	if ($query->num_rows() > 0 OR count($arr) > 0) {
		foreach ($query->result() as $row) {
			if ( is_array($config['label']) ) {
				// separator
				$separator = ' - ';

				if ( isset($config['separator']) ) $separator = $config['separator'];

				foreach ($config['label'] as $key => $label) {
					if ( $key == 0 ) {
						// this is the first label on array of labels
						$labels = $row->$label;
					}
					else {
						$labels .= $separator . $row->$label;
					}
				}
			} else {
				$labels = $row->{$config['label']};
			}

			$arr[$row->{$config['key']}] = $labels;
		}

		$html = form_multiselect($config['name'], $arr, $config['default'], $attr, $opt_attr);

		return $html;
	}

	return FALSE;
}

// --------------------------------------------------------------------

function form_radio_group($name, $data=array(), $default='')
{
	if (! is_array($data)) die(show_error('The second parameter of form_radio_group function must be an array.'));

	$html = '';
	foreach ($data as $key => $value) {
		if ($key == $default) {
			$html .= '<div class="radio"><label>'.form_radio($name, $key, TRUE).' '.$value.'</label></div>';
		}
		else {
			$html .= '<div class="radio"><label>'.form_radio($name, $key, FALSE).' '.$value.'</label></div>';
		}
	}

	return $html;
}

// --------------------------------------------------------------------

function form_checkbox_group($array)
{
	if ( ! is_array($array) ) throw new Exception('Parameter pertama harus beripe array.');

	$html = NULL;

	$attr = '';
	if (isset($array['attr'])) $attr = $array['attr'];

	$html .= '<ul '.$attr.'>';

	foreach ($array['list'] as $key => $item) {
		$attr = '';
		if (isset($item['attr'])) $attr = $item['attr'];

		$checked = $array['checked'];

		$html .= '<li class="item">';

		if (in_array($item['value'], $checked)) {
			$html .= form_checkbox($array['name'].'[]', $item['value'], TRUE, $attr).' '.form_label($item['label']);
		} else {
			$html .= form_checkbox($array['name'].'[]', $item['value'], FALSE, $attr).' '.form_label($item['label']);
		}

		$html .= '</li>';
	}

	$html .= '</ul>';

	return $html;
}

// --------------------------------------------------------------------

// didnamyc checkbox group
function dinamyc_checkbox_group($array)
{
	$html = NULL;

	$attr = '';
	if (isset($array['attr'])) $attr = $array['attr'];

	$html .= '<ul '.$attr.'>';

	foreach ($list as $key => $item) {
		$attr = '';
		if (isset($item['attr'])) $attr = $item['attr'];

		$checked = explode(',', $array['checked']);

		$html .= '<li class="item">';

		if (in_array($item['value'], $checked)) {
			$html .= form_checkbox($array['name'].'[]', $item['value'], TRUE, $attr).' '.form_label($item['label']);
		} else {
			$html .= form_checkbox($array['name'].'[]', $item['value'], FALSE, $attr).' '.form_label($item['label']);
		}

		$html .= '</li>';
	}

	$html .= '</ul>';

	return $html;
}

// --------------------------------------------------------------------

function dropdownKelurahan($config)
{

	if (! is_array($config))
		show_error('Parameter pertama harus bertipe array.');

	if (isset($config['empty_first']) && $config['empty_first'] == TRUE) {
		$options[null] = '[ Pilih ]';
		if (isset($config['empty_first_label']) && ! empty($config['empty_first_label'])) {
			$options[null] = $config['empty_first_label'];
		}
	}

	$attr = ( isset($config['attr']) ) ? $config['attr'] : '';

	_get_instance()->db
	               ->select('kelurahan.id, kelurahan.kelurahan, kelurahan.kecamatan_id, kecamatan.kecamatan')
                   ->join('kecamatan', 'kecamatan.id = kelurahan.kecamatan_id')
                   ->order_by('kecamatan.kecamatan ASC, kelurahan.kelurahan ASC');
	$query = _get_instance()->db->get('kelurahan');

	if ( $query->num_rows() > 0 ) {

		$kec_tmp = '';

		foreach ( $query->result() as $row ) {

			if ( $kec_tmp != $row->kecamatan ) {

				$kec_tmp = 'Kec. ' . $row->kecamatan;

			}

			$options[$kec_tmp][$row->id] = $row->kelurahan;

		}

	}

	$html = form_dropdown($config['name'], $options, $config['default'], $attr);

	return $html;

}

// --------------------------------------------------------------------

function _get_instance()
{
	$CI =& get_instance();
	return $CI;
}

// --------------------------------------------------------------------