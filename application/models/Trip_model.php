<?php 
	class Trip_model extends CI_Model{
		public function __construct(){}

		public function register($data){
			$this->db->insert('fixed_trips',$data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}

		public function check_start_time($data){
			$start_range = new DateTime($data->start_time);
			$start_range->sub(new DateInterval('PT2H'));
			$end_range = new DateTime($data->start_time);
			$end_range->add(new DateInterval('PT2H'));
			$query = $this->db->get_where('fixed_trips',array('start_time >=' => $start_range->format('Y-m-d H:i:s'), 
															'start_time<=' => $end_range->format('Y-m-d H:i:s')));
			if($query->num_rows()===1)
				return $query->result()[0];
			else
				return null;
		}
	}
?>