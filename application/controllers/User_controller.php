<?php 
	class User_controller extends CI_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->helper('Utility_helper');
		}

		public function register(){
			$this->load->helper('url');
			$data = array(
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
			$user_id = $this->user_model->register($data);
			$response_data = new stdClass;
			$response_data->user_id = $user_id;
			//method from helper class
			echo form_response("SUCCESS","You have been registered successfully",$response_data);
		}
	}
?>