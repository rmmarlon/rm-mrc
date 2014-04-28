<?
	if(!isset($_POST['name'])){
		$_POST['name'] = NULL;
	}
	if(!isset($_POST['field'])){
		$_POST['field'] = NULL;
	}
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
			$(document).ready(function(e){
				$("#btnAdd").click(function(){
					$("#campos").append('<p class="fields"><input type="text" name="field[]"></p>');
				});
				$("#btnRemove").click(function(){
					$(".fields:last").remove();
				});
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
						<input type="text" name="name">
					</p>
					<input type="button" id="btnAdd" value="+">
					<input type="button" id="btnRemove" value="-">
					<div id="campos"></div>
					<br>
					<input type="submit" value="Criar">
						<?
							
							
						?>
				</form>
			</article>
		</section>
	</body>
</html>
