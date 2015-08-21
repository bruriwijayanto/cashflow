<?php
session_start();

define('im', true);
require_once('include/common/ConfigClass.php');
require_once('include/data/PDOMysqlClass.php');
require_once('include/utility/EncryptClass.php');
require_once('include/utility/SecurityClass.php');	

require_once('modules/service/ServiceClass.php');

?>