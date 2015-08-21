<?php
class EncryptClass
{
		function encrypt($string, $salt='enc123'){
			return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($salt), $string, MCRYPT_MODE_CBC, md5(md5($salt))));
		}
		
		function decrypt($string, $salt='enc123'){
			return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($salt), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($salt))), "\0");
		}
		
		function arrEncrypt($array){			 
			foreach( $array as $key => $val){
				$array[$key] = $this->encrypt($val);
			}			
			return $array;
		}

		function arrDecrypt($array){			 
			foreach( $array as $key => $val){
				$array[$key] = $this->decrypt($val);
			}			
			return $array;
		}
}
?>