<?php 
	class User_model extends CI_Model{
		public function __construct(){}

		public function login($data){
			$query = $this->db->get_where('users',array('email' => $data->email, 'password'=>$data->password));
			if($query->num_rows()===1)
				return $query->result()[0];
			else
				return null;
		}

		public function register($data){
			$this->db->insert('users',$data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}

		public function get_by_email($email){
			$query = $this->db->get_where('users',array('email' => $email));
			if($query->num_rows()===1)
				return $query->result()[0];
			else
				return null;
		}

		public function get_by_phone($phone){
			$query = $this->db->get_where('users',array('phone' => $phone));
			if($query->num_rows()===1)
				return $query->result()[0];
			else
				return null;
		}

		public function get_by_national_id($national_id){
			$query = $this->db->get_where('users',array('national_id' => intval($national_id)));
			if($query->num_rows()===1)
				return $query->result()[0];
			else
				return null;
		}

		public function get_data($data){
			$query = $this->db->get_where('users',array('id' => intval($data->user_id)));
			if($query->num_rows()===1)
				return $query->result()[0];
			else
				return null;
		}

		public function get_car_details($data){
			$query = $this->db->get_where('driver_car',array('user_id' => intval($data->user_id)));
			if($query->num_rows()===1)
				return $query->result()[0];
			else
				return null;
		}

		public function add_car($data){
			$this->db->insert('driver_car',$data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}
?>