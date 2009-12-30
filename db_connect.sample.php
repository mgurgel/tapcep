<?php
	
	// Edit the settings below
	// Edite as configurações abaixo 
	
	define("SQL_HOST", "host_name");
	define("SQL_DB", "database_name");
	define("SQL_USER", "your_username");
	define("SQL_PASSWORD", "your_password");

	// Do not edit beyond this point
	// Não altere nada após esta linha

	$link = mysql_connect(SQL_HOST, SQL_USER, SQL_PASSWORD)
    	or die('Nao foi possivel conectar: ' . mysql_error());

	mysql_select_db(SQL_DB) or die('Nao foi possivel selecionar o banco de dados');

?>