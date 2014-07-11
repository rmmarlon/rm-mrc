<?
   /**
            Autor : Leandro Ferreira Marcelli
             Data : 01/08/2012

          Arquivo : inc.dataRegistro.php
        Descriчуo : include para atributos de dataCadastro e dataAlteracao

       Data        Responsсvel         Breve definiчуo
       ==========  ==================  ==================================================
       01/08/2012  Leandro F Marcelli  Definiчуo inicial
   */
	
	class DataRegistro{
		# atributos
		protected $dataCadastro = NULL;
		protected $dataAlteracao = NULL;
		
		
		# getДs & setДs
		protected function setDataCadastro($value){
			$obj = NULL;
			if (! is_null($value)){
				$obj = new UtilData($value);
			}
			
			$this->dataCadastro = $obj;
			unset($obj);
		}
		
		public function getDataCadastro(){
			return $this->dataCadastro;
		}
		
		protected function setDataAlteracao($value){
			$obj = NULL;
			if (! is_null($value)){
				$obj = new UtilData($value);
			}
			
			$this->dataAlteracao = $obj;
			unset($obj);
		}
		
		public function getDataAlteracao(){
			return $this->dataAlteracao;
		}
		
		
		# metodos
		protected function clear(){
			$this->setDataCadastro(NULL);
			$this->setDataAlteracao(NULL);
		}
		
		
		# construtor
		public function __construct($dataCadastro = NULL,
		                            $dataAlteracao = NULL){
			$this->clear();
											 
			$this->setDataCadastro($dataCadastro);
			$this->setDataAltertacao($dataAlteracao);
		}
	}
?>