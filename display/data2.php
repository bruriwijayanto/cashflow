<?php
session_start();
$con = new PDO("mysql:host=localhost;dbname=cashflow;charset=utf8", 'root', 'sapi');

$defperoid = date('Ym');
$monPeriod = ($_SESSION['period']<>'')?$_SESSION['period']:$defperoid;
switch($_GET['group']){
	

	case 'smallbox':
		$sql = "SELECT 
					SUM(amount) AS `value`,
					'income' AS label,
					'income' AS `name`
				FROM 
					cashflow cf JOIN category c
						ON 
							cf.idcat = c.`idcat` AND
							DATE_FORMAT(postdate,'%Y%m') = 	'$monPeriod'  AND
							c.type = '+' 
				UNION	
				SELECT 
					SUM(amount) AS `value`,
					'outcome' AS label,
					'outcome' AS `name`
				FROM 
					cashflow cf JOIN category c
						ON 
							cf.idcat = c.`idcat` AND
							DATE_FORMAT(postdate,'%Y%m') = 	'$monPeriod'  AND
							c.type = '-' 
				UNION	
				SELECT 
					SUM(amount) AS `value`,
					category AS label,
					REPLACE(REPLACE(category,' ',''),'/','') AS `name`
				FROM 
					cashflow cf JOIN category c
						ON 
							cf.idcat = c.`idcat` AND
							DATE_FORMAT(postdate,'%Y%m') = 	'$monPeriod'  AND
							c.type = '-'
					
				GROUP BY 
					c.`idcat` 
					";
		$data = array();
		foreach ($con->query($sql) as $dt) {
			$fval = number_format($dt['value'],0,',','.');
			array_push($data,array("name"=>$dt['name'],"label"=>$dt['label'],"value"=>$dt['value'],"formatedvalue"=>$fval));
		}

		$balance = $data[0]['value'] - $data[1]['value'] ;
		$fval = number_format($balance,0,',','.');
		array_push($data,array("name"=>'balance',"label"=>"balance","value"=>$balance,"formatedvalue"=>$fval));
		
	break;

	case 'smallbox-utang':
		$sql = "SELECT 
					amount AS 'value',
					category AS label,
					REPLACE(REPLACE(category,' ',''),'/','') AS `name`   
				FROM 
				utang u JOIN category c
					ON u.`idcat` = c.`idcat`
					";	
		$data = array();
		foreach ($con->query($sql) as $dt) {
			$fval = number_format($dt['value'],0,',','.');
			array_push($data,array("name"=>$dt['name'],"label"=>$dt['label'],"value"=>$dt['value'],"formatedvalue"=>$fval));
		}

		$balance = $data[0]['value'] - $data[1]['value'] ;
		$fval = number_format($balance,0,',','.');
		array_push($data,array("name"=>'balance',"label"=>"balance","value"=>$balance,"formatedvalue"=>$fval));
		
	break;

	case 'smallbox-saving':
		$sql = "SELECT 
					amount AS 'value',
					category AS label,
					REPLACE(REPLACE(category,' ',''),'/','') AS `name`   
				FROM 
				saving s JOIN category c
					ON s.`idcat` = c.`idcat`
					";	
		$data = array();
		foreach ($con->query($sql) as $dt) {
			$fval = number_format($dt['value'],0,',','.');
			array_push($data,array("name"=>$dt['name'],"label"=>$dt['label'],"value"=>$dt['value'],"formatedvalue"=>$fval));
		}

		$balance = $data[0]['value'] - $data[1]['value'] ;
		$fval = number_format($balance,0,',','.');
		array_push($data,array("name"=>'balance',"label"=>"balance","value"=>$balance,"formatedvalue"=>$fval));
		
	break;

	
	case 'neraca':
		$sql = "SELECT 
					DATE_FORMAT(postdate,'%d/%m/%Y %T') AS postdate, 
					category as kategori,
					IF(cf.`type`='+',amount,'') AS debet, 
					IF(cf.`type`='-',amount,'') AS kredit,
					keterangan
				FROM 
					cashflow cf JOIN category c
						ON 
							cf.idcat = c.`idcat`  
				WHERE		
					DATE_FORMAT(postdate,'%Y%m') = 	'$monPeriod'
				ORDER BY 
					postdate";

		$data = array();
		foreach ($con->query($sql) as $dt) {
			$dt['fdebet'] = ($dt['debet'] <> '')?number_format((int) $dt['debet'],0,',','.'):'';
			$dt['fkredit'] = ($dt['kredit'] <> '')?number_format((int) $dt['kredit'],0,',','.'):'';
			array_push($data,$dt);	   
		}
	break;

	
}
die(json_encode($data));
?>