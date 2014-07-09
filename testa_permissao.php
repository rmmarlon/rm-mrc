<?
	chmod('agencias/agencias/lista.php', 0200);
?>
<!DOCTYPE>
<html>
	<body>
		<head>
			<meta charset="utf-8">
			<title>
				Teste de permissão
			</title>
			<script>
				window.onload = function()
				{
					trar_data_do_db();
				}
				function trar_data_do_db() {
					var str = "How are you doing today?";
					var data = "2014-06-12";
					var newDate = data.split('-');
				   
					var res = str.split(" ");
					document.getElementById("splitSubs").innerHTML=newDate[2]+"/"+newDate[1]+"/"+newDate[0];
				}
			</script>
		</head>
		<div>
			<p id="splitSubs"></p>
			<p>
				<?
					//split js == explode php
					$val = "teste de array no corte das palavras";
					$val = explode(" ",$val);
					for($i=0;$i<5;$i++)
					{
						echo "array na posição: {$i} ". $val[$i].'<br>';
					}
				?>
			</p>
		</div>
	</body>
</html>


================================permi?s chmod=========================
drwx
Funciona da seguinte forma: o primeiro caractere dos atributos diz se o arquivo é um diretório ou um arquivo. Se tiver o "d" indica que é diretório.
os proximos caracteres se dividem em 3 grupos de 3 caracteres
então fica
d rwx rwx rwx

   1. d: tipo de arquivo (diretório);
   2. rwx: permissões do proprietário e/ou usuário;
   3. rwx : permissões para usuários do mesmo grupo;
   4. rwx: permissões para todos usuários. 
	
significado de rwx
	r - read(permissãde leitura)
	w - white(permissãde escrita)
	x - execute(permissãde execu?)
	
O chmod tem a flexibilidade de trabalhar com valores decimais de 0 a 7. Cada valor tem uma combinação de permissões pelos 3 grupos de caracteres que expliquei acima. Vamos à elas. 

0 : --- (nenhuma permissão)
1 : --x (somente execução)
2 : -w- (somente escrita)
3 : -wx (escrita e execução)
4 : r-- (somente leitura)
5 : r-x (leitura e execução)
6 : rw- (leitura e escrita)
7 : rwx (leitura, escrita e execução)


755
rwx r-x r-x
755
rwx r-x r-x