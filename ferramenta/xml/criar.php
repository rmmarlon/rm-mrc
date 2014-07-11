<?
	if(! isset($_POST['cursos'])){
		$_POST['cursos'] = NULL;
	}
	if(! isset($cursos)){
		$cursos = NULL;
	}
	if(! isset($_POST['chaves'])){
		$_POST['chaves'] = NULL;
	}
	if(! isset($chaves)){
		$chaves = NULL;
	}
	if(! isset($_POST['descricao'])){
		$_POST['descricao'] = NULL;
	}
	if(! isset($chaves)){
		$descricao = NULL;
	}
	$chaves = array(1=>$_POST['chaves']);
	$chaves = array(1=>$_POST['descricao']);
	$cursos = array(1=>$_POST['cursos']);
	
?>
<!doctype html>
<html>
	<head>
        <meta charset="utf-8">
        <title>
        	Criando arquivo
        </title>
        <link rel="stylesheet" type="text/css" href="../personalizado/style.css">
        <script src="../tool/jquery.js"></script>
        <script>
			$(document).ready(function(e) {
				var valor = 0;
                $("#btn").click(function(e) {
					valor += 1;
                    $("#variavel").append('<input type="text" style="text-transform:lowercase" name="cursos[]" id="'+valor+'" class="cursos"><input type="text" name="chaves[]" size="1" style="text-transform:lowercase" class="cursos2"><br>');
                });
				$(".fechar").live('click', function(e) {
                   $(".cursos:last,.cursos2:last,br:last").remove();
                });
				$(".fecharDescricao").live('click', function(e) {
                   $(".cursos:last").remove();
                });
				$(".cursos").live('blur',function(e) {
                    if($(this).val().substr(0,2) == 'in'){
						$("#descricao").append('<p><input type="button" name="btnDescricao" id="btnDescricao" value="+"><input type="button"  class="fecharDescricao" value="-"><br></p>');
					}
                });
				$("#btnDescricao").live('click',function(e) {
                    $("#descricao").append('<p><input type="text" name="descricao[]" class="cursos"></p>');
                });
            });
		</script>	
	</head>
    <body>
    	<form method="post" action="criandoPHP.php">
        	<fieldset style="width:50%; margin:auto">
            	<legend align="center">
                	Criando Classes
                </legend>
                <p align="center">
                    <input type="text" style="text-transform:capitalize" name="nome" id="nome" title="Nome da classe">
                </p>
                <div class="clear"></div>
                <!--p>
                    <label class="labelForm">Teste</label>
                    <input type="text" name="teste" id="teste">
                </p-->
                <div class="clear"></div>

                <div class="clear"></div>
                <div id="variavel" style="width:200px; height:200px; float:left; background:#cc6">
                	<p>
                        <input type="button" name="btn" id="btn" value="+">
                        <input type="button"  class="fechar" value="-">
                    </p>
                </div>
                <div id="descricao" style="width:200px; height:200px; float:right;background:#66c"></div>
                <div class="clear"></div>
                <p>
                    <input type="submit" name="btnCria" id="btnCadastrar" value="Criar">
                </p>
             </fieldset>
        </form>
    </body>
</html>
