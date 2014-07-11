<style>
a{
	text-decoration:none;
	margin-right:5%;
	margin-top:20%;
	padding:3px 8px;
	border-radius:5px;
	color:#FFF;
	text-shadow:0 -1px 0 rgba(0,0,0,0.25);
	background: -webkit-linear-gradient(#04c, #0066cc);
	background: -moz-linear-gradient(#7a7, #063);
	border-top:2px solid #9c9;
	border-left:1px solid #063;
	border-right:1px solid #063;
	border-bottom:1px solid #063;
}
</style>
<a href="criar.php">
	Voltar
</a>
<?
	$nome = $_POST['nome'];
	$teste = $_POST['teste'];
	
	$array = array( 1=>"PHP", 2=>"HTML5", 3=>"CSS3", 4=>"Javascript", 5=>"Jquery", 6=>"Postgres");

	#criando html
	$html = '<!doctype html>' . "\n";
	$html .= '<html>' . "\n";
		$html .= "\t" . '<head>' . "\n";
			$html .= "\t \t" . '<meta charset="utf-8">' . "\n";
			$html .= "\t \t" . '<title>' . "\n";
			$html .= "\t \t \t" . 'Criando HTML com <? echo $nome; ?>' . "\n";
			$html .= "\t \t" . '</title>' . "\n";
			$html .= "\t \t" . '<style>' . "\n";
				$html .= "\t \t \t" . 'body{' . "\n";
					$html .= "\t \t \t \t" . 'background:#69C;'. "\n";
				$html .= "\t \t \t" . '}'. "\n";
			$html .= "\t \t" . '</style>' ."\n";
		$html .= "\t" . '</head>' . "\n";
		$html .= "\t" . '<body>' . "\n";
			$html .= "\t \t" . '<div>' . "\n";
			for($i = 1; $i<7; $i++){					
				$html .= "\t \t \t" . "<h{$i}>Curso de {$array[$i]} e {$teste}</h{$i}>" . "\n";
			}
			$html .= "\t \t" . '</div>' . "\n";
		$html .= "\t" . '</body>' . "\n";
	$html .= '</html>' . "\n";
			
	file_put_contents("cursos.html", $html);
	
	echo "Arquivo criado com sucesso";

?>
<!--doctype html>
<html lang="pt-br">
	<head>
        <meta charset="utf-8">
        <title>
	        Criando HTML com PHP
        </title>
    </head>
	<body>    	
	</body>
</html-->