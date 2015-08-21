<?php
class AuthenticationClass
{	
	
	var $db;	
	var $group;
	var $sql;
	var $ssusrvar;
	var $sspassvar;
	var $timeout;
	
	 
	
	function AuthenticationClass()
	{
		$this->db 	 = new MysqlClass();
		$this->encr  = new EncryptClass;
		$this->scr  = new SecurityClass;
		$token = date('Ymd').ROOT_PATH.$this->scr->getIp();		
		$this->ssusrvar  = md5('ssusr'.$token);
		$this->sspassvar = md5('sspsw'.$token);
		$this->coousrvar  = md5('coousr'.$token);
		$this->coopassvar = md5('coopsw'.$token);
		$this->timeout = 60*60*60;
	}	
	
	
	function validLogin($usr,$pass)
	{
		$this->sql = "SELECT * FROM users WHERE md5(md5(username))='".$usr."' AND md5(pass)='".$pass."'";
		$res 	= mysql_query($this->sql);
	
		if($this->db->numRows($res) > 0 ){
			return true;
		}else{
			return false;
		}
	}
	
	function setCookie($name,$val)
  	{		
		setcookie($name, $val, time() + $this->timeout );
  	}
	
	

	function unsetCookie( $name ) {
		setcookie ($name, "", time() - 3600);
	} 
	
	
	
	function getExpire()
	{
		return $this->timeout;
	}
	
	function getDetail()
  	{
		
		$usr 	= $this->encr->decrypt($_SESSION[$this->ssusrvar]);
		$sql	= "SELECT * FROM users WHERE md5(md5(username))= '$usr' ";
		$res 	= $this->db->query($sql);
		return  $this->db->fetchArray($res);						
	}
	
	
	function login($usr,$pass){
		if($this->validLogin($usr,$pass)){
			$_SESSION[$this->ssusrvar] = $this->encr->encrypt($usr); 
			$_SESSION[$this->sspassvar] = $this->encr->encrypt($pass); 
			$this->setCookie($this->coousrvar,$this->encr->encrypt($usr));
			$this->setCookie($this->coopswvar,$this->encr->encrypt($pass));
			return true;
		}else{
			return false;
		}
	}
	
	
	function isAuth(){		
		$usr 	= $this->encr->decrypt($_SESSION[$this->ssusrvar]);
		$pass 	= $this->encr->decrypt($_SESSION[$this->sspassvar]);
		//$this->sql = "SELECT * FROM users WHERE username='$usr' AND pass=md5('$pass')";
		$this->sql = "SELECT * FROM users WHERE md5(md5(username))='".$usr."' AND md5(pass)='".$pass."'";
		$res 	= $this->db->query($this->sql);
		if($this->db->numRows($res) > 0 && $_SESSION[$this->ssusrvar] == $_COOKIE[$this->coousrvar] ){
			return true;
		}else{
			return false;
		}
	}
	
	function logout(){
		unset($this->ssusrvar);
		unset($this->sspassvar);		
		$this->unsetCookie($this->coousrvar);
		$this->unsetCookie($this->coopswvar);
	}
	
	
	
}

?>