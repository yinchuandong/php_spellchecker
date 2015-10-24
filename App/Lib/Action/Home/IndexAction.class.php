<?php
class IndexAction extends Action {
	
	public function index(){
        $this->display('Home:Index:scenic');
    }
    
	public function correct(){
        $token = $_POST['token'];
        $postTime = $_POST['time'];

        $decodeStr = decode($token, C('APP_KEY'));
        list($secret, $mac, $clientTime) = explode('-', $decodeStr);
        $valid = $clientTime == $postTime ? 1 : 0;
        if($valid == 0){
            $ret = array('info'=>'no right', 'status'=>0);
            $this->ajaxReturn($ret);
        }

        $model = new TabletModel();
        if($model->where(array('mac' => $mac))->count() == 0){
            $ret = array('info'=>'unregisted', 'status'=>0);
            $this->ajaxReturn($ret);
        }

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
        $str = decode('j32hoUUadViY6i+SQPYp/y58JIQ73XBIM9w1axlqDr8832CGjo5ED4CDP3G7HNqkRg==','123456');
        var_dump($str);
        echo getTime().'-';
        echo time();
    }
    
     public function register(){
        $token = $_POST['token'];
        $postTime = $_POST['time'];
        $password = $_POST['password'];
        if($password != '729114139'){
            $ret = array('info'=>'password fail', 'status'=>0);
            $this->ajaxReturn($ret);
        }

        $decodeStr = decode($token, C('APP_KEY'));
        list($secret, $mac, $clientTime) = explode('-', $decodeStr);
        $valid = $clientTime == $postTime ? 1 : 0;
        if($valid == 0){
            $ret = array('info'=>'no right', 'status'=>0);
            $this->ajaxReturn($ret);
        }

        $model = new TabletModel();
        $_POST['mac'] = $mac; // for auto validate
        $data = $model->create();
        if($data == false){
            $ret = array('info'=> $model->getError(), 'status'=>0);
            $this->ajaxReturn($ret);
        }
        if($model->data($data)->add()){
            $ret = array('info'=>'success', 'status'=>1);
            $this->ajaxReturn($ret);
        }else{
            $ret = array('info'=>'add fail', 'status'=>0);
            $this->ajaxReturn($ret);
        }
    }

 
    
}
