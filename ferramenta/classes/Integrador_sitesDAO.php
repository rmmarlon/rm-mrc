<?
	require_once("autoload.php");

	class Integrador_sitesDAO{
	 	private $sql = NULL;

	 	public function getSQL(){
	 	 	return $this->sql;
	 	}
	 	private function load($rs){
	 	 	return new Integrador_sites($rs->Fields("id_integrador_site"),
			 	 	 	 	 	 	 	$rs->Fields("nome"),
			 	 	 	 	 	 	 	$rs->Fields("url"),
			 	 	 	 	 	 	 	$rs->Fields("imagem_logo"),
			 	 	 	 	 	 	 	$rs->Fields("ativo"),
			 	 	 	 	 	 	 	$rs->Fields("data_cadastro"),
			 	 	 	 	 	 	 	$rs->Fields("flagnome"),
			 	 	 	 	 	 	 	$rs->Fields("dataCadastro"),
			 	 	 	 	 	 	 	$rs->Fields("dataAlteracao"));
	 	}
	 	#ADD
	 	public function add(&$obj){
	 	 	global $db;
	 	 	$return = false;

	 	 	if(! is_null($obj)){
	 	 	 	$this->sql = "";
	 	 	 	$this->sql = sprintf('INSERT INTO "integrador_sites"  ("nome",
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"url",
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"imagem_logo",
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"ativo",
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"data_cadastro",
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"flagnome",
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"dataCadastro")
																VALUES(%s,
																		 %s,
																		 %s,
																		 %u,
																		 %s,
																		 %s,
																		 now());',

	 	 	 	 	 	 	 	 	$db->qstr($obj->getNome()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getUrl()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getImagem_logo()),
	 	 	 	 	 	 	 	 	$obj->getAtivo(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getData_cadastro()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getFlagnome()));
	 	 	 	$db->BeginTrans();

	 	 	 	try{
	 	 	 	 	$db->Execute($this->sql);
	 	 	 	 	$db->CommitTrans();
	 	 	 	 	$return = true;

	 	 	 	 	$sqlInsert = sprintf("SELECT LASTVAL() as ins_id");
	 	 	 	 	$rs = $db->Execute($sqlInsert);

	 	 	 	 	$obj->updId_Integrador_site($rs->Fields("ins_id"));
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
	 	 	 	$this->sql = sprintf('UPDATE "integrador_sites" SET
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	"nome" = %s,
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	"url" = %s,
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	"imagem_logo" = %s,
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	"ativo" = %u,
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	"data_cadastro" = %s,
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	"flagnome" = %s,
			 	 	 	 	 	 	 	 	 	 	 	 	 	 	"dataAlteracao" = now()
	 	 	 	 	 	 	 	 	 	 	 	 	 			WHERE "id_integrador_site" = %u;',

	 	 	 	 	 	 	 	 	$db->qstr($obj->getNome()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getUrl()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getImagem_logo()),
	 	 	 	 	 	 	 	 	$obj->getAtivo(),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getData_cadastro()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getFlagnome()),
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
	 	 	 	$this->sql = sprintf('DELETE FROM "integrador_sites"
	 	 	 	 	 	 	 	 	 	WHERE "id_integrador_site" = %u;',

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
		 	 	 	 	 	 	 	 		FROM "integrador_sites"
 	 	 	 	 	 	 	 	 	 		ORDER BY "id_integrador_site"
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
	 	 	 	 	 	 	 	 	 		FROM "integrador_sites"
	 	 	 	 	 	 	 	 	 	 	WHERE "idintegrador_sites" = %u;',
		 	 	 	 	 	 	 	 	 	$key);

	 	 	 	 	$rs = $db->Execute($this->sql);

	 	 	 	 	if(! $rs->EOF){
	 	 	 	 	 	$return = $this->load($rs);
	 	 	 	 	}
	 	 	 	 	$rs->close();
	 	 	 	break;
	 	 	}
	 	 	return $return;
	 	}
	}
?>
