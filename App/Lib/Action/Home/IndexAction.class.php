<?php
class IndexAction extends Action {
	
	public function index(){
        $this->display('Home:Index:scenic');
    }
    
	public function correct(){
        $article = $this->_post('article');
        $form = array(
            'article' => $article
        );

		import('ORG.HttpUtil');
		$url = "http://127.0.0.1:8080/JSP_SpellChecker/index.jsp";
		$util = new HttpUtil();
        $ret = $util->post($url, $form);
        // var_dump($ret);
        echo $ret;
        exit;
    }

    public function test(){
        var_dump($_POST);
        var_dump('fuck');
    }
    
 
    
}
