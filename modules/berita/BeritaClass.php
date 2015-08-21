<?php

$viewfile = substr(basename(__FILE__),0,strlen(basename(__FILE__))-9)."ViewClass.php";
require_once(__DIR__ .'/'.$viewfile);

class BeritaClass Extends ControllerClass{

	function __construct($owner){	
		parent::__construct($owner);
		$this->vberita = new BeritaViewClass;
		$this->mberita = $owner->mberita;	
	}

	function buildForm(){
		# menampilkan form
	}
	function insert(){
		# query insert 
	}
	function update(){
		# query update 
	}
	function delete(){
		# query delete 
	}
	function manage(){
		# grid & manajemen data
	}
	function frontDisplay(){
		# tampilan depan
	}
	
	function frontList(){
		# daftar artikel
		$data['numperpage'] = 3;
		$data['numrows'] = $this->mberita->count('*');
		$data['berita'] = $this->mberita->page(1,$data['numperpage'],'postdate');
		$this->vberita->frontlist($data);
		echo "<pre>"; print_r($_GET); 
		
	}

}
?>