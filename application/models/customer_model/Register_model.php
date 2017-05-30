<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model{
	function insert_user($data=array()){
		$this->db->insert('m_user',$data);
		$retVal = ($this->db->affected_rows()!=0) ? true : false ;
   		return $retVal;
	}

	function cek_activation($username){
		return $this->db->from('m_user')
		        		->where('username',$username)
		 				->get()->row('activated');
	}
	
	function activate_account($username){
		$data['activated']=1;
		$this->db->where('username', $username);
  		$this->db->update('m_user', $data);
  		$retVal = ($this->db->affected_rows()!=0) ? true : false ;
     	return $retVal;
	}
}