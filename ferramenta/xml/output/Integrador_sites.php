<? 
	#require_once("autoload.php");
	  
	class Integrador_sites extends DataRegistro{
	 	#Atributos
	 	private $codigo =  NULL;
	 	private $nome =  NULL;
	 	private $url =  NULL;
	 	private $imagem_logo =  NULL;
	 	private $ativo =  NULL;
		private $data_cadastro =  NULL;
	 	private $flagnome =  NULL;
	 	#SET e GET
	 	private function setCodigo($value){
	 	 	$this->codigo = $value; 
	 	}
	 	public function getCodigo(){
	 	 	 return $this->codigo;
	 	}
	 	private function setNome($value){
	 	 	$this->nome = $value; 
	 	}
	 	public function getNome(){
	 	 	 return $this->nome;
	 	}
	 	private function setUrl($value){
	 	 	$this->url = $value; 
	 	}
	 	public function getUrl(){
	 	 	 return $this->url;
	 	}
	 	private function setImagem_logo($value){
	 	 	$this->imagem_logo = $value; 
	 	}
	 	public function getImagem_logo(){
	 	 	 return $this->imagem_logo;
	 	}
	 	private function setAtivo($value){
	 	 	$this->ativo = $value; 
	 	}
	 	public function getAtivo(){
	 	 	 return $this->ativo;
	 	}
	 	private function setData_cadastro($value){
	 	 	$this->data_cadastro = $value; 
	 	}
	 	public function getData_cadastro(){
	 	 	$oData_cadastro = NULL;
	 	 	if($this->data_cadastro != ""){
	 	 		 $oData_cadastro = new UtilData($this->data_cadastro);
	 		}
	 		return $oData_cadastro;
	 	}
	 	private function setFlagnome($value){
	 	 	$this->flagnome = $value; 
	 	}
	 	public function getFlagnome(){
	 	 	 return $this->flagnome;
	 	}
	 	#Função limpar
	 	public function clear(){
	 	 	$this->setCodigo(NULL);
	 	 	$this->setNome(NULL);
	 	 	$this->setUrl(NULL);
	 	 	$this->setImagem_logo(NULL);
	 	 	$this->setAtivo(NULL);
	 	 	$this->setData_cadastro(NULL);
	 	 	$this->setFlagnome(NULL);

	 	 	parent::clear();
	 	}
	 	#Metodos e Atualizações
	 	public function updIdintegrador_sites($value){
	 	 	$this->codigo = $value;
	 	}
	 	public function updNome($value){
	 	 	$this->nome = $value;
	 	}
	 	public function updUrl($value){
	 	 	$this->url = $value;
	 	}
	 	public function updImagem_logo($value){
	 	 	$this->imagem_logo = $value;
	 	}
	 	public function updAtivo($value){
	 	 	$this->ativo = $value;
	 	}
	 	public function updData_cadastro($value){
	 	 	$this->data_cadastro = $value;
	 	}
	 	public function updFlagnome($value){
	 	 	$this->flagnome = $value;
	 	}
	 	#construct
	 	public function __construct($codigo = NULL,
	 	 	 	 	 	 	 	 	$nome = NULL,
	 	 	 	 	 	 	 	 	$url = NULL,
	 	 	 	 	 	 	 	 	$imagem_logo = NULL,
	 	 	 	 	 	 	 	 	$ativo = NULL,
	 	 	 	 	 	 	 	 	$data_cadastro = NULL,
	 	 	 	 	 	 	 	 	$flagnome = NULL,
	 	 	 	 	 	 	 	 	$dataCadastro = NULL, 
	 	 	 	 	 	 	 	 	$dataAlteracao  = NULL){ 

	 	 	$this->clear();

	 	 	$this->setCodigo($codigo);
	 	 	$this->setNome($nome); 
	 	 	$this->setUrl($url); 
	 	 	$this->setImagem_logo($imagem_logo); 
	 	 	$this->setAtivo($ativo); 
	 	 	$this->setData_cadastro($data_cadastro); 
	 	 	$this->setFlagnome($flagnome); 

	 	 	parent::setDataCadastro($dataCadastro); 
	 	 	parent::setDataAlteracao($dataAlteracao); 
	 	}
	}
?>