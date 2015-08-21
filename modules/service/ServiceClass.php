<?php
require_once(__DIR__ .'/ServiceModelClass.php');
//require_once(__DIR__ .'/ServiceViewClass.php');

class ServiceClass{
	function __construct($owner){	
		//$this->vberita = new BeritaViewClass;
		$this->mservice = new ServiceModelClass($owner);	
	}

	function init(){
		$apikey = (isset($_GET['apiKey']))?$_GET['apiKey']:''; 
		if($apikey == 's4p1'){
			switch($_GET['mode']){
				case 'addcat':
					$this->addCat();
				break;
				case 'listcat':
					$this->listCat();
				break;
				case 'listlsp':
					$this->listLsp();
				break;
				case 'addcf':
					$this->addCf();
				break;
				case 'in':
					$this->income();
				break;
				case 'out':
					$this->outcome();
				break;
				case 'saving':
					$this->saving();
				break;
				case 'utang':
					$this->utang();
				break;
				case 'bayarutang':
					$this->bayarUtang();
				break;
				case 'piutang':
					$this->piutang();
				break;
				case 'bayarpiutang':
					$this->bayarPiutang();
				break;
				case 'limit':
					$this->limit();
				break;
				default:
					die('im service');			
				break;
			}
		}else{
			die('j:i:v:key');
		}	
	}

	function listCat(){
		$type = (!empty($_GET['type']))?$_GET['type']:"%";
		$json = json_encode($this->mservice->listCat($type));
		die($json);
	}

	function listLsp(){
		$json = json_encode($this->mservice->listLsp());
		die($json);
	}

	function addCat(){
		$this->mservice->addCat($_GET['type'],$_GET['category']);
		echo "ok";
	}

	function addCf(){
		$date = ($_GET['postdate'] <> '')?$_GET['postdate']:date('Y-m-d H:i:s');
		$this->mservice->addCf(
								$_GET['type'],
								$_GET['amount'],
								$_GET['category'],
								$_GET['ket'],
								$date
							  );					  
		echo "ok";
	}

	function income(){
		$date = (!empty($_GET['postdate']))?$_GET['postdate']:'';
		$ket = (!empty($_GET['ket']))?$_GET['ket']:'';
		$this->mservice->income(
								$_GET['amount'],
								$_GET['category'],
								$ket,
								$date
							  );					  
		echo "ok";
	}

	function outcome(){
		$date = (!empty($_GET['postdate']))?$_GET['postdate']:'';
		$ket = (!empty($_GET['ket']))?$_GET['ket']:'';
		$this->mservice->outcome(
								$_GET['amount'],
								$_GET['category'],
								$ket,
								$date
							  );					  
		echo "ok";
	}

	function limit(){
		$this->mservice->addlimit(
								$_GET['amount'],
								$_GET['category']
							  );					  
		echo "ok";
	}


	function saving(){
		$date = (!empty($_GET['postdate']))?$_GET['postdate']:'';
		$ket = (!empty($_GET['ket']))?$_GET['ket']:'';
		$idlsp = (!empty($_GET['idlsp']))?$_GET['idlsp']:'';
		$target = (!empty($_GET['target']))?$_GET['target']:'';

		$this->mservice->saving(
								$_GET['amount'],
								$_GET['category'],
								$ket,
								$date,
								$idlsp,
								$target
							  );					  
		echo "ok";
	}

	function utang(){
		$date = (!empty($_GET['postdate']))?$_GET['postdate']:'';
		$ket = (!empty($_GET['ket']))?$_GET['ket']:'';
		$this->mservice->utang(
								$_GET['amount'],
								$_GET['category'],
								$ket,
								$date
							  );					  
		echo "ok";
	}

	function bayarUtang(){
		$date = (!empty($_GET['postdate']))?$_GET['postdate']:'';
		$ket = (!empty($_GET['ket']))?$_GET['ket']:'';
		$this->mservice->bayarUtang(
								$_GET['amount'],
								$_GET['category'],
								$ket,
								$date
							  );					  
		echo "ok";
	}

	function piutang(){
		$date = (!empty($_GET['postdate']))?$_GET['postdate']:'';
		$ket = (!empty($_GET['ket']))?$_GET['ket']:'';
		$this->mservice->piutang(
								$_GET['amount'],
								$_GET['category'],
								$ket,
								$date
							  );					  
		echo "ok";
	}

	function bayarPiutang(){
		$date = (!empty($_GET['postdate']))?$_GET['postdate']:'';
		$ket = (!empty($_GET['ket']))?$_GET['ket']:'';
		$this->mservice->bayarPiutang(
								$_GET['amount'],
								$_GET['category'],
								$ket,
								$date
							  );					  
		echo "ok";
	}


}	