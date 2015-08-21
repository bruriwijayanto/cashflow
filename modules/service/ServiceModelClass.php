<?php

class ServiceModelClass{
	function __construct($owner){	
		$this->owner = $owner;
		$this->db = $this->owner->db;
	}

	function addCat($type, $category){
		$sql = "INSERT INTO category(type, category) values(:type,:category)";
		$params = array(
						'type'=>$type,
						'category'=>$category
						);
		return $this->db->query($sql,$params);
	}

	function ListCat($type){
		$sql = "SELECT * FROM category where type like :type order by type,category";
		$params = array(
						'type'=>$type
						);
		return $this->db->query($sql,$params);
	}

	function ListLsp(){
		$sql = "SELECT * FROM lokasisimpanan";
		return $this->db->query($sql);
	}

	function addCf($type, $amount, $category, $ket, $postdate){
		if(!empty($amount) && !empty($category) ){
			$qpostdate = ($postdate == '')?'NOW()':':postdate';
			$sql = "INSERT INTO 
						cashflow(type, amount, idcat, keterangan, postdate) 
					values
						(:type, :amount, :category, :ket, $qpostdate) /* :postdate */";
			$params = array(
							'type'=>$type,
							'amount'=>$amount,
							'category'=>$category,
							'ket'=>$ket,
							'postdate'=>$postdate
							);
			return $this->db->query($sql,$params);
		}else{
			die('incomplete field');
		}	
	}

	function addlimit($limitamount, $category){
		$sql = "SELECT * FROM limitalokasi WHERE idcat = :category";
		$params = array(
						'category'=>$category
						);
		$dres = $this->db->query($sql,$params);
		
		if(count($dres) == 0){
			$sql = "INSERT INTO 
						limitalokasi(limitamount, idcat) 
					values
						(:limitamount, :category) ";
			$params = array(
							'limitamount'=>$limitamount,
							'category'=>$category
							);
		}else{
			$sql = "UPDATE 
						limitalokasi
					SET 
						limitamount = :limitamount
					WHERE
						idcat = :category";		
			$params = array(
							'limitamount'=>$limitamount,
							'category'=>$category
							);

		}	
			
		return $this->db->query($sql,$params);
	}

	function addSaving($amount, $category, $ket, $idlsp, $postdate){
		$sql = "SELECT * FROM saving WHERE idcat = :category";
		$params = array(
						'category'=>$category
						);
		$dres = $this->db->query($sql,$params);
		
		if(count($dres) == 0){
			$qpostdate = ($postdate == '')?'NOW()':':postdate';
			$sql = "INSERT INTO 
						saving(amount, idcat, keterangan, idlsp, postdate) 
					values
						(:amount, :category, :ket, :idlsp ,$qpostdate) /* :postdate */";
			$params = array(
							'amount'=>$amount,
							'category'=>$category,
							'ket'=>$ket,
							'idlsp'=>$idlsp,
							'postdate'=>$postdate
							);
		}else{
			$sql = "UPDATE 
						saving
					SET 
						amount = amount + :amount
					WHERE
						idcat = :category";		
			$params = array(
							'amount'=>$amount,
							'category'=>$category
							);

		}	
			
		return $this->db->query($sql,$params);
	}

	function addUtang($status, $amount, $category){
		$sql = "SELECT * FROM utang WHERE idcat = :category";
		$params = array(
						'category'=>$category
						);
		$dres = $this->db->query($sql,$params);
		
		if(count($dres) == 0){
			$sql = "INSERT INTO 
						utang(amount, idcat) 
					values
						(:amount, :category)";
			$params = array(
							'amount'=>$amount,
							'category'=>$category
							);
		}else{
			if($status == 'bayar'){
				$sql = "UPDATE 
							utang
						SET 
							amount = amount - :amount
						WHERE
							idcat = :category";		
				$params = array(
								'amount'=>$amount,
								'category'=>$category
								);
			}else{
				$sql = "UPDATE 
							utang
						SET 
							amount = amount + :amount
						WHERE
							idcat = :category";		
				$params = array(
								'amount'=>$amount,
								'category'=>$category
								);
			}

		}	
			
		return $this->db->query($sql,$params);
	}

	function addPiutang($status, $amount, $category){
		$sql = "SELECT * FROM piutang WHERE idcat = :category";
		$params = array(
						'category'=>$category
						);
		$dres = $this->db->query($sql,$params);
		
		if(count($dres) == 0){
			$sql = "INSERT INTO 
						piutang(amount, idcat) 
					values
						(:amount, :category)";
			$params = array(
							'amount'=>$amount,
							'category'=>$category
							);
		}else{
			if($status == 'bayar'){
				$sql = "UPDATE 
							piutang
						SET 
							amount = amount - :amount
						WHERE
							idcat = :category";		
				$params = array(
								'amount'=>$amount,
								'category'=>$category
								);
			}else{
				$sql = "UPDATE 
							piutang
						SET 
							amount = amount + :amount
						WHERE
							idcat = :category";		
				$params = array(
								'amount'=>$amount,
								'category'=>$category
								);
			}

		}	
			
		return $this->db->query($sql,$params);
	}


	function income($amount, $category, $ket, $postdate){
		$this->addCf('+',$amount, $category, $ket, $postdate);
	}

	function outcome($amount, $category, $ket, $postdate){
		$this->addCf('-',$amount, $category, $ket, $postdate);
	}

	function saving($amount, $category, $ket, $postdate, $idlsp, $target){
		$this->outcome($amount, $category, $ket, $postdate);
		$this->addSaving($amount, $category, $target, $idlsp, $postdate);
	}

	function utang($amount, $category, $ket, $postdate){
		$this->income($amount, $category, $ket, $postdate);
		$this->addUtang('utang',$amount, $category);
	}

	function bayarUtang($amount, $category, $ket, $postdate){
		$this->outcome($amount, $category, $ket, $postdate);
		$this->addUtang('bayar',$amount, $category);
	}

	function piutang($amount, $category, $ket, $postdate){
		$this->outcome($amount, $category, $ket, $postdate);
		$this->addPiutang('piutang',$amount, $category);
	}

	function bayarPiutang($amount, $category, $ket, $postdate){
		$this->income($amount, $category, $ket, $postdate);
		$this->addPiutang('bayar',$amount, $category);
	}




}	