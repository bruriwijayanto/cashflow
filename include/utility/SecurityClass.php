<?php
class SecurityClass{
	
	var $filter; 	
	
		function filter($str){
			if(get_magic_quotes_gpc()){
				   $str = stripcslashes($str);
				 }
			   $str = utf8_decode($str);   
			   $forbidstr = array(";","#","'","\\\\","\*");   
			   foreach( $forbidstr as $fbd => $prs){
					$str = str_replace($prs,'',$str);
				  }  
			   return mysql_real_escape_string($str);
		}

				
		function cleanAllRequest(){
				# REQUEST
				foreach( $_REQUEST as $key => $val)
				{
				  $_REQUEST[$key] = $this->filter($val);		  
				} 		
				# POST
				foreach( $_POST as $key => $val)
				{
				  $_POST[$key] = $this->filter($val);	 		  
				} 	
				# GET
				if (isset($_GET)){
				foreach( $_GET as $key => $val)
				{
				  $_GET[$key] = $this->filter($val);			
				} 
				}
				# SESSION	
				if (isset($_SESSION)){
					foreach( $_SESSION as $key => $val)
					{
					  $_SESSION[$key] = $this->filter($val);	  		  
					} 
				}
	
		}

		function getIp() {
		    $ipaddress = '';
		    if ($_SERVER['HTTP_CLIENT_IP'])
		        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
		        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    else if($_SERVER['HTTP_X_FORWARDED'])
		        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		    else if($_SERVER['HTTP_FORWARDED_FOR'])
		        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		    else if($_SERVER['HTTP_FORWARDED'])
		        $ipaddress = $_SERVER['HTTP_FORWARDED'];
		    else if($_SERVER['REMOTE_ADDR'])
		        $ipaddress = $_SERVER['REMOTE_ADDR'];
		    else
		        $ipaddress = 'UNKNOWN';
		    return $ipaddress;
		}	
		
}
?>