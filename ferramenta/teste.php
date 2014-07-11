<html> 
	<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		<title>Sistema de busca interna com PHP/PGSQL</title> 
	</head>   
	<body> 
		<form name="frmBusca" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?a=buscar" > 
			<input type="text" name="palavra" /> 
			<input type="submit" value="Buscar" /> 
		</form>   
<? 
			require_once("conADODBopen.php");
			// Recuperamos a ação enviada pelo formulário 
			$a = isset($_GET['a']) ? $_GET['a'] : 'NULL';
			// Verificamos se a ação é de busca 
			if ($a == "buscar") {   
				// Pegamos a palavra 
				$palavra = trim($_POST['palavra']);   
				// Verificamos no banco de dados produtos equivalente a palavra digitada 
				$sql = pg_query("SELECT * FROM revendas WHERE reve_razao ILIKE '%".$palavra."%' ORDER BY reve_razao");   
				// Descobrimos o total de registros encontrados 
				$numRegistros = pg_num_rows($sql);   
				// Se houver pelo menos um registro, exibe-o 
				if ($numRegistros != 0) { 
					// Exibe os produtos e seus respectivos preços 
					while ($produto = pg_fetch_array($sql)) { 
						echo $produto['reve_cod'] . ' - ' .$produto['reve_razao'] . '<br>'; 
					} 
					// Se não houver registros 
				} else { 
					echo "Nenhum produto foi encontrado com a palavra ".$palavra.""; 
				} 
			} 
?> 
	</body> 
</html>