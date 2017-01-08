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

		public function get_user_trips(){
			$data = (object)array(
				'driver_id'=>$this->input->post('driver_id')
			);

			if(check_missing_parameters($data)==1) return;
			if($this->get_user($data->driver_id)==null) return;

			$trips = $this->trip_model->get_user_trips($data);
			if($trips==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_trips_found'),
				null);
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('trips_found'),
				$trips);
			}
		}


		public function get_areas(){
			$areas = $this->trip_model->get_areas();
			if($areas==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_areas_found'),
				null);
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('areas_found'),
				$areas);
			}
		}

		public function get_points_of_area(){
			$data = (object)array(
				'area_id'=>$this->input->post('area_id')
			);

			if(check_missing_parameters($data)==1) return;

			$points = $this->trip_model->get_points_of_area($data);
			if($points==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_points_found'),
				null);
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('points_found'),
				$points);
			}
		}

		public function get_roads(){
			$roads = $this->trip_model->get_roads();
			if($roads==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_roads_found'),
				null);
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('roads_found'),
				$roads);
			}
		}

		////////////////////////////
		////Search Services////////
		///////////////////////////
		public function get_all_active_trips(){
			$trips = $this->trip_model->get_all_active_trips();
			if($trips==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_active_trips_found'),
				null);
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('active_trips_found'),
				$trips);
			}
		}

		public function get_point(){
			$data = (object)array(
				'id'=>$this->input->post('point_id')
			);

			if(check_missing_parameters($data)==1) return;

			$points = $this->trip_model->get_point($data);
			if($points==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_points_found'),
				null);
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('points_found'),
				$points);
			}
		}

		public function get_area(){
			$data = (object)array(
				'id'=>$this->input->post('area_id')
			);

			if(check_missing_parameters($data)==1) return;

			$areas = $this->trip_model->get_area($data);
			if($areas==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_areas_found'),
				null);
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('areas_found'),
				$areas);
			}
		}

		public function get_road(){
			$data = (object)array(
				'id'=>$this->input->post('road_id')
			);

			if(check_missing_parameters($data)==1) return;

			$road_id = $this->trip_model->get_road($data);
			if($road_id==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_roads_found'),
				null);
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('roads_found'),
				$road_id);
			}
		}

		public function get_active_start_end_areas(){
			$data = $this->trip_model->get_active_start_end_areas();
			if($data==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_trips_found'),
				null);
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('trips_found'),
				$data);
			}
		}

		public function search_active_trip_by_points(){
			$data = (object)array(
				'start_point_id'=>$this->input->post('start_point_id'),
				'end_point_id'=>$this->input->post('end_point_id')
			);

			if(check_missing_parameters($data)==1) return;

			$trips = $this->trip_model->search_active_trip_by_points($data);
			if($trips==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_trips_found'),
				null);
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('trips_found'),
				$trips);
			}
		}

		public function search_active_trip_by_areas(){
			$data = (object)array(
				'start_area_id'=>$this->input->post('start_area_id'),
				'end_area_id'=>$this->input->post('end_area_id')
			);

			if(check_missing_parameters($data)==1) return;

			$trips = $this->trip_model->search_active_trip_by_areas($data);
			if($trips==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_trips_found'),
				null);
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('trips_found'),
				$trips);
			}
		}

		private function is_trip_exist($data){
			$trip = $this->trip_model->get_trip($data);
			if($trip==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('no_trips_found'),
				null);
			}else{
				return $trip;
			}
		}

		public function get_trip(){
			$data = (object)array(
				'trip_id'=>$this->input->post('trip_id')
			);

			if(check_missing_parameters($data)==1) return;
			$trip = $this->is_trip_exist($data);
			if($trip==null){
				return;
			}else{
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('trips_found'),
				$trip);
			}
		}

		public function join_trip(){
			$data = (object)array(
				'trip_id'=>$this->input->post('trip_id'),
				'user_id'=>$this->input->post('user_id')
			);

			if(check_missing_parameters($data)==1) return;
			if($this->get_user($data->user_id)==null) return;
			if($this->is_trip_exist($data)==null) return;

			$this->trip_model->add_user_to_trip($data);
			echo form_response(
				$this->lang->line('success'),
				$this->lang->line('rider_added_successfully'),
				null);
		}

		public function start_trip(){
			$data = (object)array(
				'trip_id'=>$this->input->post('trip_id'),
				'actual_start_time'=>$this->input->post('actual_start_time')
			);

			if(check_missing_parameters($data)==1) return;
			$trip = $this->trip_starting_validator($data);
			if($trip==null) return;

			$this->trip_model->start_trip($data);
			$response_data = $this->create_response_of_start_trip($trip->start_time, $data->actual_start_time);

			echo form_response(
				$this->lang->line('success'),
				$this->lang->line('trip_started_successfully'),
				$response_data);
		}

		private function create_response_of_start_trip($expected_start_time, $actual_start_time){
			$date_diff = date_diff(date_create($actual_start_time),
									date_create($expected_start_time));
			$response_data = new stdClass;
			$response_data->years=$date_diff->y;
		    $response_data->months=$date_diff->m;	
		    $response_data->days=$date_diff->d;
		    $response_data->hours=$date_diff->h;
		    $response_data->minutes=$date_diff->i;
		    $response_data->seconds=$date_diff->s;
		    return $response_data;
		}

		public function end_driver_trip(){
			$data = (object)array(
				'trip_id'=>$this->input->post('trip_id'),
				'end_time'=>$this->input->post('end_time')
			);

			if(check_missing_parameters($data)==1) return;
			$trip=$this->trip_ending_validator($data);
			if($trip ===null) return;

			$this->cal_data($data,$trip);
			$this->trip_model->end_driver_trip($data);
			$this->trip_model->finish_trip($data);

			echo form_response(
				$this->lang->line('success'),
				$this->lang->line('driver_trip_finished'),
				null);
		}

		public function end_user_trip(){
			$data = (object)array(
				'user_id'=>$this->input->post('user_id'),
				'trip_id'=>$this->input->post('trip_id'),
				'end_time'=>$this->input->post('end_time')
			);

			if(check_missing_parameters($data)==1) return;
			if($this->get_user($data->user_id)==null) return;
			$trip=$this->trip_ending_validator($data);
			if($trip==null) return;
			$trip_rider = $this->trip_rider_validator($data);
			if($trip_rider===null) return;

			$this->cal_data($data,$trip);			
			$this->trip_model->end_user_trip($data);

			echo form_response(
				$this->lang->line('success'),
				$this->lang->line('driver_trip_finished'),
				null);
		}

		private function trip_starting_validator($data){
			$trip = $this->is_trip_exist($data);
			if($trip==null) return null;
			if($trip->actual_start_time!=null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('trip_already_started'),
				null);
				return null;
			}
			if($trip->status_id==2){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('start_ended_trip'),
				null);
				return null;
			}
			return $trip;
		}

		private function trip_ending_validator($data){
			$trip = $this->is_trip_exist($data);
			if($trip==null) return null;
			if($trip->actual_start_time==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('end_not_started_trip'),
				null);
				return null;
			}
			if($trip->status_id==2){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('end_ended_trip'),
				null);
				return null;
			}
			return $trip;
		}

		private function trip_rider_validator($data){
			$trip_rider = $this->is_user_in_trip($data);
			if($trip_rider==null) return null;
			if($trip_rider->cost !== null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('user_already_ended_trip'),
				null);
				return null;
			}
			return $trip_rider;
		}

		private function is_user_in_trip($data){
			$trip_rider = $this->trip_model->get_trip_rider($data);
			if($trip_rider == null){
				echo form_response(
				$this->lang->line('success'),
				$this->lang->line('user_not_in_trip'),
				null);
				return null;
			}else{
				return $trip_rider;
			}
		}

		private function cal_data($data,$trip){
			$data->start_time = $trip->start_time;
			$data->end_point_id = $trip->end_point_id;
			$data->distance=$this->cal_distance($data);
			$data->cost = $this->cal_cost($data);
		}

		private function cal_distance($data){
			/////Make Some Code
			return 12;
		}

		private function cal_cost($data){
			//////Make Some Code
			return 13;
		}
	}
?>