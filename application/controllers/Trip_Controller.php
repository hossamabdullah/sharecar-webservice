<?php 
	class Trip_Controller extends CI_Controller{
		public function __construct(){
			parent::__construct();
		}

		//FIXME
		private function get_user($id){
			$data=(object)array('user_id'=>$id);
			$user = $this->user_model->get_data($data);
			if($user==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('user_id_not_exists'),
				null);
				return null;
			}else{
				return $user;
			}
		}
		private function check_start_time($data){
			$trips = $this->trip_model->check_start_time($data);
			if($trips!=null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('invalid_start_time'),
				null);
				return $trips;
			}else{
				return null;
			}
		}

		public function registerTrip(){
			$data = (object)array(
				'driver_id'=>$this->input->post('driver_id'),
				'start_time'=>$this->input->post('start_time'),
				'allowed_chairs'=>$this->input->post('allowed_chairs'),
				'start_point_id'=>$this->input->post('start_point_id'),
				'end_point_id'=>$this->input->post('end_point_id'),
				'road_id'=>$this->input->post('road_id')
			);

			if(check_missing_parameters($data)==1) return;
			if($this->get_user($data->driver_id)==null) return;
			if($this->check_start_time($data)!=null) return;

			$trip_id = $this->trip_model->register($data);
			$response_data = new stdClass;
			$response_data->trip_id = $trip_id;
			echo form_response(
				$this->lang->line('success'),
				$this->lang->line('successful_trip_registration'),
				$response_data);
		}
		
		
		
	}
?>