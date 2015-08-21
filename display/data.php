<?php
session_start();
$con = new PDO("mysql:host=127.0.0.1;dbname=plog;charset=utf8", 'root', 'sapi');

$defperoid = date('Ym');
$monPeriod = ($_SESSION['period']<>'')?$_SESSION['period']:$defperoid;
switch($_GET['group']){
	case 'donut':

		$sql = "SELECT 
					SUM(jumlah) AS `value`,k.kategori AS label 
				FROM 
					kaslog l JOIN kategori k
					ON 
						l.kategori = k.idkategori AND
						DATE_FORMAT(postdate,'%Y%m') = '$monPeriod'  
				WHERE 
					`type`='-' 
				GROUP BY 
					l.kategori";

		$data = array();
		foreach ($con->query($sql) as $dt) {
			$fval = number_format($dt['value'],0,',','.');
			array_push($data,array("label"=>$dt['label'],"value"=>$dt['value'],"formatedvalue"=>$fval));
		}
	break;

	case 'saving':
		$sql = "SELECT 
					SUM(jumlah) AS `value`,k.kategori AS label 
				FROM 
					kaslog l JOIN kategori k
					ON 
						l.kategori = k.idkategori AND
						DATE_FORMAT(postdate,'%Y%m') = '$monPeriod'  
				WHERE 
					`type`='=' 
				GROUP BY 
					l.kategori";

		$data = array();
		foreach ($con->query($sql) as $dt) {
			$fval = number_format($dt['value'],0,',','.');
			array_push($data,array("label"=>$dt['label'],"value"=>$dt['value'],"formatedvalue"=>$fval));
		}
	break;

	case 'smallbox':
		$sql = "SELECT 
					SUM(jumlah) AS `value`,k.kategori AS label 
				FROM 
					 kategori k LEFT JOIN kaslog l 
					ON 
						l.kategori = k.idkategori AND
						DATE_FORMAT(postdate,'%Y%m') = '$monPeriod'  
				WHERE 
					`type`='-'  
				GROUP BY 
					l.kategori
				UNION 
				SELECT 
					SUM(jumlah) AS `value`,k.kategori AS label 
				FROM 
					 kategori k LEFT JOIN kaslog l 
					ON 
						l.kategori = k.idkategori 
				WHERE 
					`type`='='  
				GROUP BY 
					l.kategori
					";

		$data = array();
		foreach ($con->query($sql) as $dt) {
			$fval = number_format($dt['value'],0,',','.');
			array_push($data,array("label"=>$dt['label'],"value"=>$dt['value'],"formatedvalue"=>$fval));
		}
	break;

	case 'line':
		$sql = "SELECT 	
					SUM(jumlah) AS `value`,
					SUM(IF(kategori='fd',jumlah,0)) AS `fd`,
					SUM(IF(kategori='hm',jumlah,0)) AS `hm`,
					SUM(IF(kategori='rs',jumlah,0)) AS `rs`,
					SUM(IF(kategori='tr',jumlah,0)) AS `tr`,
					SUM(IF(kategori='pls',jumlah,0)) AS `pls`, 
					DATE_FORMAT(postdate,'%d %M, %W') AS label,
					DATE_FORMAT(postdate,'%d %W') AS simlabel
				FROM 
					kaslog 						
				WHERE 
					`type`='-' AND
					DATE_FORMAT(postdate,'%Y%m') = '$monPeriod'
				GROUP BY  
					DATE_FORMAT(postdate,'%d')";

		$data = array();
		foreach ($con->query($sql) as $dt) {
			array_push($data,array(
								"simlabel"=>$dt['simlabel'],
								"label"=>$dt['label'],
								"value"=>$dt['value'],
								"fd"=>$dt['fd'],
								"hm"=>$dt['hm'],
								"rs"=>$dt['rs'],
								"pls"=>$dt['pls'],
								"tr"=>$dt['tr'],
								)
					   );
		}
	break;
	case 'neraca':
		$sql = "SELECT 
					postdate,
					k.kategori, 
					IF(`type`='+' OR `type`='=',jumlah,'') AS debet, 
					IF(`type`='-',jumlah,'') AS kredit,
					keterangan
				FROM 
					kaslog l LEFT JOIN kategori k
					ON
						l.kategori = k.`idkategori`
				WHERE		
					DATE_FORMAT(postdate,'%Y%m') = 	'$monPeriod'
				ORDER BY postdate DESC";

		$data = array();
		foreach ($con->query($sql) as $dt) {
			$dt['fdebet'] = ($dt['debet'] <> '')?number_format($dt['debet'],0,',','.'):'';
			$dt['fkredit'] = ($dt['kredit'] <> '')?number_format($dt['kredit'],0,',','.'):'';
			array_push($data,$dt);	   
		}
	break;

	
}
die(json_encode($data));
?>