<?
	#require_once("autoload.php");

	class cadastroDAO{
	 	private $sql = NULL;

	 	public function getSQL(){
	 	 	return $this->sql;
	 	}
	 	private function load($rs){
	 	 	return new cadastro($rs->Fields("idcadastro"),
	 	 	 	 	 	 	 	$rs->Fields("nome"),
	 	 	 	 	 	 	 	$rs->Fields("email"),
	 	 	 	 	 	 	 	$rs->Fields("cpf"),
	 	 	 	 	 	 	 	$rs->Fields("cnpj"),
	 	 	 	 	 	 	 	$rs->Fields("dataCadastro"),
	 	 	 	 	 	 	 	$rs->Fields("dataAlteracao"));
	 	}
	 	#ADD
	 	public function add(&$obj){
	 	 	global $db;
	 	 	$return = false;

	 	 	if(! is_null($obj)){
	 	 	 	$this->sql = "";
	 	 	 	$this->sql = sprintf('INSERT INTO "cadastro"  (
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"nome",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"email",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"cpf",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"cnpj",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"dataCadastro")
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	VALUES(
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 now());',

	 	 	 	 	 	 	 	 	$db->qstr($obj->getNome()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getEmail()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getCpf()),
	 	 	 	 	 	 	 	 	$db->qstr($obj->getCnpj()),
	 	 	 	 	 	 	 	 	);
	 	 	 	$db->BeginTrans();

	 	 	 	try{
	 	 	 	 	$db->Execute($this->sql);
	 	 	 	 	$db->CommitTrans();
	 	 	 	 	$return = true;

	 	 	 	 	$sqlInsert = sprintf("SELECT LASTVAL() as ins_id");
	 	 	 	 	$rs = $db->Execute($sqlInsert);

	 	 	 	 	$obj->updIdcadastro($rs->Fields("ins_id"));
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
	 	 	 	$this->sql = sprintf('UPDATE "cadastro" SET
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"nome" = %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"email" = %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"cpf" = %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"cnpj" = %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"dataAlteracao" = now()
	 	 	 	 	 	 	 	 	 	 	 	 	 	WHERE "idcadastro" = %u;',

	 	 	 	 	 	 	 	 	$obj->getNome(),
	 	 	 	 	 	 	 	 	$obj->getEmail(),
	 	 	 	 	 	 	 	 	$obj->getCpf(),
	 	 	 	 	 	 	 	 	$obj->getCnpj(),
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
	 	 	 	$this->sql = sprintf('DELETE FROM "cadastro"
	 	 	 	 	 	 	 	 	 	 	 	 	 	WHERE "idcadastro" = %u;',

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
	 	 	 	 	 	 	 	 	 	 	 	FROM "cadastro"
	 	 	 	 	 	 	 	 	 	 	 	 	ORDER BY "idcadastro"
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
	 	 	 	 	 	 	 	 	 	 	 	FROM "cadastro"
	 	 	 	 	 	 	 	 	 	 	 	 	WHERE "idcadastro" = %u;',
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
