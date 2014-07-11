<?php
   /**
            Autor : Leandro Ferreira Marcelli
             Data : 01/08/2012

          Arquivo : UtilData.php
        Descriчуo : Funчѕes њteis no tratamento de datas

       Data        Responsсvel         Breve definiчуo
       ==========  ==================  ==================================================
       01/08/2012  Leandro F Marcelli  Definiчуo inicial
   */

	class UtilData{
		# atributos
		private $data = NULL;
		
		# getДs & setДs
		private function setData($valor){
			$this->data = strtotime($valor);
		}
		
		private function getData(){
			return $this->data;
		}
		
		
		# metodos
		public function getYMD(){
			return date("Y-m-d", $this->getData());
		}
		
		public function getDMY(){
			return date("d/m/Y", $this->getData());
		}

      public function getDMYHMS(){
			return date("d/m/Y H:i:s", $this->getData());
		}

      public function getHour(){
			return date("H:i:s", $this->getData());
		}

		public function getD(){
			return date("d", $this->getData());
		}
		
		public function getM(){
			return date("m", $this->getData());
		}
		
		public function getY(){
			return date("Y", $this->getData());
		}		   
       # construtor e destrutor
       public function __construct($data){
          $this->setData($data);
       }
   }
?>