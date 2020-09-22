<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feeder extends CI_Model{
	
	public function getToken_feeder(){
		$url = $this->config->item('url_feeder'); // gunakan live bila sudah yakin

		$client = new nusoap_client($url, true);

		// Mendapatkan Token

		$username = $this->config->item('user_feeder');
		$password = $this->config->item('password_feeder');
		
		$temp_proxy = $client->getProxy();
        $temp_error = $client->getError();
        if ($temp_proxy == NULL) {
			echo "Error GetProxy $temp_error<br>";
        } else {
            $temp_token = $temp_proxy->GetToken($username, $password);
			if ($temp_token == 'ERROR: username/password salah') {
				echo "Error User/Password Salah $temp_token<br>";
			} else {
				$array = array(
					"temp_proxy" => $temp_proxy,
					"temp_token" => $temp_token
				);
				return $array;
			}
		}
	}
	
	public function action_feeder($temp_token,$temp_proxy,$action,$table,$record){
		$resultb = $temp_proxy->$action($temp_token, $table, json_encode($record));
		return $resultb['result'];
	}
}