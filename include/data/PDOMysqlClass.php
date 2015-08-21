<?php
class PDOMysqlClass {	
	
	private $pdo;
	private $sQuery;
	private $parameters;
	private $bConnected = false;


	public function __construct($cnf)
	{ 	
		$this->config = $cnf; 		
		$this->Connect();
		$this->parameters = array();
		
	}	


	private function Connect()
	{		
		$dsn = 'mysql:dbname='.$this->config->DB_NAME.';host='.$this->config->DB_HOST.'';
		try 
			{
				$this->pdo = new PDO($dsn, $this->config->DB_USER, $this->config->DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$this->bConnected = true;
			}
			catch (PDOException $e) 
			{
				die('Saat ini kami sedang melakukan perbaikan Database');
			}			
	}

	public function bind($para, $value)
	{	
			$this->parameters[sizeof($this->parameters)] = ":" . $para . "\x7F" . utf8_encode($value);
	}

	public function bindMore($parray)
	{
		if(empty($this->parameters) && is_array($parray)) {
			$columns = array_keys($parray);
			foreach($columns as $i => &$column)	{
				$this->bind($column, $parray[$column]);
			}
		}
	}

	private function Init($query,$parameters = "")
	{
		if(!$this->bConnected) { $this->Connect(); }
		try {
				$this->sQuery = $this->pdo->prepare($query);
				$this->bindMore($parameters);

				if(!empty($this->parameters)) {
					foreach($this->parameters as $param)
					{
						$parameters = explode("\x7F",$param);
						$this->sQuery->bindParam($parameters[0],$parameters[1]);
					}		
				}

				$this->succes 	= $this->sQuery->execute();		
		}
		catch(PDOException $e)
		{
				//echo $this->ExceptionLog($e->getMessage(), $query );
				// sesuk pindah neng log
				die($e->getMessage()." PATENI SIK ". $query);
		}
		$this->parameters = array();
	}

	public function query($query,$params = null, $fetchmode = PDO::FETCH_ASSOC)
	{
		$query = trim($query);
		$this->Init($query,$params);
		$rawStatement = explode(" ", $query);		
		$statement = strtolower($rawStatement[0]);		
		if ($statement === 'select' || $statement === 'show') {
			return $this->sQuery->fetchAll($fetchmode);
		}
		elseif( $statement === 'insert' ||  $statement === 'update' || $statement === 'delete' ){
			return $this->sQuery->rowCount();	
		}	
		else {
			return NULL;
		}
	}

	public function lastInsertId() {
		return $this->pdo->lastInsertId();
	}

	public function column($query,$params = null)
	{
		$this->Init($query,$params);
		$Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);		
		
		$column = null;

		foreach($Columns as $cells) {
			$column[] = $cells[0];
		}
		return $column;		
	}

	public function row($query,$params = null,$fetchmode = PDO::FETCH_ASSOC)
	{				
		$this->Init($query,$params);
		return $this->sQuery->fetch($fetchmode);			
	}

	public function single($query,$params = null)
	{
			$this->Init($query,$params);
			return $this->sQuery->fetchColumn();
	}		

	/*
	### CONTOH PENGGUNAAN ###

	1. simple binding
	$db->bind("id","$x");
	$sql = "select * from agenda where idagenda = :id ";
	$data = $db->query($sql);

	2. multiple array binding
	$db->bindMore(array("id"=>"1","lokasi"=>"jayapura"));
	$sql = "select * from agenda where idagenda = :id AND lokasi = :lokasi ";
	$data = $db->query($sql);

	3. simple query / inline binding
	$data  =  $db->query("select * from agenda where idagenda = :id", array("id"=>"4"));

	3. single row
	$data  =  $db->row("select * from agenda where idagenda");

	4. num row 
	$num = count($data);

	*/


}
?>