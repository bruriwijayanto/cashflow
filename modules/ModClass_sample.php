<?php
	require_once(__DIR__ . '/../include/data/CRUDMysqlClass.php');
	class BeritaModClass  Extends CRUDMysqlClass {
		protected $table = 'berita';
		protected $pk	 = 'idberita';
		
		public function search($key){
			$sql = "SELECT * from berita where title like :keyword";
			return $this->db->query($sql,array('keyword'=>'%'.$key.'%'));	
		}
	}

	/*
	// SAMPLE USAGE :
	// :: Example 1 manually select

	include("include/data/PDOMysqlClass.php");
  
	$pdo = new PDOMysqlClass;
	$data = $pdo->query("select * from agenda");

	// :: Example 2 using CRUD

	include("modules/BeritaModClass.php");

	$databerita = new BeritaModClass;

	// select
	$data = $databerita->all();
	$data34 = $databerita->find('34');
	$max = $databerita->max('idberita');
	$min = $databerita->min('idberita');

	// insert
	$databerita->title = "joel mbok";
	echo $databerita->create();

	// update
	$databerita->title = "joel mbok";
	echo $databerita->create();

	// delete
	$berita->idberita ='44';
	echo $berita->delete();

	*/

?>