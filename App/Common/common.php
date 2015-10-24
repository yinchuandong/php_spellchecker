<?php

	/**
	 *
	 * ucenter加密和解密的方法
	 * @param String $string
	 * @param String $operation
	 * @param String $key
	 * @param int $expiry
	 * @return String
	 */
	function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		$ckey_length = 4;
	
		$key = md5($key ? $key : 'sikebei');
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
	
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
	
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
	
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
	
		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
	
	/**
	 *
	 * 加密函数
	 * @param String $string
	 * @param String $key C('APP_KEY')
	 * @return String
	 */
	function encode($string,$key=''){
		if ($key == ''){
			$key = C('APP_KEY');
		}
		return _authcode($string,'ENCODE',$key);
	}
	
	/**
	 *
	 * 解密函数
	 * @param string $string
	 * @param string $key 默认为C('APP_KEY')
	 * @return String
	 */
	function decode($string,$key=''){
		if ($key == ''){
			$key = C('APP_KEY');
		}
		return _authcode($string,'DECODE',$key);
	}
	
	/**
	 * 获取当前的字符串时间
	 */
	function getTime(){
		return date('Y-m-d H:i:s');
	}
	
	
	
?>