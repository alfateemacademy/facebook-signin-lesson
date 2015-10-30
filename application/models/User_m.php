<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model {

	protected $tableName = 'users';

	public function create(array $data)
	{
		$row = $this->getUserByUid($data['uid']);

		if(!$row)
		{
			$this->db->insert($this->tableName, $data);
			return $this->db->insert_id();
		}

		return $row;
	}

	public function getUserByUid($uid)
	{
		$this->db->where('uid', $data['uid']);
		$row = $this->db->get($this->tableName)->row_array();

		return $row;
	}
}

/* End of file user_m.php */
/* Location: ./application/models/user_m.php */