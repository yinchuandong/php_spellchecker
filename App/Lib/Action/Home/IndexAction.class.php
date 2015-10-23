<?php
class IndexAction extends Action {
	
	public function index(){
        $this->display('Home:Index:scenic');
    }
    
	public function correct(){

        $form = array(
            'article' => 'he am a boys,I has a apples. you is a boy.'
        );

		import('ORG.HttpUtil');
		$url = "http://127.0.0.1:8080/JSP_SpellChecker/index.jsp?articl=123";
        // $url = "http://127.0.0.1/php_spellchecker/index.php/Index/test";
		$util = new HttpUtil();
        $ret = $util->post($url, $form);
		// $resultJson = json_decode($ret, true);
        // var_dump($resultJson);
        var_dump($ret);
    }

    public function test(){
        var_dump($_POST);
        var_dump('fuck');
    }
    
 
    
}
