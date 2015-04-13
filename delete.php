<?php
define( '__ROOT',	dirname(__FILE__));
define( 'DS',		DIRECTORY_SEPARATOR);

define( '__CLIENT_ID',		'd90f58b63a4549b2ad94f6a8fc271561');
define( '__CLIENT_SECRET',	'f86b35467fa44f179afb70845c6c920f');
define( '__ACCESS',			'access_token.txt');

$url = 'https://api.instagram.com/v1/subscriptions';
$access_token = NULL;
if ( file_exists( __ROOT.DS.__ACCESS ) ) {
	$contenido = file_get_contents( __ROOT.DS.__ACCESS );
	if ( !empty( $contenido ) ) {
		$access_token = $contenido;
	}
} var_dump( $access_token );
$access_token_parameters = array(
	'client_id'				=>     __CLIENT_ID,
	'client_secret'			=>     __CLIENT_SECRET,
	'access_token'			=>     $access_token,
);

try {
	$curl_connection = curl_init($url);
	curl_setopt($curl_connection, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($curl_connection, CURLOPT_POST,true);   
	curl_setopt($curl_connection, CURLOPT_POSTFIELDS, http_build_query( $access_token_parameters ));  
	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
	
	//Data are stored in $data
	$data = json_decode(curl_exec($curl_connection), true);
	curl_close($curl_connection);

} catch(Exception $e) {
	return $e->getMessage();
}
var_dump($data);
?>