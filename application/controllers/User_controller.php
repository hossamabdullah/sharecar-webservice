<?php 
	class User_controller extends CI_Controller{
		public function __construct(){
			parent::__construct();
		}

		private function is_email_exist(){
			if($this->user_model->get_by_email($this->input->post('email'))!= null){
				echo form_response(
					$this->lang->line('fail'),
					$this->lang->line('email_exists'),
					null);
				return 1;		
			}else{
				return 0;
			}
		}
		private function is_phone_exist(){
			if($this->user_model->get_by_phone($this->input->post('phone'))!= null){
				echo form_response(
					$this->lang->line('fail'),
					$this->lang->line('phone_exists'),
					null);
				return 1;
			}else{
				return 0;
			}
		}
		private function is_national_id_exist(){
			if($this->user_model->get_by_national_id($this->input->post('national_id'))!= null){
				echo form_response(
					$this->lang->line('fail'),
					$this->lang->line('national_id_exists'),
					null);
				return 1;
			}else{
				return 0;
			}
		}
		private function is_user_has_car($data){
			if($this->user_model->get_car_details($data)!=null){
				echo form_response(
					$this->lang->line('fail'),
					$this->lang->line('car_exists'),
					null);
				return 1;
			}else{
				return 0;
			}
		}
		private function get_user($data){
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
		private function get_car($data){
			$car = $this->user_model->get_car_details($data);
			if($car==null){
				echo form_response(
				$this->lang->line('fail'),
				$this->lang->line('car_not_exists'),
				null);
				return null;
			}else{
				return $car;
			}
		}


		public function is_valid_email(){
			if(is_email_exist()==0)
				echo form_response(
					$this->lang->line('success'),
					$this->lang->line('email_not_exists'),
					null);
		}
		public function is_valid_phone(){
			if(is_phone_exist()==0){
				echo form_response(
					$this->lang->line('success'),
					$this->lang->line('phone_not_exists'),
					null);
			}
		}
		public function is_valid_national_id(){
			if(is_national_id_exist()==0){
				echo form_response(
					$this->lang->line('success'),
					$this->lang->line('national_id_not_exists'),
					null);
			}
		}

		public function register(){
			$data = (object)array(
				'name'=>$this->input->post('name'),
				'email'=>$this->input->post('email'),
				'password'=>$this->input->post('password'),
				'user_type_id'=>$this->input->post('user_type'),
				'phone'=>$this->input->post('phone'),
				'visa_card_num'=>$this->input->post('visa_card_num'),
				'visa_card_last_4_digits'=>$this->input->post('visa_card_last_4_digits'),	
				'visa_card_expire_date'=>$this->input->post('visa_card_expire_date'),
				'national_id'=>$this->input->post('national_id'),
				'profile_picture_url'=>$this->input->post('profile_picture_url'),
				'linkedin_profile_url'=>$this->input->post('linkedin_profile_url'),
				'position'=>$this->input->post('position'),
				'company'=>$this->input->post('company'),
				'birthdate'=>$this->input->post('birthdate'),
				'gender'=>$this->input->post('gender'),
				'same_gender'=>$this->input->post('same_gender')
			);
			/////////////////////////
			if(check_missing_parameters($data)==1) return;
			if($this->is_email_exist()==1) return;
			if($this->is_phone_exist()==1) return;
			if($this->is_national_id_exist()==1) return;
			//////////////////////////
			$user_id = $this->user_model->register($data);
			$response_data = new stdClass;
			$response_data->user_id = $user_id;
			echo form_response(
				$this->lang->line('success'),
				$this->lang->line('successful_registration'),
				$response_data);
		}

		public function login(){
			$data = (object)array(
				'email'=>$this->input->post('email'),
				'password'=>$this->input->post('password')
			);
			////////////////
			if(check_missing_parameters($data)==1) return;
			///////////////
			$user = $this->user_model->login($data);
			if($user==null){
				echo form_response(
					$this->lang->line('fail'),
					$this->lang->line('unsuccessful_login'),
					null
					);
				return;
			}
			$response_data = new stdClass;
			$response_data->user_id = $user->id;
			echo form_response(
				$this->lang->line('success'),
				$this->lang->line('successful_login'),
				$response_data);
		}

		public function get_data(){
			$data=(object)array(
				'user_id'=>$this->input->post('user_id')
			);	
			///////////////
			if(check_missing_parameters($data)==1) return;
			$user = $this->get_user($data);
			if($user==null) return;
			///////////////
			$response_data = (object)array(
				"user_id"=>$user->id,
				"name" => $user->name,
				"email" => $user->email,
				"user_type" => $user->user_type_id,
				"phone" => $user->phone,
				"profile_picture_url" => $user->profile_picture_url,
				"linkedin_profile_url" => $user->linkedin_profile_url,
				"position" => $user->position,
				"company" => $user->company,
				"birthdate" => $user->birthdate,
				"gender" => $user->gender
				);
			echo form_response(
				$this->lang->line('success'),
				$this->lang->line('user_id_exists'),
				$response_data);
		}

		public function get_car_details(){
			$data=(object)array(
				'user_id'=>$this->input->post('user_id')
			);
			/////////////////
			if(check_missing_parameters($data)==1) return;
			$car = $this->get_car($data);
			if($car==null) return;
			////////////////
			$response_data = (object)array(
				"id"=>$car->id,
				"number" => $car->number,
				"model" => $car->model,
				"year" => $car->year,
				"color_id" => $car->color_id
				);
			echo form_response(
				$this->lang->line('success'),
				$this->lang->line('car_exists'),
				$response_data);
		}

		public function add_car(){
			$data=(object)array(
				'user_id'=>$this->input->post('user_id'),
				'number'=>$this->input->post('number'),
				'model'=>$this->input->post('model'),
				'year'=>$this->input->post('year'),
				'color_id'=>$this->input->post('color_id')
			);
			////////////////
			if(check_missing_parameters($data)==1) return;
			$user = $this->get_user($data);
			if($user==null) return;
			if($this->is_user_has_car($data)==1) return;
			////////////////
			$car_id = $this->user_model->add_car($data);
			$response_data = new stdClass;
			$response_data->car_id = $car_id;
			echo form_response(
				$this->lang->line('success'),
				$this->lang->line('car_added_successfully'),
				$response_data);
		}

	}
?>