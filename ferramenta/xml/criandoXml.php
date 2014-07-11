<?
	header("content-type: text/html; charset=utf-8");

	if(true){
		$xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
		$xml .= '<cursos>' . "\n";
			$xml .= "\t" . '<curso id="1">' . "\n";
				$xml .= "\t \t" . '<nome requisito="logica"> PHP Basico</nome>' . "\n";
				$xml .= "\t \t" . '<linguagem>PHP</linguagem>' . "\n";
			$xml .= "\t" . '</curso>' . "\n";
			$xml .= "\t" . '<curso id="2">' . "\n";
				$xml .= "\t \t" . '<nome requisito="logica"> HTML Basico</nome>' . "\n";
				$xml .= "\t \t" . '<linguagem>HTML</linguagem>' . "\n";
			$xml .= "\t" . '</curso>' . "\n";
			$xml .= "\t" . '<curso id="3">' . "\n";
				$xml .= "\t \t" . '<nome requisito="logica"> Javascript Basico</nome>' . "\n";
				$xml .= "\t \t" . '<linguagem>Javascript</linguagem>' . "\n";
			$xml .= "\t" . '</curso>' . "\n";
			$xml .= "\t" . '<curso id="4">' . "\n";
				$xml .= "\t \t" . '<nome requisito="logica"> Javascript Avançado</nome>' . "\n";
				$xml .= "\t \t" . '<linguagem>Javascript</linguagem>' . "\n";
			$xml .= "\t" . '</curso>' . "\n";
		$xml .= '</cursos>' . "\n";
		
		file_put_contents("cursos.xml", $xml);
		
		echo "arquivo Criado com sucesso";
	} else{
		echo "error";
	}
?>