<?
	#require_once("autoload.php");

	class TesteDAO{
	 	private $sql = NULL;

	 	public function getSQL(){
	 	 	return $this->sql;
	 	}
	 	private function load($rs){
	 	 	return new teste($rs->Fields("idteste"),
	 	 	 	 	 	 	 	$rs->Fields("nome"),
	 	 	 	 	 	 	 	$rs->Fields("cpf"),
	 	 	 	 	 	 	 	$rs->Fields("idrevenda"),
	 	 	 	 	 	 	 	$rs->Fields("idintegrador"),
	 	 	 	 	 	 	 	$rs->Fields("dataCadastro"),
	 	 	 	 	 	 	 	$rs->Fields("dataAlteracao"));
	 	}
	 	#ADD
	 	public function add(&$obj){
	 	 	global $db;
	 	 	$return = false;

	 	 	if(! is_null($obj)){
	 	 	 	$this->sql = "";
	 	 	 	$this->sql = sprintf('INSERT INTO "teste"  (
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"nome",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"cpf",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"idrevenda",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"idintegrador",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"dataCadastro")
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	VALUES(
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 now());',

	 	 	 	 	 	 	 	 	$obj->getNome(),
	 	 	 	 	 	 	 	 	$obj->getCpf(),
	 	 	 	 	 	 	 	 	$obj->getIdrevenda(),
	 	 	 	 	 	 	 	 	$obj->getIdintegrador(),
	 	 	 	 	 	 	 	 	);
	 	 	 	$db->BeginTrans();

	 	 	 	try{
	 	 	 	 	$db->Execute($this->sql);
	 	 	 	 	$db->CommitTrans();
	 	 	 	 	$return = true;

	 	 	 	 	$sqlInsert = sprintf("SELECT LASTVAL() as ins_id");
	 	 	 	 	$rs = $db->Execute($sqlInsert);

	 	 	 	 	$obj->updIdteste($rs->Fields("ins_id"));
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
	 	 	 	$this->sql = sprintf('UPDATE "teste" SET
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"nome" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"cpf" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"idrevenda" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"idintegrador" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"dataAlteracao" = now()
	 	 	 	 	 	 	 	 	 	 	 	 	 	WHERE "idteste" = %u;',

	 	 	 	 	 	 	 	 	$obj->getNome(),
	 	 	 	 	 	 	 	 	$obj->getCpf(),
	 	 	 	 	 	 	 	 	$obj->getIdrevenda(),
	 	 	 	 	 	 	 	 	$obj->getIdintegrador(),
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
	 	 	 	$this->sql = sprintf('DELETE FROM "teste"
	 	 	 	 	 	 	 	 	 	 	 	 	 	WHERE "idteste" = %u;',

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
	 	 	 	 	 	 	 	 	 	 	 	FROM "teste"
	 	 	 	 	 	 	 	 	 	 	 	 	ORDER BY "idteste"
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
	 	 	 	 	 	 	 	 	 	 	 	FROM "teste"
	 	 	 	 	 	 	 	 	 	 	 	 	WHERE "idteste" = %u;',
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
