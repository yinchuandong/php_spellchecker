<?php
class TabletModel extends Model{
	
	protected $_validate = array(
    	array('mac','require','not null'), //默认情况下用正则进行验证
    	array('mac','','already exists',0,'unique',1)
	);
	
	protected $_auto = array (
			array('time', 'getTime', Model::MODEL_INSERT, 'function'),
	);

	public function __construct(){
		parent::__construct();
	}
	
	
	
} 

