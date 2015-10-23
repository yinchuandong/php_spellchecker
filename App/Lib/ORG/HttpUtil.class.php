<?php

class HttpUtil {
	
	
	public function __construct(){
	}

	/**
	 * 模拟登陆post
	 * @param  [string] $url  
	 * @param  [array] $form 
	 * @return [string] 
	 */
	public function post($url, $form){

		$param = '';
		foreach ($form as $key => $value){
			$param .= "$key=".urlencode($value)."&";
		}
		$param = substr($param, 0,-1);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		
		ob_start();
		curl_exec($ch);
		$content = ob_get_contents();
		ob_end_clean();
		curl_close($ch);
		return $content;
	}
}

?>