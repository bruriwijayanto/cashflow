<?php
class BeritaModelClass  Extends CRUDMysqlClass {
		protected $table = 'berita';
		protected $pk	 = 'idberita';
		
		public function search($key){
			$sql = "SELECT * from berita where title like :keyword";
			return $this->db->query($sql,array('keyword'=>'%'.$key.'%'));	
		}

		public function lastNews(){	
			$sql = "SELECT * FROM berita ORDER BY idberita DESC LIMIT 0,2";
			return $this->db->query($sql);	
		}

		public function getDetail($id){
			$sql = "SELECT title,content from berita where idberita = :id";
			return $this->db->query($sql,array('id'=>$id));	
		}

	}
?>