<?php
	require_once("tool/adodb/adodb.inc.php");
	require_once("tool/adodb/adodb-exceptions.inc.php");
	$server = "192.168.0.4";
	$user = "revendamais";
	$pass = "reV1047";
	$name = "postgres";
	$conexao = sprintf("host=%s dbname=%s user=%s password=%s",
							 $server,
							 $name,
							 $user,
							 $pass);
	$db = NewADOConnection('postgres');
	if(! $db->PConnect($conexao)){
		echo "falha de conexão";
	}
?>