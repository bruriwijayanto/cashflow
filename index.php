<?php
include('inc.php');

class cms{

	function __construct(){	
		$this->cnf = new ConfigClass;
		$this->db = new PDOMysqlClass($this->cnf);	
		$this->scr = new SecurityClass;
		$this->init();
	}

	function _class(){
		$this->service = new ServiceClass($this);
	}

				
	function init(){
		$this->_class();	
	
		switch($_GET['content']){
			case 'service':
				$this->service->init();
			break;
			default:	
				$this->getIndex();			
			break;
		}
	}	


	function getIndex(){		
		die('hello world');
	}


}


$gi	= new cms();

?>