<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{
	function login_auth($username, $password){
		$this->db->select('username,email');
		$this->db->from('m_user');
		$this->db->group_start();
			$this->db->where('username',$username);
			$this->db->or_where('email',$username);
		$this->db->group_end();
		$this->db->where('password',$password);
		$this->db->where('activated',1);
		$this->db->limit(1);
		$query=$this->db->get();
		if ($this->db->affected_rows()==1) {
			return $query->result();
		}else{
			return false;
		}
	}
}