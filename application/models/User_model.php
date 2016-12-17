<?php 
	class User_model extends CI_Model{
		public function __construct(){}

		public function register($data){
			$this->db->insert('users',$data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}
?>