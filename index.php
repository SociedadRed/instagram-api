<?php
define( '__ROOT',	dirname(__FILE__));
define( 'DS',		DIRECTORY_SEPARATOR);

define( '__CLIENT_ID',		'd90f58b63a4549b2ad94f6a8fc271561');
define( '__CLIENT_SECRET',	'f86b35467fa44f179afb70845c6c920f');
define( '__REDIRECT',		'http://lenin.sociedadred.biz/');
define( '__CALLBACK',		'http://lenin.sociedadred.biz/callback.php');
define( '__ACCESS',			'access_token.txt');

if ( isset( $_GET['code'] ) && !empty( $_GET['code'] ) ) {
	$code = trim( $_GET['code'] );
	$url = 'https://api.instagram.com/oauth/access_token';
	$access_token_parameters = array(
		'client_id'				=>	__CLIENT_ID,
		'client_secret'			=>	__CLIENT_SECRET,
		'grant_type'			=>	'authorization_code',
		'redirect_uri'			=>	__REDIRECT,
		'code'					=>	$code,
	);
	try {
		$curl_connection = curl_init($url);
		curl_setopt($curl_connection, CURLOPT_POST,true);   
		curl_setopt($curl_connection, CURLOPT_POSTFIELDS,$access_token_parameters);  
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		
		//Data are stored in $data
		$data = json_decode(curl_exec($curl_connection), true);
		curl_close($curl_connection);

	} catch(Exception $e) {
		return $e->getMessage();
	}
	if ( isset( $data['access_token'] ) ) {
		$texto		= $data['access_token'];
		file_put_contents( __ROOT.DS.__ACCESS, $texto);
	}
	header('Location: '.__REDIRECT);
} else {
	$access_token = NULL;
	if ( file_exists( __ROOT.DS.__ACCESS ) ) {
		$contenido = file_get_contents( __ROOT.DS.__ACCESS );
		if ( !empty( $contenido ) ) {
			$access_token = $contenido;
		}
	}
	// Subscripción
	/*
	$url = 'https://api.instagram.com/v1/subscriptions/';
	$access_token_parameters = array(
		'client_id'				=>     __CLIENT_ID,
		'client_secret'			=>     __CLIENT_SECRET,
		'object'				=>		'location',
		'aspect'				=>		'media',
		'object_id'				=>		'1912745',
		'callback_url'			=>     __CALLBACK,
		'access_token'			=>     $access_token,
	);
	try {
		$curl_connection = curl_init($url);
		curl_setopt($curl_connection, CURLOPT_POST,true);   
		curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $access_token_parameters);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		
		//Data are stored in $data
		$data = json_decode(curl_exec($curl_connection), true);
		curl_close($curl_connection);

	} catch(Exception $e) {
		return $e->getMessage();
	}
	if ( isset( $data['error_type'] ) && $data['error_type'] == 'OAuthRateLimitException' ) {
		header( 'Location: https://api.instagram.com/oauth/authorize/?client_id='.__CLIENT_ID.'&redirect_uri='.__REDIRECT.'&response_type=code' );
	} else {
		var_dump($data);
	}
	*/
	$url = 'https://api.instagram.com/v1/media/search?lat=23&lng=-102&access_token='.$access_token;
	try {
		$curl_connection = curl_init($url);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		
		//Data are stored in $data
		$data = json_decode(curl_exec($curl_connection), true);
		curl_close($curl_connection);

	} catch(Exception $e) {
		return $e->getMessage();
	}
	foreach( $data['data'] AS $dataset) {
		echo "<h3>TAGS</h3>";
		foreach( $dataset['tags'] AS $key => $value ) {
			echo "<p>#".$value."</p>";
		}
		
		echo "<h3>IMAGENES</h3>";
		foreach( $dataset['images'] AS $key => $value ) {
			echo '<p><img src="'.$value['url'].'"></p>';
		}
		
		echo "<h3>COMENTARIOS</h3>";
		foreach( $dataset['comments']['data'] AS $key => $value ) {
			echo '<p>'.$value['text'].'</p>';
		}
		
		echo "<h3>PIE DE FOTO</h3>";
		echo '<p>'.$dataset['caption']['text'].'</p>';
	}
	//var_dump( $dataset );
}
?>