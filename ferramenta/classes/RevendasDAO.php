<?
	require_once("autoload.php");

	class RevendasDAO{
	 	private $sql = NULL;

	 	public function getSQL(){
	 	 	return $this->sql;
	 	}
	 	private function load($rs){
	 	 	return new Revendas($rs->Fields("reve_cod"),
	 	 	 	 	 	 	 	$rs->Fields("reve_dtcadastro"),
	 	 	 	 	 	 	 	$rs->Fields("reve_razao"),
	 	 	 	 	 	 	 	$rs->Fields("reve_cnpj"),
	 	 	 	 	 	 	 	$rs->Fields("reve_ie"),
	 	 	 	 	 	 	 	$rs->Fields("reve_email"),
	 	 	 	 	 	 	 	$rs->Fields("reve_url"),
	 	 	 	 	 	 	 	$rs->Fields("reve_status"),
	 	 	 	 	 	 	 	$rs->Fields("pess_cod"),
	 	 	 	 	 	 	 	$rs->Fields("reve_nota_vend"),
	 	 	 	 	 	 	 	$rs->Fields("reve_vencimento"),
	 	 	 	 	 	 	 	$rs->Fields("reve_texto"),
	 	 	 	 	 	 	 	$rs->Fields("reve_dtaniver1"),
	 	 	 	 	 	 	 	$rs->Fields("reve_dtaniver2"),
	 	 	 	 	 	 	 	$rs->Fields("reve_foto"),
	 	 	 	 	 	 	 	$rs->Fields("qtd_carros_vitrine"),
	 	 	 	 	 	 	 	$rs->Fields("reve_cont_02"),
	 	 	 	 	 	 	 	$rs->Fields("reve_cont_01"),
	 	 	 	 	 	 	 	$rs->Fields("dt_cancelamento"),
	 	 	 	 	 	 	 	$rs->Fields("dt_alteracao"),
	 	 	 	 	 	 	 	$rs->Fields("id_pacote"),
	 	 	 	 	 	 	 	$rs->Fields("reve_produtos"),
	 	 	 	 	 	 	 	$rs->Fields("texto_servico"),
	 	 	 	 	 	 	 	$rs->Fields("texto_comochegar"),
	 	 	 	 	 	 	 	$rs->Fields("id_representante"),
	 	 	 	 	 	 	 	$rs->Fields("id_filialbv"),
	 	 	 	 	 	 	 	$rs->Fields("id_codbv"),
	 	 	 	 	 	 	 	$rs->Fields("operador_bv"),
	 	 	 	 	 	 	 	$rs->Fields("qtde_contratos"),
	 	 	 	 	 	 	 	$rs->Fields("valor_bonificado"),
	 	 	 	 	 	 	 	$rs->Fields("tipo_faturamento"),
	 	 	 	 	 	 	 	$rs->Fields("tipo_pessoa"),
	 	 	 	 	 	 	 	$rs->Fields("valor_mensalidade"),
	 	 	 	 	 	 	 	$rs->Fields("reve_im"),
	 	 	 	 	 	 	 	$rs->Fields("id_serie"),
	 	 	 	 	 	 	 	$rs->Fields("reve_modelo_nfe"),
	 	 	 	 	 	 	 	$rs->Fields("cod_clas_fis_cod"),
	 	 	 	 	 	 	 	$rs->Fields("cnae_cod"),
	 	 	 	 	 	 	 	$rs->Fields("integrador"),
	 	 	 	 	 	 	 	$rs->Fields("reve_dominio_exp"),
	 	 	 	 	 	 	 	$rs->Fields("dataCadastro"),
	 	 	 	 	 	 	 	$rs->Fields("dataAlteracao"));
	 	}
	 	#ADD
	 	public function add(&$obj){
	 	 	global $db;
	 	 	$return = false;

	 	 	if(! is_null($obj)){
	 	 	 	$this->sql = "";
	 	 	 	$this->sql = sprintf('INSERT INTO "revendas" ("reve_dtcadastro",
																"reve_razao",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_cnpj",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_ie",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_email",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_url",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"inreve_status",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"pess_cod",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_nota_vend",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_vencimento",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_texto",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_dtaniver1",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_dtaniver2",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_foto",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"qtd_carros_vitrine",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_cont_02",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_cont_01",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"dt_cancelamento",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"dt_alteracao",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"id_pacote",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_produtos",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"texto_servico",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"texto_comochegar",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"id_representante",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"id_filialbv",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"id_codbv",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"operador_bv",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"qtde_contratos",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"valor_bonificado",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"tipo_faturamento",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"tipo_pessoa",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"valor_mensalidade",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_im",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"id_serie",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_modelo_nfe",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"cod_clas_fis_cod",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"cnae_cod",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"integrador",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_dominio_exp",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"dataCadastro")
														  VALUES(%s,
																 %s,
																 %s,
																 %s,
																 %s,
																 %s,
																 %u,
																 %u,
																 %s,
																 %u,
																 %s,
																 %s,
																 %s,
																 %u,
																 %u,
																 %s,
																 %s,
																 %s,
																 %s,
																 %u,
																 %s,
																 %s,
																 %s,
																 %u,
																 %u,
																 %s,
																 %s,
																 %u,
																 %0,2f,
																 %s,
																 %s,
																 %0,2f,
																 %s,
																 %u,
																 %u,
																 %u,
																 %u,
																 %u,
																 %s,
																 now());',

	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_dtcadastro()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_razao()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_cnpj()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_ie()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_email()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_url()),
	 	 	 	 	 	 	 	 	$obj->getReve_status(),
	 	 	 	 	 	 	 	 	$obj->getPess_cod(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_nota_vends()),
	 	 	 	 	 	 	 	 	$obj->getReve_vencimento(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_texto()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_dtaniver1()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_dtaniver2()),
	 	 	 	 	 	 	 	 	$obj->getReve_foto(),
	 	 	 	 	 	 	 	 	$obj->getQtd_carros_vitrine(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_cont_02()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_cont_01()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getDt_cancelamento()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getDt_alteracao()),
	 	 	 	 	 	 	 	 	$obj->getId_pacote(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_produtos()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getTexto_servico()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getTexto_comochegar()),
	 	 	 	 	 	 	 	 	$obj->getId_representante(),
	 	 	 	 	 	 	 	 	$obj->getId_filialbv(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getId_codbv()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getOperador_bv()),
	 	 	 	 	 	 	 	 	$obj->getQtde_contratos(),
	 	 	 	 	 	 	 	 	$obj->getValor_bonificado(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getTipo_faturamento()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getTipo_pessoa()),
	 	 	 	 	 	 	 	 	$obj->getValor_mensalidade(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_im()),
	 	 	 	 	 	 	 	 	$obj->getId_serie(),
	 	 	 	 	 	 	 	 	$obj->getReve_modelo_nfe(),
	 	 	 	 	 	 	 	 	$obj->getCod_clas_fis_cod(),
	 	 	 	 	 	 	 	 	$obj->getCnae_cod(),
	 	 	 	 	 	 	 	 	$obj->getIntegrador(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_dominio_exp()));
	 	 	 	$db->BeginTrans();

	 	 	 	try{
	 	 	 	 	$db->Execute($this->sql);
	 	 	 	 	$db->CommitTrans();
	 	 	 	 	$return = true;

	 	 	 	 	$sqlInsert = sprintf("SELECT LASTVAL() as ins_id");
	 	 	 	 	$rs = $db->Execute($sqlInsert);

	 	 	 	 	$obj->updReve_cod($rs->Fields("ins_id"));
	 	 	 	} catch(exception $e){
	 	 	 	 	$db->RollBackTrans();
	 	 	 	}
	 	 	}
	 	 	return $return;
	 	}
	 	#UPDATE
	 	public function update(&$obj){
	 	 	global $db;
	 	 	$return = false;
	 	 	$this->sql = "";

	 	 	if(! is_null($obj)){
	 	 	 	$this->sql = sprintf('UPDATE "revendas" SET
															"reve_dtcadastros" = s,
															"reve_razao" = s,
															"reve_cnpj" = s,
															"reve_ie" = s,
															"reve_email" = s,
															"reve_url" = s,
															"reve_status" = u,
															"pess_cod" = u,
															"reve_nota_vend" = s,
															"reve_vencimento" = u,
															"reve_texto" = s,
															"reve_dtaniver1" = s,
															"reve_dtaniver2" = s,
															"reve_foto" = u,
															"qtd_carros_vitrine" = u,
															"reve_cont_02" = s,
															"reve_cont_01" = s,
															"dt_cancelamento" = s,
															"dt_alteracao" = s,
															"id_pacote" = u,
															"reve_produtos" = s,
															"texto_servico" = s,
															"texto_comochegar" = s,
															"id_representanteu" = u,
															"id_filialbv" = u,
															"id_codbvs" = s,
															"operador_bv" = s,
															"qtde_contratos" = u,
															"valor_bonificado" = 0,2f
															"tipo_faturamentos" = s,
															"tipo_pessoa" = s,
															"valor_mensalidade0" = 0,
															"reve_im" = s,
															"id_serie" = u,
															"reve_modelo_nfe" = u,
															"cod_clas_fis_cod" = u,
															"cnae_cod" = u,
															"integrador" = u,
															"reve_dominio_exp" = s,
															"dataAlteracao" = now()
														WHERE "reve_cod" = %u;',

	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_dtcadastro()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_razao()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_cnpj()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_ie()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_email()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_url()),
	 	 	 	 	 	 	 	 	$obj->getReve_status(),
	 	 	 	 	 	 	 	 	$obj->getPess_cod(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_nota_vends()),
	 	 	 	 	 	 	 	 	$obj->getReve_vencimento(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_texto()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_dtaniver1()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_dtaniver2()),
	 	 	 	 	 	 	 	 	$obj->getReve_foto(),
	 	 	 	 	 	 	 	 	$obj->getQtd_carros_vitrine(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_cont_02()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_cont_01()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getDt_cancelamento()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getDt_alteracao()),
	 	 	 	 	 	 	 	 	$obj->getId_pacote(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_produtos()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getTexto_servico()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getTexto_comochegar()),
	 	 	 	 	 	 	 	 	$obj->getId_representante(),
	 	 	 	 	 	 	 	 	$obj->getId_filialbv(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getId_codbv()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getOperador_bv()),
	 	 	 	 	 	 	 	 	$obj->getQtde_contratos(),
	 	 	 	 	 	 	 	 	$obj->getValor_bonificado(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getTipo_faturamento()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getTipo_pessoa()),
	 	 	 	 	 	 	 	 	$obj->getValor_mensalidade(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_im()),
	 	 	 	 	 	 	 	 	$obj->getId_serie(),
	 	 	 	 	 	 	 	 	$obj->getReve_modelo_nfe(),
	 	 	 	 	 	 	 	 	$obj->getCod_clas_fis_cod(),
	 	 	 	 	 	 	 	 	$obj->getCnae_cod(),
	 	 	 	 	 	 	 	 	$obj->getIntegrador(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getReve_dominio_exp()),
	 	 	 	 	 	 	 	 	$obj->getCodigo());
	 	 	 	$db->BeginTrans();

	 	 	 	try{
	 	 	 	 	$db->Execute($this->sql);
	 	 	 	 	$db->CommitTrans();
	 	 	 	 	$return = true;
	 	 	 	} catch(exception $e){
	 	 	 	 	$db->RollBackTrans();
	 	 	 	}
	 	 	}
	 	 	return $return;
	 	}
	 	#DELETE
	 	public function delete(&$obj){
	 	 	global $db;
	 	 	$return = false;
	 	 	$this->sql = "";

	 	 	if(! is_null($obj)){
	 	 	 	$this->sql = sprintf('DELETE FROM "revendas"
	 	 	 	 	 	 	 	 	 	 	 WHERE "reve_cod" = %u;',

	 	 	 	 	 	 	 	 	$obj->getCodigo());
	 	 	 	$db->BeginTrans();

	 	 	 	try{
	 	 	 	 	$db->Execute($this->sql);
	 	 	 	 	$db->CommitTrans();
	 	 	 	 	$return = true;
	 	 	 	} catch(exception $e){
	 	 	 	 	$db->RollBackTrans();
	 	 	 	}
	 	 	}
	 	 	return $return;
	 	}
	 	#SELECT
	 	public function select($option = 0,
	 	 	 	 	 	 	 	 	$key = NULL,
	 	 	 	 	 	 	 	 	$order = NULL){
	 	 	global $db;
	 	 	$return = NULL;
	 	 	$this->sql = "";

	 	 	switch($option){
	 	 	 	case 0:
	 	 	 	 	$this->sql = sprintf('SELECT *
	 	 	 	 	 	 	 	 	 	 	 	FROM "revendas"
	 	 	 	 	 	 	 	 	 	 	 	ORDER BY "reve_cod"
	 	 	 	 	 	 	 	 	 	 	 	LIMIT(1000)');

	 	 	 	 	$rs = $db->Execute($this->sql);

	 	 	 	 	while(! $rs->EOF){
	 	 	 	 	 	$return[] = $this->load($rs);
	 	 	 	 	 	$rs->MoveNext();
	 	 	 	 	}
	 	 	 	 	$rs->close();
	 	 	 	break;
	 	 	 	case 1:
	 	 	 	 	$this->sql = sprintf('SELECT *
	 	 	 	 	 	 	 	 	 	 	 	FROM "revendas"
	 	 	 	 	 	 	 	 	 	 	 	WHERE "reve_cod" = %u;',
	 	 	 	 	 	 	 	 	 	$key);

	 	 	 	 	$rs = $db->Execute($this->sql);

	 	 	 	 	if(! $rs->EOF){
	 	 	 	 	 	$return = $this->load($rs);
	 	 	 	 	}
	 	 	 	 	$rs->close();
	 	 	 	break;
				
				case 2:
	 	 	 	 	$this->sql = sprintf('SELECT *
	 	 	 	 	 	 	 	 	 	 	 	FROM "revendas"
	 	 	 	 	 	 	 	 	 	 	 	WHERE "reve_status" = 1;');

	 	 	 	 	$rs = $db->Execute($this->sql);

	 	 	 	 	while(! $rs->EOF){
	 	 	 	 	 	$return[] = $this->load($rs);
	 	 	 	 	 	$rs->MoveNext();
	 	 	 	 	}
	 	 	 	 	$rs->close();
	 	 	 	break;
				
				case 3:
	 	 	 	 	$this->sql = sprintf('SELECT * 
											FROM "revendas"
											WHERE "reve_status" = 1
											OFFSET %u
											LIMIT %u;',
                                            $key[0],
                                            $key[1]);
											/* # Bruno, esta consulta esta pronta para trazer todas as revendas ativas na paginação, 
												só é preciso a sua validação/aprovação para executa-lá.
											*/

	 	 	 	 	$rs = $db->Execute($this->sql);

	 	 	 	 	while(! $rs->EOF){
	 	 	 	 	 	$return[] = $this->load($rs);
	 	 	 	 	 	$rs->MoveNext();
	 	 	 	 	}
	 	 	 	 	$rs->close();
	 	 	 	break;
	 	 	}
	 	 	return $return;
	 	}
	}
?>
