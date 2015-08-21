<?php
class ConfigClass 
{	
	
  public $DB_HOST;
  public $DB_USER;
  public $DB_PASS;
  public $DB_NAME;

  function __construct()
  	{	  	
	  /* Database */
	  $this->DB_HOST = 'localhost';
	  $this->DB_USER = 'root';
	  $this->DB_PASS = 'sapi';
	  $this->DB_NAME = 'cashflow';

	  $basedir = dirname(dirname(dirname(__FILE__)));
	  if($basedir <> $_SERVER['DOCUMENT_ROOT']){
	  	$basename = basename(dirname(dirname(dirname(__FILE__))))."/";
	  }else{
	  	$basename = "";
	  }

	  /* Theme */	  
	  define('HOST', "//".$_SERVER['SERVER_NAME']);
	  define('ROOT_URL',HOST."/"."$basename");
	  define('THEME', 'default');
	  define('THEME_URL', ROOT_URL."themes/".THEME."/");
	  define('ROOT_PATH', $basedir."/");
	  /* Security */  
	  //error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_STRICT);
	  define('DISPLAY_ERRORS', true);
 
	  $this->init();	      
	  
	}		

	function init(){	   	
	  (DISPLAY_ERRORS)?ini_set('display_errors','1'):ini_set('display_errors','0');  	 	 
	}
	
}
?>