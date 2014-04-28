<?
	if(!isset($_POST['name'])){
		$_POST['name'] = NULL;
	}
	if(!isset($_POST['field'])){
		$_POST['field'] = NULL;
	}
?>

<?
    /*select com a funcao initcap() que funciona == a funcção php ucwords
    SELECT INITCAP("pais_nome")
    from nfe_pais
    se for em aspas simples ele imprime o valor(no caso pais_nome)
    se for em aspas duplas ele imprime o campo(no caso pais_nome)
    */
?>
<!doctype>
<html>
	<head>
		<meta charset="utf-8">
		<title>
			Criar arquivos
		</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>
		<script type="text/javascript">
            function replaceAll(string, token, newToken){
                while(string.indexOf(token) != -1){
                    string = string.replace(token, newToken);
                }
                return string;
            }
			$(document).ready(function(e){

				$("#btnAdd").click(function(){
					$("#campos").append('<p class="fields"><input type="text" name="field[]"></p>');
				});
				$("#btnRemove").click(function(){
					$(".fields:last").remove();
				});
                var buffer = "bancos operacao";
                if(/^[cnae|ncm|cfop]{3,4}$/i.test(buffer.substr(-4))){
                    alert(buffer.substr(buffer.indexOf(' ')+1));
                }
                //resolver /^[cnae|ncm|cfop]{3,4}$/i.test(value.substr(-4).trim())
			});
		</script>
	</head>
	<body>
		<section style="margin:auto; width:50%">
			<header>
				Crair arquivos
			</header>
			<article>
				<form method="post" action="gerar_arquivos.php">
					<p>
						<input type="text" name="name" id="repla">
					</p>
					<input type="button" id="btnAdd" value="+">
					<input type="button" id="btnRemove" value="-">
					<div id="campos"></div>
					<br>
					<input type="submit" value="Criar">
                    <?
                        $email = "cfop";
                        if(preg_match("/^[cnae|ncm|cfop]{3,4}$/i", $email))
                            echo strtoupper($email);
                        else
                            echo $email;
                    ?>
				</form>
			</article>
		</section>
	</body>
</html>
