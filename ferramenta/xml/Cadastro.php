<? 
	#require_once("autoload.php");
	  
	class cadastro extends dataRegistro{
	 	#Atributos
	 	private $codigo =  NULL;
	 	private $nome =  NULL;
	 	private $email =  NULL;
	 	private $cpf =  NULL;
		private $dataInicial =  NULL;
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
	 	private function setEmail($value){
	 	 	$this->email = $value; 
	 	}
	 	public function getEmail(){
	 	 	 return $this->email;
	 	}
	 	private function setCPF($value){
	 	 	$this->cpf = $value; 
	 	}
	 	public function getCPF(){
	 	 	 return $this->cpf;
	 	}
	 	private function setDataInicial($value){
	 	 	$this->dataInicial = $value; 
	 	}
	 	public function getDataInicial(){
	 	 	$oDataInicial = NULL;
	 	 	if($this->dataInicial != ""){
	 	 		 $oDataInicial = new UtilData($this->dataInicial);
	 		}
	 		return $oDataInicial;
	 	}
	 	#Função limpar
	 	public function clear(){
	 	 	$this->setCodigo(NULL);
	 	 	$this->setNome(NULL);
	 	 	$this->setEmail(NULL);
	 	 	$this->setCPF(NULL);
	 	 	$this->setDataInicial(NULL);

	 	 	parent::clear();
	 	}
	 	#Metodos e Atualizações
	 	public function updIdcadastro($value){
	 	 	$this->codigo = $value;
	 	}
	 	public function updNome($value){
	 	 	$this->nome = $value;
	 	}
	 	public function updEmail($value){
	 	 	$this->email = $value;
	 	}
	 	public function updCPF($value){
	 	 	$this->cpf = $value;
	 	}
	 	public function updDataInicial($value){
	 	 	$this->dataInicial = $value;
	 	}
	 	#construct
	 	public function __construct($codigo = NULL,
	 	 	 	 	 	 	 	 	$nome = NULL,
	 	 	 	 	 	 	 	 	$email = NULL,
	 	 	 	 	 	 	 	 	$cpf = NULL,
	 	 	 	 	 	 	 	 	$dataInicial = NULL,
	 	 	 	 	 	 	 	 	$dataCadastro = NULL, 
	 	 	 	 	 	 	 	 	$dataAlteracao  = NULL){ 

	 	 	$this->clear();

	 	 	$this->setCodigo($codigo);
	 	 	$this->setNome($nome); 
	 	 	$this->setEmail($email); 
	 	 	$this->setCPF($cpf); 
	 	 	$this->setDataInicial($dataInicial); 

	 	 	parent::setDataCadastro($dataCadastro); 
	 	 	parent::setDataAlteracao($dataAlteracao); 
	 	}
	}
?>