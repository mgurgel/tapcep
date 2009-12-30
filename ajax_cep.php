<?php

	define("CEP_LOG_TABLE", "cep_log_index");
	define("CEP_LOG_COLUMN", "cep5");
	define("CEP_COLUMN", "cep");

	define("AJAX_CEP_URL","http://republicavirtual.com.br/web_cep.php?formato=query_string&cep=");

	require_once('db_connect.php');

	function sanitize($var) {
		if(get_magic_quotes_gpc()) {
			$var = stripslashes($var);
		}
		$var = mysql_real_escape_string($var);
		return $var;
	}

	// Retorna valor da coluna $col na linha atual do $result
	function getValue($result, $col) {
		if (!$line = mysql_fetch_array($result, MYSQL_ASSOC)) return false;
		return $line[$col];
	}
	
	// Insere separador após 5o dígito do CEP
	function  formatCep($cep) {
		return substr($cep,0,5)."-".substr($cep,5,3);
	}
	
	// Procura CEP no banco de dados local
	function localCep($cep) {
		
		// Consulta a UF a partir dos 5 primeiros dígitos do CEP
		$query = sprintf("SELECT uf FROM %s WHERE %s = '%s'", CEP_LOG_TABLE, CEP_LOG_COLUMN, sanitize(substr($cep,0,5)));
		$result = mysql_query($query) or die('Erro de query: ' . mysql_error());
		if (!$uf = getValue($result, "uf")) return false;
		
		// Consulta o CEP na tabela da UF correspondente
		$query = sprintf("SELECT * FROM %s WHERE %s = '%s'", sanitize($uf), CEP_COLUMN, sanitize(formatCep($cep)));
		if (!($result = mysql_query($query) or die('Erro de query: ' . mysql_error()))) {
			return false;
		}

		$line = mysql_fetch_array($result, MYSQL_ASSOC);
		return array('tipo' => $line['tp_logradouro'], 'logradouro' => $line['logradouro'], 'bairro' => $line['bairro'], 'cidade' => $line['cidade'], 'uf' => mb_strtoupper($uf), 'cep' => $line['cep']);

	}
	
	function wsCep($cep) {
	    if (!$result = @file_get_contents(AJAX_CEP_URL.urlencode($cep))) {
			return false;
		}
	    parse_str($result, $line);
		if (!strcmp($line['txt_resultado'], "sucesso - cep completo")) {
			return false;
		}
		return array('tipo' => $line['tipo_logradouro'], 'logradouro' => $line['logradouro'], 'bairro' => $line['bairro'], 'cidade' =>$line['cidade'], 'uf' => $line['uf'],  'cep' => $line['cep']);
	}  

	function buscaCep($cep) {
		if (strlen($cep) < 8) {
			return false;
		}

		// Consulta local, depois webservice
		if (!$result = localCep($cep)) {
			$result = wsCep($cep);
		}
		return $result;
	}

	function jsonResponse($result, $cep) {
		if ($result && $result['logradouro']) {
			$response = 'success';
			$data = $result;
		}
		else {
			$response = 'error';
			$data = array('cep' => formatCep($cep));
		}
		return json_encode(array('response' => $response, 'data' => $data));
	}

	if (isset($_GET['cep'])&&$_GET['cep']) {
		$current_cep = preg_replace('/\D/', "", strip_tags($_GET['cep']));
		$result = buscaCep($current_cep);
		
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
		header("Cache-Control: no-cache, must-revalidate" ); 
		header("Pragma: no-cache" );
		header('Content-type: application/json; charset=utf-8');
	
		echo jsonResponse($result, $current_cep);	

	}

?>