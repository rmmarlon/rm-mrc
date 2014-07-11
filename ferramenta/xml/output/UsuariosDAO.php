<?
	#require_once("autoload.php");

	class UsuariosDAO{
	 	private $sql = NULL;

	 	public function getSQL(){
	 	 	return $this->sql;
	 	}
	 	private function load($rs){
	 	 	return new usuarios($rs->Fields("idusuarios"),
	 	 	 	 	 	 	 	$rs->Fields("usua_login"),
	 	 	 	 	 	 	 	$rs->Fields("usua_senha"),
	 	 	 	 	 	 	 	$rs->Fields("usua_chave"),
	 	 	 	 	 	 	 	$rs->Fields("usua_dtatua"),
	 	 	 	 	 	 	 	$rs->Fields("usua_princ"),
	 	 	 	 	 	 	 	$rs->Fields("usua_status"),
	 	 	 	 	 	 	 	$rs->Fields("pess_cod"),
	 	 	 	 	 	 	 	$rs->Fields("reve_cod"),
	 	 	 	 	 	 	 	$rs->Fields("fina_cod"),
	 	 	 	 	 	 	 	$rs->Fields("grup_cod"),
	 	 	 	 	 	 	 	$rs->Fields("usua_email"),
	 	 	 	 	 	 	 	$rs->Fields("usuario_tipo"),
	 	 	 	 	 	 	 	$rs->Fields("id_funcionario"),
	 	 	 	 	 	 	 	$rs->Fields("usua_conselho"),
	 	 	 	 	 	 	 	$rs->Fields("usua_observacao"),
	 	 	 	 	 	 	 	$rs->Fields("browser"),
	 	 	 	 	 	 	 	$rs->Fields("usua_paginacao"),
	 	 	 	 	 	 	 	$rs->Fields("usua_senha_txt"),
	 	 	 	 	 	 	 	$rs->Fields("validouemail"),
	 	 	 	 	 	 	 	$rs->Fields("usr_facebooktoken"),
	 	 	 	 	 	 	 	$rs->Fields("usr_facebookid"),
	 	 	 	 	 	 	 	$rs->Fields("usr_portalkey"),
	 	 	 	 	 	 	 	$rs->Fields("nota"),
	 	 	 	 	 	 	 	$rs->Fields("qtde_avaliacoes"),
	 	 	 	 	 	 	 	$rs->Fields("dataCadastro"),
	 	 	 	 	 	 	 	$rs->Fields("dataAlteracao"));
	 	}
	 	#ADD
	 	public function add(&$obj){
	 	 	global $db;
	 	 	$return = false;

	 	 	if(! is_null($obj)){
	 	 	 	$this->sql = "";
	 	 	 	$this->sql = sprintf('INSERT INTO "usuarios"  (
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_login",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_senha",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_chave",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_dtatua",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_princ",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_status",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"pess_cod",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_cod",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"fina_cod",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"grup_cod",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_email",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usuario_tipo",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"id_funcionario",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_conselho",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_observacao",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"browser",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_paginacao",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_senha_txt",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"validouemail",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usr_facebooktoken",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usr_facebookid",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usr_portalkey",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"nota",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"qtde_avaliacoes",
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"dataCadastro")
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	VALUES(
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %s,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 now());',

	 	 	 	 	 	 	 	 	$obj->getUsua_login(),
	 	 	 	 	 	 	 	 	$obj->getUsua_senha(),
	 	 	 	 	 	 	 	 	$obj->getUsua_chave(),
	 	 	 	 	 	 	 	 	$obj->getUsua_dtatua(),
	 	 	 	 	 	 	 	 	$obj->getUsua_princ(),
	 	 	 	 	 	 	 	 	$obj->getUsua_status(),
	 	 	 	 	 	 	 	 	$obj->getPess_cod(),
	 	 	 	 	 	 	 	 	$obj->getReve_cod(),
	 	 	 	 	 	 	 	 	$obj->getFina_cod(),
	 	 	 	 	 	 	 	 	$obj->getGrup_cod(),
	 	 	 	 	 	 	 	 	$obj->getUsua_email(),
	 	 	 	 	 	 	 	 	$obj->getUsuario_tipo(),
	 	 	 	 	 	 	 	 	$obj->getId_funcionario(),
	 	 	 	 	 	 	 	 	$obj->getUsua_conselho(),
	 	 	 	 	 	 	 	 	$obj->getUsua_observacao(),
	 	 	 	 	 	 	 	 	$obj->getBrowser(),
	 	 	 	 	 	 	 	 	$obj->getUsua_paginacao(),
	 	 	 	 	 	 	 	 	$obj->getUsua_senha_txt(),
	 	 	 	 	 	 	 	 	$obj->getValidouemail(),
	 	 	 	 	 	 	 	 	$obj->getUsr_facebooktoken(),
	 	 	 	 	 	 	 	 	$obj->getUsr_facebookid(),
	 	 	 	 	 	 	 	 	$obj->getUsr_portalkey(),
	 	 	 	 	 	 	 	 	$obj->getNota(),
	 	 	 	 	 	 	 	 	$obj->getQtde_avaliacoes(),
	 	 	 	 	 	 	 	 	);
	 	 	 	$db->BeginTrans();

	 	 	 	try{
	 	 	 	 	$db->Execute($this->sql);
	 	 	 	 	$db->CommitTrans();
	 	 	 	 	$return = true;

	 	 	 	 	$sqlInsert = sprintf("SELECT LASTVAL() as ins_id");
	 	 	 	 	$rs = $db->Execute($sqlInsert);

	 	 	 	 	$obj->updIdusuarios($rs->Fields("ins_id"));
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
	 	 	 	$this->sql = sprintf('UPDATE "usuarios" SET
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_login" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_senha" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_chave" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_dtatua" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_princ" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_status" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"pess_cod" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"reve_cod" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"fina_cod" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"grup_cod" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_email" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usuario_tipo" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"id_funcionario" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_conselho" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_observacao" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"browser" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_paginacao" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usua_senha_txt" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"validouemail" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usr_facebooktoken" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usr_facebookid" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"usr_portalkey" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"nota" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"qtde_avaliacoes" = %u,
	 	 	 	 	 	 	 	 	 	 	 	 	 	 	"dataAlteracao" = now()
	 	 	 	 	 	 	 	 	 	 	 	 	 	WHERE "idusuarios" = %u;',

	 	 	 	 	 	 	 	 	$obj->getUsua_login(),
	 	 	 	 	 	 	 	 	$obj->getUsua_senha(),
	 	 	 	 	 	 	 	 	$obj->getUsua_chave(),
	 	 	 	 	 	 	 	 	$obj->getUsua_dtatua(),
	 	 	 	 	 	 	 	 	$obj->getUsua_princ(),
	 	 	 	 	 	 	 	 	$obj->getUsua_status(),
	 	 	 	 	 	 	 	 	$obj->getPess_cod(),
	 	 	 	 	 	 	 	 	$obj->getReve_cod(),
	 	 	 	 	 	 	 	 	$obj->getFina_cod(),
	 	 	 	 	 	 	 	 	$obj->getGrup_cod(),
	 	 	 	 	 	 	 	 	$obj->getUsua_email(),
	 	 	 	 	 	 	 	 	$obj->getUsuario_tipo(),
	 	 	 	 	 	 	 	 	$obj->getId_funcionario(),
	 	 	 	 	 	 	 	 	$obj->getUsua_conselho(),
	 	 	 	 	 	 	 	 	$obj->getUsua_observacao(),
	 	 	 	 	 	 	 	 	$obj->getBrowser(),
	 	 	 	 	 	 	 	 	$obj->getUsua_paginacao(),
	 	 	 	 	 	 	 	 	$obj->getUsua_senha_txt(),
	 	 	 	 	 	 	 	 	$obj->getValidouemail(),
	 	 	 	 	 	 	 	 	$obj->getUsr_facebooktoken(),
	 	 	 	 	 	 	 	 	$obj->getUsr_facebookid(),
	 	 	 	 	 	 	 	 	$obj->getUsr_portalkey(),
	 	 	 	 	 	 	 	 	$obj->getNota(),
	 	 	 	 	 	 	 	 	$obj->getQtde_avaliacoes(),
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
	 	 	 	$this->sql = sprintf('DELETE FROM "usuarios"
	 	 	 	 	 	 	 	 	 	 	 	 	 	WHERE "idusuarios" = %u;',

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
	 	 	 	 	 	 	 	 	 	 	 	FROM "usuarios"
	 	 	 	 	 	 	 	 	 	 	 	 	ORDER BY "idusuarios"
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
	 	 	 	 	 	 	 	 	 	 	 	FROM "usuarios"
	 	 	 	 	 	 	 	 	 	 	 	 	WHERE "idusuarios" = %u;',
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
