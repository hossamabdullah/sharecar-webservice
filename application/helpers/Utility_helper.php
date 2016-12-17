<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('add')){
		function add($a,$b){
			$c = $a + $b;
			return $c;
		}
	}


	function form_response($status, $message, $data){
		$response = "{\"status\":\"".$status."\""
		.",\"message\":\"".$message."\""
		.",\"data\":".json_encode($data,128)."}";
		return $response;
	}
?>