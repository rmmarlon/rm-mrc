	<?
	require_once("autoload.php");

	class Cadastro extends DataRegistro{
		#atributos
		private $codigo = NULL;
		private $nome = NULL;
		private $senha = NULL;
		private $cpf = NULL;
		private $email = NULL;
		#Set e Get
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
		
		private function setSenha($value){
			$this->senha = $value;
		}
		
		public function getSenha(){
			return $this->senha;
		}
		
		private function setCPF($value){
			$this->cpf = $value;	
		}
		
		public function getCPF(){
			return $this->cpf;	
		}
		private function setEmail($value){
			$this->email = $value;
		}
		
		public function getEmail(){
			return $this->email;
		}
		#Função Limpar
		public function clear(){
			$this->setCodigo(NULL);
			$this->setNome(NULL);
			$this->setSenha(NULL);
			$this->setCPF(NULL);
			$this->setEmail(NULL);
			
			parent::clear();
		}
		#métodos de atualizações
		public function updIdCadastro($value){
		$this->codigo = $value;
		}
		public function updNome($value){
			$this->nome = $value;
		}
		public function updSenha($value){
			$this->senha = $value;
		}
		public function updCPF($value){
			$this->cpf = $value;
		}
		public function updEmail($value){
			$this->email = $value;
		}
		#construtor
		public function __construct($codigo = NULL,
											 $nome = NULL,
											 $senha = NULL,
											 $cpf = NULL,
											 $email = NULL,
											 $dataCadastro = NULL,
											 $dataAlteracao = NULL){
			$this->clear();
			
			$this->setCodigo($codigo);
			$this->setNome($nome);
			$this->setSenha($senha);
			$this->setCPF($cpf);
			$this->setEmail($email);
			
			parent::setDataCadastro($dataCadastro);
			parent::setDataAlteracao($dataAlteracao);
		}
	}
?>