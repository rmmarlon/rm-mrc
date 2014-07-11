<? 
	#require_once("autoload.php");
	  
	class Usuarios extends DataRegistro{
	 	#Atributos
	 	private $codigo =  NULL;
	 	private $usua_login =  NULL;
	 	private $usua_senha =  NULL;
	 	private $usua_chave =  NULL;
	 	private $usua_dtatua =  NULL;
	 	private $usua_princ =  NULL;
	 	private $usua_status =  NULL;
	 	private $pess_cod =  NULL;
	 	private $reve_cod =  NULL;
	 	private $fina_cod =  NULL;
	 	private $grup_cod =  NULL;
	 	private $usua_email =  NULL;
	 	private $usuario_tipo =  NULL;
		private $id_funcionario =  NULL;
	 	private $usua_conselho =  NULL;
	 	private $usua_observacao =  NULL;
	 	private $browser =  NULL;
	 	private $usua_paginacao =  NULL;
	 	private $usua_senha_txt =  NULL;
	 	private $validouemail =  NULL;
	 	private $usr_facebooktoken =  NULL;
	 	private $usr_facebookid =  NULL;
	 	private $usr_portalkey =  NULL;
	 	private $nota =  NULL;
	 	private $qtde_avaliacoes =  NULL;
	 	#SET e GET
	 	private function setCodigo($value){
	 	 	$this->codigo = $value; 
	 	}
	 	public function getCodigo(){
	 	 	 return $this->codigo;
	 	}
	 	private function setUsua_login($value){
	 	 	$this->usua_login = $value; 
	 	}
	 	public function getUsua_login(){
	 	 	 return $this->usua_login;
	 	}
	 	private function setUsua_senha($value){
	 	 	$this->usua_senha = $value; 
	 	}
	 	public function getUsua_senha(){
	 	 	 return $this->usua_senha;
	 	}
	 	private function setUsua_chave($value){
	 	 	$this->usua_chave = $value; 
	 	}
	 	public function getUsua_chave(){
	 	 	 return $this->usua_chave;
	 	}
	 	private function setUsua_dtatua($value){
	 	 	$this->usua_dtatua = $value; 
	 	}
	 	public function getUsua_dtatua(){
	 	 	 return $this->usua_dtatua;
	 	}
	 	private function setUsua_princ($value){
	 	 	$this->usua_princ = $value; 
	 	}
	 	public function getUsua_princ(){
	 	 	 return $this->usua_princ;
	 	}
	 	private function setUsua_status($value){
	 	 	$this->usua_status = $value; 
	 	}
	 	public function getUsua_status(){
	 	 	 return $this->usua_status;
	 	}
	 	private function setPess_cod($value){
	 	 	$this->pess_cod = $value; 
	 	}
	 	public function getPess_cod(){
	 	 	 return $this->pess_cod;
	 	}
	 	private function setReve_cod($value){
	 	 	$this->reve_cod = $value; 
	 	}
	 	public function getReve_cod(){
	 	 	 return $this->reve_cod;
	 	}
	 	private function setFina_cod($value){
	 	 	$this->fina_cod = $value; 
	 	}
	 	public function getFina_cod(){
	 	 	 return $this->fina_cod;
	 	}
	 	private function setGrup_cod($value){
	 	 	$this->grup_cod = $value; 
	 	}
	 	public function getGrup_cod(){
	 	 	 return $this->grup_cod;
	 	}
	 	private function setUsua_email($value){
	 	 	$this->usua_email = $value; 
	 	}
	 	public function getUsua_email(){
	 	 	 return $this->usua_email;
	 	}
	 	private function setUsuario_tipo($value){
	 	 	$this->usuario_tipo = $value; 
	 	}
	 	public function getUsuario_tipo(){
	 	 	 return $this->usuario_tipo;
	 	}
	 	private function setId_funcionario($value){
	 	 	$this->id_funcionario = $value; 
	 	}
	 	public function getId_funcionario(){
	 		/*if(! isset($o_funcionario)){
	 			$o_funcionario = NULL;
	 		}
	 		if(is_null($o_funcionario)){
	 			$dao = new CadastroDAO();
	 			$o_funcionario = $dao->select(1, $this->id_funcionario);
	 		}
	 		unset($dao);
	 		return $o_funcionario;*/
	 		return $this->Id_funcionario;
	 	}
	 	private function setUsua_conselho($value){
	 	 	$this->usua_conselho = $value; 
	 	}
	 	public function getUsua_conselho(){
	 	 	 return $this->usua_conselho;
	 	}
	 	private function setUsua_observacao($value){
	 	 	$this->usua_observacao = $value; 
	 	}
	 	public function getUsua_observacao(){
	 	 	 return $this->usua_observacao;
	 	}
	 	private function setBrowser($value){
	 	 	$this->browser = $value; 
	 	}
	 	public function getBrowser(){
	 	 	 return $this->browser;
	 	}
	 	private function setUsua_paginacao($value){
	 	 	$this->usua_paginacao = $value; 
	 	}
	 	public function getUsua_paginacao(){
	 	 	 return $this->usua_paginacao;
	 	}
	 	private function setUsua_senha_txt($value){
	 	 	$this->usua_senha_txt = $value; 
	 	}
	 	public function getUsua_senha_txt(){
	 	 	 return $this->usua_senha_txt;
	 	}
	 	private function setValidouemail($value){
	 	 	$this->validouemail = $value; 
	 	}
	 	public function getValidouemail(){
	 	 	 return $this->validouemail;
	 	}
	 	private function setUsr_facebooktoken($value){
	 	 	$this->usr_facebooktoken = $value; 
	 	}
	 	public function getUsr_facebooktoken(){
	 	 	 return $this->usr_facebooktoken;
	 	}
	 	private function setUsr_facebookid($value){
	 	 	$this->usr_facebookid = $value; 
	 	}
	 	public function getUsr_facebookid(){
	 	 	 return $this->usr_facebookid;
	 	}
	 	private function setUsr_portalkey($value){
	 	 	$this->usr_portalkey = $value; 
	 	}
	 	public function getUsr_portalkey(){
	 	 	 return $this->usr_portalkey;
	 	}
	 	private function setNota($value){
	 	 	$this->nota = $value; 
	 	}
	 	public function getNota(){
	 	 	 return $this->nota;
	 	}
	 	private function setQtde_avaliacoes($value){
	 	 	$this->qtde_avaliacoes = $value; 
	 	}
	 	public function getQtde_avaliacoes(){
	 	 	 return $this->qtde_avaliacoes;
	 	}
	 	#Função limpar
	 	public function clear(){
	 	 	$this->setCodigo(NULL);
	 	 	$this->setUsua_login(NULL);
	 	 	$this->setUsua_senha(NULL);
	 	 	$this->setUsua_chave(NULL);
	 	 	$this->setUsua_dtatua(NULL);
	 	 	$this->setUsua_princ(NULL);
	 	 	$this->setUsua_status(NULL);
	 	 	$this->setPess_cod(NULL);
	 	 	$this->setReve_cod(NULL);
	 	 	$this->setFina_cod(NULL);
	 	 	$this->setGrup_cod(NULL);
	 	 	$this->setUsua_email(NULL);
	 	 	$this->setUsuario_tipo(NULL);
	 	 	$this->setId_funcionario(NULL);
	 	 	$this->setUsua_conselho(NULL);
	 	 	$this->setUsua_observacao(NULL);
	 	 	$this->setBrowser(NULL);
	 	 	$this->setUsua_paginacao(NULL);
	 	 	$this->setUsua_senha_txt(NULL);
	 	 	$this->setValidouemail(NULL);
	 	 	$this->setUsr_facebooktoken(NULL);
	 	 	$this->setUsr_facebookid(NULL);
	 	 	$this->setUsr_portalkey(NULL);
	 	 	$this->setNota(NULL);
	 	 	$this->setQtde_avaliacoes(NULL);

	 	 	parent::clear();
	 	}
	 	#Metodos e Atualizações
	 	public function updIdusuarios($value){
	 	 	$this->codigo = $value;
	 	}
	 	public function updUsua_login($value){
	 	 	$this->usua_login = $value;
	 	}
	 	public function updUsua_senha($value){
	 	 	$this->usua_senha = $value;
	 	}
	 	public function updUsua_chave($value){
	 	 	$this->usua_chave = $value;
	 	}
	 	public function updUsua_dtatua($value){
	 	 	$this->usua_dtatua = $value;
	 	}
	 	public function updUsua_princ($value){
	 	 	$this->usua_princ = $value;
	 	}
	 	public function updUsua_status($value){
	 	 	$this->usua_status = $value;
	 	}
	 	public function updPess_cod($value){
	 	 	$this->pess_cod = $value;
	 	}
	 	public function updReve_cod($value){
	 	 	$this->reve_cod = $value;
	 	}
	 	public function updFina_cod($value){
	 	 	$this->fina_cod = $value;
	 	}
	 	public function updGrup_cod($value){
	 	 	$this->grup_cod = $value;
	 	}
	 	public function updUsua_email($value){
	 	 	$this->usua_email = $value;
	 	}
	 	public function updUsuario_tipo($value){
	 	 	$this->usuario_tipo = $value;
	 	}
	 	public function updId_funcionario($value){
	 	 	$this->id_funcionario = $value;
	 	}
	 	public function updUsua_conselho($value){
	 	 	$this->usua_conselho = $value;
	 	}
	 	public function updUsua_observacao($value){
	 	 	$this->usua_observacao = $value;
	 	}
	 	public function updBrowser($value){
	 	 	$this->browser = $value;
	 	}
	 	public function updUsua_paginacao($value){
	 	 	$this->usua_paginacao = $value;
	 	}
	 	public function updUsua_senha_txt($value){
	 	 	$this->usua_senha_txt = $value;
	 	}
	 	public function updValidouemail($value){
	 	 	$this->validouemail = $value;
	 	}
	 	public function updUsr_facebooktoken($value){
	 	 	$this->usr_facebooktoken = $value;
	 	}
	 	public function updUsr_facebookid($value){
	 	 	$this->usr_facebookid = $value;
	 	}
	 	public function updUsr_portalkey($value){
	 	 	$this->usr_portalkey = $value;
	 	}
	 	public function updNota($value){
	 	 	$this->nota = $value;
	 	}
	 	public function updQtde_avaliacoes($value){
	 	 	$this->qtde_avaliacoes = $value;
	 	}
	 	#construct
	 	public function __construct($codigo = NULL,
	 	 	 	 	 	 	 	 	$usua_login = NULL,
	 	 	 	 	 	 	 	 	$usua_senha = NULL,
	 	 	 	 	 	 	 	 	$usua_chave = NULL,
	 	 	 	 	 	 	 	 	$usua_dtatua = NULL,
	 	 	 	 	 	 	 	 	$usua_princ = NULL,
	 	 	 	 	 	 	 	 	$usua_status = NULL,
	 	 	 	 	 	 	 	 	$pess_cod = NULL,
	 	 	 	 	 	 	 	 	$reve_cod = NULL,
	 	 	 	 	 	 	 	 	$fina_cod = NULL,
	 	 	 	 	 	 	 	 	$grup_cod = NULL,
	 	 	 	 	 	 	 	 	$usua_email = NULL,
	 	 	 	 	 	 	 	 	$usuario_tipo = NULL,
	 	 	 	 	 	 	 	 	$id_funcionario = NULL,
	 	 	 	 	 	 	 	 	$usua_conselho = NULL,
	 	 	 	 	 	 	 	 	$usua_observacao = NULL,
	 	 	 	 	 	 	 	 	$browser = NULL,
	 	 	 	 	 	 	 	 	$usua_paginacao = NULL,
	 	 	 	 	 	 	 	 	$usua_senha_txt = NULL,
	 	 	 	 	 	 	 	 	$validouemail = NULL,
	 	 	 	 	 	 	 	 	$usr_facebooktoken = NULL,
	 	 	 	 	 	 	 	 	$usr_facebookid = NULL,
	 	 	 	 	 	 	 	 	$usr_portalkey = NULL,
	 	 	 	 	 	 	 	 	$nota = NULL,
	 	 	 	 	 	 	 	 	$qtde_avaliacoes = NULL,
	 	 	 	 	 	 	 	 	$dataCadastro = NULL, 
	 	 	 	 	 	 	 	 	$dataAlteracao  = NULL){ 

	 	 	$this->clear();

	 	 	$this->setCodigo($codigo);
	 	 	$this->setUsua_login($usua_login); 
	 	 	$this->setUsua_senha($usua_senha); 
	 	 	$this->setUsua_chave($usua_chave); 
	 	 	$this->setUsua_dtatua($usua_dtatua); 
	 	 	$this->setUsua_princ($usua_princ); 
	 	 	$this->setUsua_status($usua_status); 
	 	 	$this->setPess_cod($pess_cod); 
	 	 	$this->setReve_cod($reve_cod); 
	 	 	$this->setFina_cod($fina_cod); 
	 	 	$this->setGrup_cod($grup_cod); 
	 	 	$this->setUsua_email($usua_email); 
	 	 	$this->setUsuario_tipo($usuario_tipo); 
	 	 	$this->setId_funcionario($id_funcionario); 
	 	 	$this->setUsua_conselho($usua_conselho); 
	 	 	$this->setUsua_observacao($usua_observacao); 
	 	 	$this->setBrowser($browser); 
	 	 	$this->setUsua_paginacao($usua_paginacao); 
	 	 	$this->setUsua_senha_txt($usua_senha_txt); 
	 	 	$this->setValidouemail($validouemail); 
	 	 	$this->setUsr_facebooktoken($usr_facebooktoken); 
	 	 	$this->setUsr_facebookid($usr_facebookid); 
	 	 	$this->setUsr_portalkey($usr_portalkey); 
	 	 	$this->setNota($nota); 
	 	 	$this->setQtde_avaliacoes($qtde_avaliacoes); 

	 	 	parent::setDataCadastro($dataCadastro); 
	 	 	parent::setDataAlteracao($dataAlteracao); 
	 	}
	}
?>