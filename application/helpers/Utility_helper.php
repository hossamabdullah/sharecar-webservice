<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('add')){
		function add($a,$b){
			$c = $a + $b;
			return $c;
		}
	}


	function form_response($status, $message, $data){
		$modifiedData = array();
		if(is_array($data))
			$modifiedData = $data;
		else
			$modifiedData[] = $data;

		$response = "{\"code\":". (int)$message
		.",\"data\":".json_encode($modifiedData,128)."}";

		// $response = "{\"status\":\"".$status."\""
		// .",\"message\":\"".$message."\""
		// .",\"data\":".json_encode($data,128)."}";
		return $response;
	}

	function check_missing_parameters($data){
		foreach($data as $key=>$value){
			if($value===NULL||$value===""){
				echo form_response("FAILURE","Some mandatory data are missing from your request (".$key.")",null);
				return 1;
			}
		}
		return 0;
	}
?>