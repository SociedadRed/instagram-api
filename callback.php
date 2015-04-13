<?php
define( '__ROOT',	dirname(__FILE__));
define( 'DS',		DIRECTORY_SEPARATOR);

if ( isset( $_GET['hub_challenge'] ) ) {
	print $_GET['hub_challenge']; exit(1);
}
if ( isset( $_GET['hub.challenge'] ) ) {
	print $_GET['hub.challenge']; exit(1);
}

if ( isset( $_POST ) ) {
	define( '__DB_HOST', 'localhost');
	define( '__DB_USER', 'root');
	define( '__DB_PASS', 'root');
	define( '__DB_NAME', 'pme');

	if ( __DB == true ) {
		if (version_compare(phpversion(), '5.3.4', '<')) {
			require_once( __LIB.DS.'redbean'.DS.'rb-p533.php');
		} else {
			require_once( __LIB.DS.'redbean'.DS.'rb.php');
		}

		R::setup('mysql:host='.__DB_HOST.';dbname='.__DB_NAME,__DB_USER,__DB_PASS);
		$DB = R::getToolBox();
	}

	var_dump($_POST);	
}
?>