<?
	require_once("controleSessao.php");
	require_once("conADODBopen.php");
	require_once("classes/autoload.php");
	require_once("tool/funcoes.php");
	###################paginação estruturada#####################
	#$cmd = "select * from revendas limit 10";
    #$produtos = pg_query($cmd);
    #$total = pg_num_rows($produtos);
	
	#$cmd = "select * from revendas ORDER BY reve_status OFFSET $inicio limit $registros";
    #$produtos = pg_query($cmd);
    #$total = pg_num_rows($produtos);
	
	#consulta para trazer os dados do usuário logado.
    $dao = new UsuariosDAO();
    $oU = $dao->select(1, $_SESSION['lojaAutenticada']);
	####################Paginação Orientada a Objeto#######################
    $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
	
	$dao = new RevendasDAO();
	$oLR = $dao->select(2);#Bruno a limitação desta consulta foi feita para análisar e testar a paginação
	$totalRegistros = count($oLR);
	
    $registro[1] = 15;

    $numPaginas = ceil($totalRegistros/$registro[1]);
    $registro[0] = ($registro[1]*$pagina)-$registro[1];
	
	$dao = new RevendasDAO();
	$oLR = $dao->select(3 ,$registro);
	$total = count($oLR);
	###############Fim paginação O.O############
	################### Função para saber em qual pagina se está ao cilcar no link 
	#(<a class='btn ".paginacao($i)."' href='areaAutenticada.php?pagina=".$i."'>".$i."</a>)#####################
	function paginacao($pagina){
		if(isset($_GET['pagina']) && $_GET['pagina'] == $pagina
			|| ! isset($_GET['pagina']) && $pagina == 1){
			return 'btn-primary';
		} else{
			return '';
		}
	}
?>
<!doctype html>
<html>
	<head>
        <meta charset="utf-8">
        <title>
        	Área de UPDATE
        </title>
		<link rel="stylesheet" type="text/css" href="personalizado/estilo.css">
		<link rel="stylesheet" type="text/css" href="personalizado/bootstrap.min.css">
        <script src="tool/jquery.js"></script>        
        <script src="tool/script.js"></script>
        <script>
			$(document).ready(function(e) {
                $(".detalhes").click(function(e) {
                    var idCadastro = $(this).attr('idCadastro');
					var nome = $(this).attr('nome');
					$("#codigo").val(idCadastro);
					$("#nome").val(nome);
                });
				$(".inSeleciona").click(function(e) {
					var idIntegrador = $(this).attr('idIntegrador');
					var nomeIntegrador = $(this).attr('nomeIntegrado');
					$("#integrador").val(idIntegrador);
					$("#spnIntegrador").html(nomeIntegrador);
					$(".close").trigger('click');
                });
				$(".callpage").click(function(e) {
                    $("#idRevendas").val($(this).attr('id'));
					$("form").attr('action', 'atualiza.php');
					$("form").submit();                    
                });
				$("#spnDesce").click(function(){
					$("#paginacao").css('height','auto')
					$("#spnDesce").hide();
					$("#spnSobe").show();
				});
				$("#spnSobe").click(function(){
					$("#paginacao").css('height','22px');
					$("#spnSobe").hide();
					$("#spnDesce").show();
				});
            });
		</script>
        <style>
			.table, tr{
				background:#eee;
			}
			
		</style>
	</head>
	<body>
    	<div style="margin:auto; width:60%;">
            <h3 align="center">
<?
				$sql = sprintf("select * from pessoas where pess_cod = %u", $oU->getPess_cod());
				$query = pg_query($sql);
				if($linha = pg_fetch_array($query)){;
					echo $linha['pess_nome'];
				}
?>
            </h3>
			<a href="encerraSessao.php">
				<img src="img/icone-sair.png" width="16" height="16" alt="Sair">
			</a>
			<div class="clear"></div>
            <form method="post">
            	<input type="hidden" name="idRevendas" id="idRevendas">
                <table width="100%" class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th style="text-align:center">
                                Código
                            </th>
                            <th>
                                Loja
                            </th>
                            <th style="text-align:center">
                                Situação
                            </th>
                            <th style="text-align:center">
                                Atualizar
                            </th>
                        </tr>
                    </thead>
                    <tbody>
<?
						if(! is_null($oLR)){
							foreach($oLR as $oR){
?>
                                <tr>
                                    <td style="text-align:center">
                                        <? echo $oR->getCodigo(); ?>
                                    </td>
                                    <td>
                                        <span title="<? echo $oR->getReve_razao(); ?>"><? if(strlen($oR->getReve_razao()) > 25) {echo substr($oR->getReve_razao(),0,25) . '...'; } else{ echo $oR->getReve_razao(); } ?></span>
                                    </td>
                                    <td style="text-align:center">
                                        <? echo $oR->getReve_statusDescricao(); ?>
                                    </td>
                                    <td style="text-align:center">
                                        <a href="#" class="callpage" title="Reenviar" id="<? echo $oR->getCodigo(); ?>">
                                            <img src="img/seta3d 4 design fire.png" width="20" height="20">
                                        </a>
                                    </td>
                                </tr>
<?
							}
						}
?>
                    </tbody>
					<tfoot>
						<tr>
							<th colspan="2"></th>
							<th colspan="2">
								<span>Total de registros: </span><?= $totalRegistros; ?>
							</th>
						</tr>
					</tfoot>
                </table>
<!--#Bruno, esta condição foi feita para quando o número de paginas for maior que 18, seja visualizado um
# botão para ver/ocultar o restante dos botões (<a class='btn ".paginacao($i)."' href='areaAutenticada.php?pagina=".$i."'>".$i."</a>)
-->
				<? 	if($numPaginas > 18): ?>
					<div id="btnPaginacao" style="float:right;width:10%; height:21px; margin:auto;">
						<span style="float:left;display:none" id="spnSobe"><img src="img/seta_cima.png"/></span>
						<span style="float:left" id="spnDesce"><img src="img/seta_baixo.png"/></span>
					</div>
				<? endif; ?>
<?
                    paginacaoBtn($pagina,'areaAutenticada',$numPaginas);
?>
				<div style="clear:both"></div>
                <hr style="border-color:#ddd" />
            </form>
        </div>
	</body>
</html>
<?	
	require_once("tool/alerta.php");
	require_once("conADODBclose.php");
?>