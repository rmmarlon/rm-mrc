<?
	require_once("controleSessao.php");
	require_once("classes/autoload.php");
	require_once("conADODBopen.php");
	require_once("tool/funcoes.php");
	
	if(! isset($_POST['acao'])){
		$_POST['acao'] = NULL;
	}
	if(!isset($_POST['codigo'])){
		$_POST['codigo'] = NULL;
	}
	if(!isset($_POST['integrador'])){
		$_POST['integrador'] = NULL;
	}
	$integrador = $_POST['integrador'];
	$codigo = $_POST['codigo'];
/*	
	### Bruno, estas são as querys para o UPDATE, estão comentadas para serem análizadas e validada,
	caso esteja de acordo e correto para uso real.####
	
	#####################caso o integrador escolhido seja Meu carro novo este if será executado##############################
	if($_POST['acao'] == 'reenviar' && $integrador == 2){
		$sql = sprintf('UPDATE veiculos_web 
							SET 
								publicar_meucarronovo = 1,
								enviado_meucarronovo = false
							WHERE veic_cod IN (SELECT v.veic_cod
							FROM "public"."veiculos_web" vw join veiculos v USING (veic_cod)
							WHERE reve_cod = %u 
							AND veic_situacao < 3 
							AND publicar_meucarronovo = 1)',
							$codigo);
							
		$query = pg_query($sql);
		if(pg_affected_rows($query) > 0){
			$_SESSION['msg'] = "Reenvio da loja: {$codigo} no Integrador: {$integrador} executado com sucesso";
		} else{
			$_SESSION['msg'] = "Não foi possével reenviar loja: {$codigo} no Integrador: {$integrador}!!";
		}
	} 
	
	#########################caso o integrador escolhido seja Web Motors este if será executado#######################
	if($_POST['acao'] == 'reenviar' && $integrador == 3){
		$sql = sprintf('UPDATE veiculos_web 
							SET 
								enviado_webmotors = false
							WHERE veic_cod IN (select v.veic_cod FROM veiculos V 
							INNER JOIN veiculos_web W ON (V.veic_cod = W.veic_cod) 
							WHERE (veic_situacao < 3) 
							AND V.reve_cod = %u
							AND veic_cod_webmotors IS NOT NULL)',
							$codigo);
							
		$query = pg_query($sql);
		if(pg_affected_rows($query) > 0){
			$_SESSION['msg'] = "Reenvio da loja: {$codigo} no Integrador: {$integrador} executado com sucesso";
		} else{
			$_SESSION['msg'] = "Não foi possével reenviar loja: {$codigo} no Integrador: {$integrador}!!";
		}
	}

	#####################caso o integrador escolhido seja Só Carrão este if será executado####################
	if($_POST['acao'] == 'reenviar' && $integrador == 4){
		$sql = sprintf('UPDATE veiculos_web 
							SET
								publicar_socarrao = 1,
								veic_cod_socarrao = null,
								enviado_socarrao = false
							WHERE veic_cod IN (select v.veic_cod FROM veiculos V 
							INNER JOIN veiculos_web W ON (V.veic_cod = W.veic_cod) 
							WHERE (veic_situacao < 3) 
							AND V.reve_cod = %u 
							AND marc_cod_socarrao IS NOT NULL)',
							$codigo);
		
		$query = pg_query($sql);
		if(pg_affected_rows($query) > 0){
			$_SESSION['msg'] = "Reenvio da loja: {$codigo} no Integrador: {$integrador} executado com sucesso";
		} else{
			$_SESSION['msg'] = "Não foi possével reenviar loja: {$codigo} no Integrador: {$integrador}!!";
		}
	}
*/
?>
<!doctype html>
<html>
	<head> 		
        <title>
        	Área de UPDATE
        </title>
		<meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="personalizado/estilo.css">
		<link rel="stylesheet" type="text/css" href="personalizado/bootstrap.min.css">
        <script src="tool/jquery.js"></script>
		<script src="tool/bootbox.min.js"></script>
		<script src="tool/bootstrap.min.js"></script>
		<script src="tool/script.js"></script>
        <script>
			$(document).ready(function(e) {	
				$(".inSeleciona").click(function(e) {
					var idIntegrador = $(this).attr('idIntegrador');
					var nomeIntegrador = $(this).attr('nomeIntegrador');
					$("#integrador").val(idIntegrador);
					$("#spnIntegrador").html(nomeIntegrador);
					$(".close").trigger('click');
                });
				$("#btnVoltar").click(function(e) {
                    $("form").attr('action', 'areaAutenticada.php');
					$("form").submit();
                });
                $("#btnEnviar").click(function() {
					var idRev = $("#codigo").attr('value');
					var nomeRev =  $("#nome").html();
					var idInt = $("#integrador").attr('value');
					var nomeInt =  $("#spnIntegrador").html();
					if($("#integrador").val() == ''){
						bootbox.alert('<strong>Favor selecionar o integrador</strong>');
					} else{
						bootbox.confirm('Deseja mesmo reenviar?', function(valida){
							if(valida){
								$("#acao").val('reenviar');
								$("form").submit();
							}
						});
					}
                });
            });
		</script>
        <style>
			#text{
				width:90%;
				float:left;
			}
			#botao{
				width:10%;
				float:right;
			}
			#integrador, #codigo{
				width:16%;
			}
		</style>
	</head>
	<body>
		<? if(isset($_POST['idRevendas'])){ ?>
			<div class="dados">
				<h3 style="padding-bottom:5%; margin:auto; text-align:center; border-radius:10px 10px 0 0">
					Reenviar
				</h3>
<?		
				$dao = new RevendasDAO();
				$oR = $dao->select(1, $_POST['idRevendas']);
?>
				<form method="post">
					<input type="hidden" name="acao" id="acao">
                    <div class="form-group">
						<label class="col-md-1 control-label">
							Código
						</label>
                        <div class="col-md-9">
                            <input type="text" name="codigo" class="form-control" id="codigo" value="<? echo $oR->getCodigo(); ?>" readonly>
                        </div>
					</div>
                    <div class="clear"></div>
					<div class="form-group">
						<label class="col-md-1 control-label">
							Loja
						</label>
                        <div class="col-md-9">
                            <span id="nome"><? echo $oR->getReve_razao(); ?></span>
                        </div>
					</div>
                    <div class="clear"></div>
                    <div class="form-group">
                        <label class="col-md-1 control-label">
                            Integrador
                        </label>
                        <div class="col-md-5">
                            <input type="text" name="integrador" class="form-control pull-left" id="integrador" readonly="readonly">
                            <span id="spnIntegrador"></span>
                            <a href="#modalIntegrador" name="modal" title="Pesquisar integrador">
                                <img src="img/pesquisar.png" width="16" height="16" alt="Pesquisar">
                            </a>
                        </div>
                    </div>
					<div class="clear"></div>
					<div class="floatRightMargin">
						<input type="button" id="btnVoltar" class="btn" value="Voltar">
						<input type="button" id="btnEnviar" class="btn btn-primary" value="Enviar">
					</div>
					<div class="clear"><br></div>
				</form>
			</div>
<?
		} else {
			echo '<meta http-equiv="refresh" content="1; url=areaAutenticada.php" />';
		}
?>


	</body>
</html>
<?
	require_once("modal/modalIntegrador.php");
	require_once("tool/alerta.php");
	require_once("conADODBclose.php");
?>