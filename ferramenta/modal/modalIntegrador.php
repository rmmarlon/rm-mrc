<div id="modalIntegrador" class="window dados" style="width:40%">
	<input type="button" class="close btn-danger floatRight" style="opacity:1.0" value="X">
	<div class="clear"></div>
	<div style="height:300px; overflow:auto">
<?
		$dao = new Integrador_sitesDAO();
		$oLI = $dao->select(0);
		
		if(! is_null($oLI)){
			foreach($oLI as $oI){

?>
				<div id="text">
					<p>
						<? echo $oI->getCodigo() . ' - ' . $oI->getNome(); ?>
					</p>
				</div>
				<div id="botao">
					<a href="#" class="inSeleciona" idIntegrador="<? echo $oI->getCodigo(); ?>" nomeIntegrador="<? echo $oI->getNome(); ?>" title="selecione o Integrador">
						<img src="img/ativo.png" width="16" height="16" alt="Selecionar">
					</a>
				</div>
				<div class="clear"></div>
				<hr />
<?
			}
		}
?>
	</div>
</div>