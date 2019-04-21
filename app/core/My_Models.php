<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Models extends CI_Model
{
	protected $_table_name;
	protected $_order_by;
	protected $_order_by_type;
	protected $_primary_filter = 'intval';
	protected $_primary_key;
	protected $_type;
    public $rules;

    protected $_failed_db_op = 'Ada masalah pada operasi database';
    
    protected $CI;

    function __construct()
    {
        parent:: __construct();
        
        $this->CI =& get_instance()->controller;
        
	}

    public function insert($data, $batch = FALSE)
    {
		$id = NULL;
		if ($batch == TRUE) {
			$id = $this->db->insert_batch('{PRE}' . $this->_table_name,$data);			
		} else {			
			$this->db->insert('{PRE}' . $this->_table_name,$data);
			$id = $this->db->insert_id();
        }
        
        if ($id) {
            $result = [
                'status' => 'success',
                'id' => $id
            ];
        } else {
            $result = [
                'status' => 'failed_db',
                'message' => $this->_failed_db_op
            ];
        }
        
		return @$result;
	}

    public function update($obj = array())
    {
        // Check data and add some information to data
        if (isset($obj['data']) && is_array($obj['data'])) {
            $obj['data'] += [
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

		if (isset($obj['qry']) && $obj['qry'] != NULL) {
			$this->get_dt_detail($obj['qry']);
		}
        
		if (isset($obj['batch']) && $obj['batch'] == TRUE) {
			$update = $this->db->update_batch('{PRE}' . $this->_table_name, $obj['data'], $obj['where']);
		} else {
			$this->db->set($obj['data']);
			$this->db->where($obj['where']);
			$update = $this->db->update('{PRE}' . $this->_table_name);
		}

		$affected_rows = $this->db->affected_rows();
		if ($affected_rows > 0) {
			return $result = [
                'status' => 'success'
            ];
		} else {
			return $result = [
                'status' => 'failed_db',
                'message' => $this->_failed_db_op
            ];
		}
    }
    
    public function delete($id = NULL, $where = NULL)
    {
		if ($id && !is_array($id)) {
			$filter = $this->_primary_filter;
			$id = $filter($id);
			if (!$id) {
				return FALSE;
			}
			$this->db->where($this->_primary_key, $id);
        } elseif (is_array($id)) {
            $this->db->where_in($this->_primary_key, $id);
        }
        
        if ($where) {
			$this->db->where($where);
		}

		$delete = $this->db->delete('{PRE}'.$this->_table_name);
		$affected_rows = $this->db->affected_rows();
		if ($affected_rows > 0) {
			return $result = [
                'status' => 'success',
                'id' => $id
            ];
		} else {
			return $result = [
                'status' => 'failed_db',
                'message' => $this->_failed_db_op
            ];
		}
    }
	
    public function get($obj = array())
    {
        /*
        obj[
            'id',
            'single',
            'order',
            'qry',
            'select',
            'where',
            'group',
            'join'
        ]
        */
        
        // Set method
		if (isset($obj['id'])) {
			$filter = $this->_primary_filter;
			$id = $filter($obj['id']);
			$this->db->where($this->_primary_key,$id);
			$method ='row';
		} elseif (isset($obj['single']) && $obj['single'] == TRUE) {
			$method = 'row';
		} else {
			$method = 'result';
		}

        // Set order
        if (!isset($obj['order'])) {
			if ($this->_order_by_type) {
				$this->db->order_by($this->_order_by, $this->_order_by_type);			
			} else{
				$this->db->order_by($this->_order_by);
			}
		} else {
			$this->db->order_by($obj['order']);
		}

        if (isset($obj['qry']) && $obj['qry'] != NULL) {
			$this->get_dt_detail($obj['qry']);
		}

        // Set selecting field
        if (isset($obj['select']) && $obj['select'] != NULL) {
			$this->db->select($obj['select']);
		}
        // Set default where clause
        if (isset($obj['where'])) {
			$this->db->where($obj['where']);
        }
        // Set default group clause
		if (isset($obj['group'])) {
			$this->db->group_by($obj['group']);
        }

        // Set join table
        if (isset($obj['join'])) {
            $this->_join_table($obj['join']);
        }
        
        // Set table
        if (isset($this->_view) && $this->_view != NULL) {
            $look = '{PRE}'.$this->_view;
        } else {
            $look = '{PRE}'.$this->_table_name;
        }

		return $this->db->get($look)->$method();
	}

    public function count($where=NULL, $group=NULL, $act=NULL)
    {
		if ($act != NULL) {
			$this->get_dt_detail($act);
		}

		if (!empty($this->_type)) {
			$where['post_type'] = $this->_type;
        }
        
		if ($where) {
			$this->db->where($where);
		}
        
        if ($group) {
			$this->db->group_by($group);
        }
        
		$this->db->from('{PRE}'.$this->_table_name);
		return $this->db->count_all_results();
	}

    protected function get_dt_detail($act)
    {
		if ($act != NULL) {
			if (@$act[0] == NULL) {
				foreach ($act as $action => $val_act) {
					if ($action == 'sum') {
						foreach ($val_act as $field => $alias) {
							$this->db->select_sum($field,$alias);
						}
					}
					if ($action == 'where') {
						$this->db->where($val_act);
					}
					if ($action == 'or_where') {
						$this->db->or_where($val_act);
					}
					if ($action == 'like') {
						foreach ($val_act as $field => $value) {
							$this->db->like($field,$value);
						}
					}
					if ($action == 'or_like') {
						foreach ($val_act as $field => $value) {
							$this->db->or_like($field,$value);
						}
					}
					if ($action == 'in') {
						foreach ($val_act as $field => $value) {
							$this->db->where_in($field, $value);
						}
					}
					if ($action == 'or_in') {
						foreach ($val_act as $field => $value) {
							$this->db->or_where_in($field, $value);
						}
					}
					if ($action == 'not_in') {
						foreach ($val_act as $field => $value) {
							$this->db->where_not_in($field, $value);
						}
					}
					if ($action == 'or_not_in') {
						foreach ($val_act as $field => $value) {
							$this->db->or_where_not_in($field, $value);
						}
					}
					if ($action == 'limit') {
						$this->db->limit($val_act);
					}
					if ($action == 'offset') {
						$this->db->limit($val_act[0],$val_act[1]);
					}
				}
			} else {
				foreach ($act as $act_no) {
					foreach ($act_no as $action => $val_act) {
						if ($action == 'sum') {
							foreach ($val_act as $field => $alias) {
								$this->db->select_sum($field,$alias);
							}
						}
						if ($action == 'where') {
							$this->db->where($val_act);
						}
						if ($action == 'or_where') {
							$this->db->or_where($val_act);
						}
						if ($action == 'like') {
							foreach ($val_act as $field => $value) {
								$this->db->like($field,$value);
							}
						}
						if ($action == 'or_like') {
							foreach ($val_act as $field => $value) {
								$this->db->or_like($field,$value);
							}
						}
						if ($action == 'in') {
							foreach ($val_act as $field => $value) {
								$this->db->where_in($field, $value);
							}
						}
						if ($action == 'or_in') {
							foreach ($val_act as $field => $value) {
								$this->db->or_where_in($field, $value);
							}
						}
						if ($action == 'not_in') {
							foreach ($val_act as $field => $value) {
								$this->db->where_not_in($field, $value);
							}
						}
						if ($action == 'or_not_in') {
							foreach ($val_act as $field => $value) {
								$this->db->or_where_not_in($field, $value);
							}
						}
						if ($action == 'limit') {
							$this->db->limit($val_act);
						}
						if ($action == 'offset') {
							$this->db->limit($val_act[0],$val_act[1]);
						}
					}
				}
			}
		}
    }

}

/* End of file My_Models.php */
/* Location: ./app/core/My_Models.php */