<?php
function encrypt($string) {
  $密钥 = "23333";
	$algorithm = 'rijndael-128';
	$key = md5($密钥, true);
	$iv_length = mcrypt_get_iv_size( $algorithm, MCRYPT_MODE_CBC );
	$iv = mcrypt_create_iv( $iv_length, MCRYPT_RAND );
	$encrypted = mcrypt_encrypt( $algorithm, $key, $string, MCRYPT_MODE_CBC, $iv );
	$result = urlsafe_b64encode( $iv . $encrypted );
	return $result;
}

function decrypt( $string ) {
  $密钥 = "23333";
	$algorithm =  'rijndael-128';
	$key = md5($密钥, true );
	$iv_length = mcrypt_get_iv_size( $algorithm, MCRYPT_MODE_CBC );
	$string = urlsafe_b64decode( $string );
	$iv = substr( $string, 0, $iv_length );
	$encrypted = substr( $string, $iv_length );
	$result = mcrypt_decrypt( $algorithm, $key, $encrypted, MCRYPT_MODE_CBC, $iv );	
	$result = rtrim($result, "\0");															
	return $result;
}

function urlsafe_b64encode($string) {
   $data = base64_encode($string);
   $data = str_replace(array('+','/','='),array('-','_',''),$data);
   return $data;
}

function urlsafe_b64decode($string) {
   $data = str_replace(array('-','_'),array('+','/'),$string);
   $mod4 = strlen($data) % 4;
   if ($mod4) {
       $data .= substr('====', $mod4);
   }
   return base64_decode($data);
}