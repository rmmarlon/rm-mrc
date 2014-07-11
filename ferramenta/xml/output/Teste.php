<? 
	#require_once("autoload.php");
	  
	class Teste extends dataRegistro{
	 	#Atributos
	 	private $codigo =  NULL;
	 	private $nome =  NULL;
	 	private $cpf =  NULL;
		private $idRevenda =  NULL;
		private $idIntegrador =  NULL;
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
	 	private function setCPF($value){
	 	 	$this->cpf = $value; 
	 	}
	 	public function getCPF(){
	 	 	 return $this->cpf;
	 	}
	 	private function setIdRevenda($value){
	 	 	$this->idRevenda = $value; 
	 	}
	 	public function getIdRevenda(){
	 		/*if(! isset($oRevenda)){
	 			$oRevenda = NULL;
	 		}
	 		if(is_null($oRevenda)){
	 			$dao = new CadastroDAO();
	 			$oRevenda = $dao->select(1, $this->idRevenda);
	 		}
	 		unset($dao);
	 		return $oRevenda;*/
	 		return $this->IdRevenda;
	 	}
	 	private function setIdIntegrador($value){
	 	 	$this->idIntegrador = $value; 
	 	}
	 	public function getIdIntegrador(){
	 		/*if(! isset($oIntegrador)){
	 			$oIntegrador = NULL;
	 		}
	 		if(is_null($oIntegrador)){
	 			$dao = new CadastroDAO();
	 			$oIntegrador = $dao->select(1, $this->idIntegrador);
	 		}
	 		unset($dao);
	 		return $oIntegrador;*/
	 		return $this->IdIntegrador;
	 	}
	 	#Função limpar
	 	public function clear(){
	 	 	$this->setCodigo(NULL);
	 	 	$this->setNome(NULL);
	 	 	$this->setCPF(NULL);
	 	 	$this->setIdRevenda(NULL);
	 	 	$this->setIdIntegrador(NULL);

	 	 	parent::clear();
	 	}
	 	#Metodos e Atualizações
	 	public function updIdteste($value){
	 	 	$this->codigo = $value;
	 	}
	 	public function updNome($value){
	 	 	$this->nome = $value;
	 	}
	 	public function updCPF($value){
	 	 	$this->cpf = $value;
	 	}
	 	public function updIdRevenda($value){
	 	 	$this->idRevenda = $value;
	 	}
	 	public function updIdIntegrador($value){
	 	 	$this->idIntegrador = $value;
	 	}
	 	#construct
	 	public function __construct($codigo = NULL,
	 	 	 	 	 	 	 	 	$nome = NULL,
	 	 	 	 	 	 	 	 	$cpf = NULL,
	 	 	 	 	 	 	 	 	$idRevenda = NULL,
	 	 	 	 	 	 	 	 	$idIntegrador = NULL,
	 	 	 	 	 	 	 	 	$dataCadastro = NULL, 
	 	 	 	 	 	 	 	 	$dataAlteracao  = NULL){ 

	 	 	$this->clear();

	 	 	$this->setCodigo($codigo);
	 	 	$this->setNome($nome); 
	 	 	$this->setCPF($cpf); 
	 	 	$this->setIdRevenda($idRevenda); 
	 	 	$this->setIdIntegrador($idIntegrador); 

	 	 	parent::setDataCadastro($dataCadastro); 
	 	 	parent::setDataAlteracao($dataAlteracao); 
	 	}
	}
?>