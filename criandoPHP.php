<?
	echo '<h3 align="center>Criando Classes"</h3>';
	
	$nome = $_POST['nome'];
	#$teste = $_POST['teste'];	
	$cursos = $_POST['cursos'];
	$chaves = $_POST['chaves'];
	#$descricao = $_POST['descricao'];

	////////////////////////CLASS ///////////////////////////
	$php = '<? ' . "\n";
		$php .= "\t" . '#require_once("autoload.php");' . "\n";
		$php .= "\t  \n";
		$php .= "\t" . 'class ' . $nome . ' extends dataRegistro{' . "\n";
			$php .= "\t \t" . '#Atributos' . "\n";
			$php .= "\t \t" . 'private $codigo =  NULL;' . "\n";
			foreach($cursos as $indice => $valor){
				if(substr($valor,0,4) == 'data'){
					$php .= "\t\t" . 'private $' . strtolower(substr($valor,0,4)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . ' =  NULL;' . "\n";
				} else if(substr($valor,0,2) == 'in' || substr($valor,0,2) == 'id'){
					$php .= "\t\t" . 'private $' . strtolower(substr($valor,0,2)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . ' =  NULL;' . "\n";
				} else{
					$php .= "\t \t" . 'private $' . $valor . ' =  NULL;' . "\n";
				}
			}
			$php .= "\t \t" . '#SET e GET' . "\n";			
			$php .= "\t \t" . 'private function setCodigo($value){' . "\n";
			$php .= "\t \t \t" . '$this->codigo = $value; ' . "\n";
			$php .= "\t \t" . '}' . "\n";
			$php .= "\t \t" . 'public function getCodigo(){' . "\n";
			$php .= "\t \t \t" . ' return $this->codigo;' . "\n";
			$php .= "\t \t" . '}' . "\n";
			foreach($cursos as $indice => $valor){
				if($valor == 'cpf' || $valor == 'Cpf' || $valor == 'cnpj' || $valor == 'Cnpj' || $valor == 'Rg' || $valor == 'rg'){
					$php .= "\t \t" . 'private function set' . strtoupper($valor) . '($value){' . "\n";
					$php .= "\t \t \t" . '$this->' . $valor . ' = $value; ' . "\n";
					$php .= "\t \t" . '}' . "\n";

					$php .= "\t \t" . 'public function get' . strtoupper($valor) . '(){' . "\n";
					$php .= "\t \t \t" . ' return $this->' . $valor . ';' . "\n";
					$php .= "\t \t" . '}' . "\n";
				} else{
					if(substr($valor,0,4) == 'data'){
						$php .= "\t \t" . 'private function set' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,3)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . '($value){' . "\n";
						$php .= "\t \t \t" . '$this->' . strtolower(substr($valor,0,4)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . ' = $value; ' . "\n";
						$php .= "\t \t" . '}' . "\n";
						
						$php .= "\t \t" . 'public function get' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,3)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . '(){' . "\n";
						$php .= "\t \t \t" . '$o' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,3)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . ' = NULL;' . "\n";
						$php .= "\t \t \t" . 'if($this->' . strtolower(substr($valor,0,4)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . ' != ""){' . "\n";
						$php .= "\t \t \t\t" . ' $o' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,3)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . ' = new UtilData($this->' . strtolower(substr($valor,0,4)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . ');' . "\n";
						$php .= "\t \t\t" . '}' . "\n";
						$php .= "\t \t\t" . 'return $o' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,3)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . ';' . "\n";
						$php .= "\t \t" . '}' . "\n";
					} else if(substr($valor,0,2) == 'in' || substr($valor,0,2) == 'id'){
						$php .= "\t \t" . 'private function set' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,1)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . '($value){' . "\n";
						$php .= "\t \t \t" . '$this->' . strtolower(substr($valor,0,2)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . ' = $value; ' . "\n";
						$php .= "\t \t" . '}' . "\n";
						if(substr($valor,0,2) == 'id'){
							$php .= "\t \t" . 'public function get' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,1)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . '(){' . "\n";
							$php .= "\t \t\t" . 'if(! isset($o' . strtoupper(substr($valor,2,1)) .strtolower(substr($valor,3)) . ')){' . "\n";
							$php .= "\t \t\t\t" . '$o' . strtoupper(substr($valor,2,1)) .strtolower(substr($valor,3)) . ' = NULL;' . "\n";
							$php .= "\t \t\t" . '}' . "\n";
							$php .= "\t \t\t" . 'if(is_null($o' . strtoupper(substr($valor,2,1)) .strtolower(substr($valor,3)) . ')){' . "\n";
							$php .= "\t \t\t\t" . '$dao = new CadastroDAO();' . "\n";
							$php .= "\t \t\t\t" . '$o' . strtoupper(substr($valor,2,1)) .strtolower(substr($valor,3)) . ' = $dao->select(1, $this->' . strtolower(substr($valor,0,2)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)).');' . "\n";
							$php .= "\t \t\t" . '}' . "\n";
							$php .= "\t \t\t" . 'unset($dao);' . "\n";
							$php .= "\t \t\t" . 'return $o' . strtoupper(substr($valor,2,1)) .strtolower(substr($valor,3)) . ';' . "\n";
							$php .= "\t \t" . '}' . "\n";
			
						} else{
							$php .= "\t \t" . 'public function get' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,1)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . '(){' . "\n";
							$php .= "\t \t \t" . ' return $this->' . strtolower(substr($valor,0,2)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) .';' . "\n";
							$php .= "\t \t" . '}' . "\n";
						}
						if(substr($valor,0,2) == 'in'){
						
							$php .= "\t \t" . 'public function get' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,1)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . 'Descricao(){' . "\n";
							$php .= "\t \t \t" . 'switch($this->' . strtolower(substr($valor,0,2)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) .'){' . "\n";
							foreach($descricao as $indice => $desc){
								$php .= "\t \t\t\t" . 'case ' . $indice . ':' ."\n";
								$php .= "\t \t\t\t\t" . '$o' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,1)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . 'Descricao = ' . '"'. $desc . '";' ."\n";
								$php .= "\t\t\t\t" . 'break;'."\n";
							}
							$php .= "\t \t\t" . '}' . "\n";
							$php .= "\t \t\t" . 'return $o' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,1)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) .'Descricao;' . "\n";
							$php .= "\t \t" . '}' . "\n";
						}
					} else{
						$php .= "\t \t" . 'private function set' . strCapitalize($valor) . '($value){' . "\n";
						$php .= "\t \t \t" . '$this->' . $valor . ' = $value; ' . "\n";
						$php .= "\t \t" . '}' . "\n";
					
						$php .= "\t \t" . 'public function get' . strCapitalize($valor) . '(){' . "\n";
						$php .= "\t \t \t" . ' return $this->' . $valor .';' . "\n";
						$php .= "\t \t" . '}' . "\n";
					}					
				}
			}
			$php .= "\t \t" . '#Função limpar' . "\n";
			$php .= "\t \t" . 'public function clear(){' . "\n";
				$php .= "\t \t \t" . '$this->setCodigo(NULL);' . "\n";
				foreach($cursos as $indice => $valor){
					if($valor == 'cpf' || $valor == 'Cpf' || $valor == 'cnpj' || $valor == 'Cnpj' || $valor == 'Rg' || $valor == 'rg'){
						$php .= "\t \t \t" . '$this->set' . strtoupper($valor) . '(NULL);' . "\n";
					} else{
						if(substr($valor,0,4) == 'data'){
							$php .= "\t \t \t" . '$this->set' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,3)). strtoupper(substr($valor,4,1)) .strtolower(substr($valor,5)) . '(NULL);' . "\n";
						} else if(substr($valor,0,2) == 'in' || substr($valor,0,2) == 'id'){
							$php .= "\t \t \t" . '$this->set' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,1)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . '(NULL);' . "\n";
						} else{
							$php .= "\t \t \t" . '$this->set' . strCapitalize($valor) . '(NULL);' . "\n";
						}
					}
				}
				$php .= "\n";
				$php .= "\t \t \t" . 'parent::clear();' . "\n";
			$php .= "\t \t" . '}' . "\n";
			$php .= "\t \t" . '#Metodos e Atualizações' . "\n";
			$php .= "\t \t" . 'public function updId' . $nome . '($value){' . "\n";	
				$php .= "\t \t \t" . '$this->codigo = $value;' . "\n";
			$php .= "\t \t" . '}' . "\n";
			foreach($cursos as $indice => $valor){
				if($valor == 'cpf' || $valor == 'Cpf' || $valor == 'cnpj' || $valor == 'Cnpj' || $valor == 'Rg' || $valor == 'rg'){
					$php .= "\t \t" . 'public function upd' . strtoupper($valor) . '($value){' . "\n";
						$php .= "\t \t \t" . '$this->' . $valor . ' = $value;' . "\n";
					$php .= "\t \t" . '}' . "\n";
				} else{
					if(substr($valor,0,4) == 'data'){
						$php .= "\t \t" . 'public function upd' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,3)). strtoupper(substr($valor,4,1)) .strtolower(substr($valor,5)) . '($value){' . "\n";
							$php .= "\t \t \t" . '$this->' . strtolower(substr($valor,0,4)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . ' = $value;' . "\n";
						$php .= "\t \t" . '}' . "\n";
					} else if(substr($valor,0,2) == 'in' || substr($valor,0,2) == 'id'){
						$php .= "\t \t" . 'public function upd' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,1)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . '($value){' . "\n";
							$php .= "\t \t \t" . '$this->' . strtolower(substr($valor,0,2)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . ' = $value;' . "\n";
						$php .= "\t \t" . '}' . "\n";
					} else{
						$php .= "\t \t" . 'public function upd' . strCapitalize($valor) . '($value){' . "\n";
							$php .= "\t \t \t" . '$this->' . $valor . ' = $value;' . "\n";
						$php .= "\t \t" . '}' . "\n";
					}
				}
			}
			$php .= "\t \t". '#construct' ."\n";
			$php .= "\t \t". 'public function __construct($codigo = NULL,' ."\n";
				foreach($cursos as $indice => $valor){
					if(substr($valor,0,4) == 'data'){
						$php .= "\t \t \t \t \t \t \t \t \t" . '$' . strtolower(substr($valor,0,4)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . ' = NULL,' ."\n";
					} else if(substr($valor,0,2) == 'in' || substr($valor,0,2) == 'id'){
						$php .= "\t \t \t \t \t \t \t \t \t" . '$' . strtolower(substr($valor,0,2)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . ' = NULL,' ."\n";
					} else{
						$php .= "\t \t \t \t \t \t \t \t \t" . '$' . $valor . ' = NULL,' ."\n";
					}
				}
				$php .= "\t \t \t \t \t \t \t \t \t" . '$dataCadastro = NULL,' . " \n";
				$php .= "\t \t \t \t \t \t \t \t \t" . '$dataAlteracao  = NULL){' . " \n";
				$php .= "\n";
				$php .= "\t \t \t" . '$this->clear();' . "\n";
				$php .= "\n";
				$php .= "\t \t \t" . '$this->setCodigo($codigo);' . "\n";
				foreach($cursos as $indice => $valor){
					if($valor == 'cpf' || $valor == 'Cpf' || $valor == 'cnpj' || $valor == 'Cnpj' || $valor == 'Rg' || $valor == 'rg'){
						$php .= "\t \t \t" . '$this->set' . strtoupper($valor) . '($' . "$valor); \n";
					} else{
						if(substr($valor,0,4) == 'data'){
							$php .= "\t \t \t" . '$this->set' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,3)). strtoupper(substr($valor,4,1)) .strtolower(substr($valor,5)) . '($' . strtolower(substr($valor,0,4)). strtoupper(substr($valor,4,1)).strtolower(substr($valor,5)) . "); \n";
						} else if(substr($valor,0,2) == 'in' || substr($valor,0,2) == 'id'){
							$php .= "\t \t \t" . '$this->set' . strtoupper(substr($valor,0,1)) .strtolower(substr($valor,1,1)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . '($' . strtolower(substr($valor,0,2)). strtoupper(substr($valor,2,1)).strtolower(substr($valor,3)) . "); \n";
						} else{
							$php .= "\t \t \t" . '$this->set' . strCapitalize($valor) . '($' . "$valor); \n";
						}
					}
				}
				$php .= "\n";
				$php .= "\t \t \t" . 'parent::setDataCadastro($dataCadastro);' . " \n";
				$php .= "\t \t \t" . 'parent::setDataAlteracao($dataAlteracao);' . " \n";
			$php .= "\t \t" . '}' . "\n"; 
		$php .= "\t" . '}' . "\n";
	$php .= '?>'; 
	
	file_put_contents($nome.".php", $php);
	
	echo "Arquivo Cursos criado com sucesso <br>";
	
	/*
	/////////////////////////////CLASS DAO/////////////////////////////////////
	$dao = '<?' . "\n";
		$dao .= "\t" . '#require_once("autoload.php");' . "\n";
		$dao .= "\n";
		$dao .= "\t" . 'class ' . $nome . 'DAO{' . "\n";
			$dao .= "\t \t" . 'private $sql = NULL;' . "\n";
			$dao .= "\n";
			$dao .= "\t \t" . 'public function getSQL(){' . "\n";
				$dao .= "\t \t \t" . 'return $this->sql;' . "\n";
			$dao .= "\t \t" . '}' . "\n";
			$dao .= "\t \t" . 'private function load($rs){' . "\n";
				$dao .= "\t \t \t" . 'return new ' . $nome . '($rs->Fields("id' . $nome . '"),' . "\n";
				foreach($cursos as $indice => $valor){
					$dao .= "\t \t \t \t \t \t \t \t" . '$rs->Fields("' . $valor . '"),' . "\n";
				}
				$dao .= "\t \t \t \t \t \t \t \t" . '$rs->Fields("dataCadastro"),' . "\n";
				$dao .= "\t \t \t \t \t \t \t \t" . '$rs->Fields("dataAlteracao"));' . "\n";
			$dao .= "\t \t" . '}' . "\n";
			#add
			$dao .= "\t \t" . '#ADD' . "\n";
			$dao .= "\t \t" . 'public function add(&$obj){' . "\n";
				$dao .= "\t \t \t" . 'global $db;' . "\n";
				$dao .= "\t \t \t" . '$return = false;' . "\n";
				$dao .= "\n";
				$dao .= "\t \t \t" . 'if(! is_null($obj)){' . "\n";
					$dao .= "\t \t \t \t" . '$this->sql = "";' . "\n";
					$dao .= "\t \t \t \t" . '$this->sql = sprintf(\'INSERT INTO "' . strtolower($nome) . '"  (' . "\n";
					foreach($cursos as $indice => $valor){
						$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t \t \t \t" . '"' . $valor . '",' . "\n";
					}
					$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t \t \t \t" . '"dataCadastro")' . "\n";
					$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t \t \t \t" . 'VALUES(' . "\n";						
					foreach($chaves as $indice => $chave){
						$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t \t \t \t \t " . '%' . $chave . ',' . "\n";
					}
					$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t \t \t \t \t " . 'now());\',' . "\n";
					$dao .= "\n";
					foreach($cursos as $indice => $valor){
						if($chave == "s"){
							$dao .="\t \t \t \t \t \t \t \t \t" . '$db->qstr($obj->get' . strCapitalize($valor) . '()),' . "\n";
						} else{
							$dao .="\t \t \t \t \t \t \t \t \t" . '$obj->get' . strCapitalize($valor) . '(),' . "\n";
						}
					}
					$dao .= "\t \t \t \t \t \t \t \t \t" . ');' . "\n";
					$dao .= "\t \t \t \t" . '$db->BeginTrans();' . "\n";
					$dao .= "\n";
					$dao .= "\t \t \t \t" . 'try{' . "\n";
						$dao .= "\t \t \t \t \t" . '$db->Execute($this->sql);' . "\n";
						$dao .= "\t \t \t \t \t" . '$db->CommitTrans();' . "\n";
						$dao .= "\t \t \t \t \t" . '$return = true;' . "\n";
						$dao .= "\n";
						$dao .= "\t \t \t \t \t" . '$sqlInsert = sprintf("SELECT LASTVAL() as ins_id");' . "\n";
						$dao .= "\t \t \t \t \t" . '$rs = $db->Execute($sqlInsert);' . "\n";
						$dao .= "\n";
						$dao .= "\t \t \t \t \t" . '$obj->updId' . $nome . '($rs->Fields("ins_id"));' . "\n";
					$dao .= "\t \t \t \t" . '} catch(exception $e){' . "\n";
					$dao .= "\t \t \t \t \t" . '$db->RollBackTrans();' . "\n";	
					$dao .= "\t \t \t \t" . '}' . "\n";
				$dao .= "\t \t \t" . '}' . "\n";
				$dao .= "\t \t \t" . 'return $return;' . "\n";
			$dao .= "\t \t" . '}' . "\n";
			#upd
			$dao .= "\t \t" . '#UPDATE' . "\n";
			$dao .= "\t \t" . 'public function update(&$obj){' . "\n";
				$dao .= "\t \t \t" . 'global $db;' . "\n";
				$dao .= "\t \t \t" . '$return = false;' . "\n";
				$dao .= "\t \t \t" . '$this->sql = "";' . "\n";
				$dao .= "\n";
				$dao .= "\t \t \t" . 'if(! is_null($obj)){' . "\n";
					$dao .= "\t \t \t \t" . '$this->sql = sprintf(\'UPDATE "' . strtolower($nome) . '" SET' . "\n";
					foreach($cursos as $indice => $valor){
						if($chave == "s"){
							$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t \t \t" . '"' . $valor . '" = '.$indice.',' ."\n";
						} else{
							$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t \t \t" . '"' . $valor . '" = %u,' ."\n";
						}
					}
					$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t \t \t" . '"dataAlteracao" = now()' . "\n";
					$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t \t" . 'WHERE "id' . $nome . '" = %u;\',' . "\n";
					$dao .= "\n";
					foreach($cursos as $indice => $valor){
						$dao .="\t \t \t \t \t \t \t \t \t" . '$obj->get' . strCapitalize($valor) . '(),' . "\n";
					}
					$dao .= "\t \t \t \t \t \t \t \t \t" . '$obj->getCodigo());' . "\n";
					$dao .= "\t \t \t \t" . '$db->BeginTrans();' . "\n";
					$dao .= "\n";
					$dao .= "\t \t \t \t" . 'try{' . "\n";
						$dao .= "\t \t \t \t \t" . '$db->Execute($this->sql);' . "\n";
						$dao .= "\t \t \t \t \t" . '$db->CommitTrans();' . "\n";
						$dao .= "\t \t \t \t \t" . '$return = true;' . "\n";
					$dao .= "\t \t \t \t" . '} catch(exception $e){' . "\n";
					$dao .= "\t \t \t \t \t" . '$db->RollBackTrans();' . "\n";	
					$dao .= "\t \t \t \t" . '}' . "\n";
				$dao .= "\t \t \t" . '}' . "\n";
				$dao .= "\t \t \t" . 'return $return;' . "\n";
			$dao .= "\t \t" . '}' . "\n";
			#DELETE
			$dao .= "\t \t" . '#DELETE' . "\n";
			$dao .= "\t \t" . 'public function delete(&$obj){' . "\n";
				$dao .= "\t \t \t" . 'global $db;' . "\n";
				$dao .= "\t \t \t" . '$return = false;' . "\n";
				$dao .= "\t \t \t" . '$this->sql = "";' . "\n";
				$dao .= "\n";
				$dao .= "\t \t \t" . 'if(! is_null($obj)){' . "\n";
					$dao .= "\t \t \t \t" . '$this->sql = sprintf(\'DELETE FROM "' . strtolower($nome) . '"' . "\n";
					$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t \t" . 'WHERE "id' . $nome . '" = %u;\',' . "\n";
					$dao .= "\n";
					$dao .= "\t \t \t \t \t \t \t \t \t" . '$obj->getCodigo());' . "\n";
					$dao .= "\t \t \t \t" . '$db->BeginTrans();' . "\n";
					$dao .= "\n";
					$dao .= "\t \t \t \t" . 'try{' . "\n";
						$dao .= "\t \t \t \t \t" . '$db->Execute($this->sql);' . "\n";
						$dao .= "\t \t \t \t \t" . '$db->CommitTrans();' . "\n";
						$dao .= "\t \t \t \t \t" . '$return = true;' . "\n";
					$dao .= "\t \t \t \t" . '} catch(exception $e){' . "\n";
					$dao .= "\t \t \t \t \t" . '$db->RollBackTrans();' . "\n";	
					$dao .= "\t \t \t \t" . '}' . "\n";
				$dao .= "\t \t \t" . '}' . "\n";
				$dao .= "\t \t \t" . 'return $return;' . "\n";
			$dao .= "\t \t" . '}' . "\n";
			#SELECT
			$dao .= "\t \t" . '#SELECT' . "\n";
			$dao .= "\t \t" . 'public function select($option = 0,' . "\n";
			$dao .= "\t \t \t \t \t \t \t \t \t" . '$key = NULL,' . "\n";
			$dao .= "\t \t \t \t \t \t \t \t \t" . '$order = NULL){' . "\n";
				$dao .= "\t \t \t" . 'global $db;' . "\n";
				$dao .= "\t \t \t" . '$return = NULL;' . "\n";
				$dao .= "\t \t \t" . '$this->sql = "";' . "\n";
				$dao .= "\n";
					$dao .= "\t \t \t" . 'switch($option){' . "\n";
						$dao .= "\t \t \t \t" . 'case 0:' . "\n";
							$dao .= "\t \t \t \t \t" . '$this->sql = sprintf(\'SELECT *' . "\n";
								$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t" . 'FROM "' . strtolower($nome). '"' . "\n";
									$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t" . 'ORDER BY "id' . $nome . '"' . "\n";
									$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t" . 'LIMIT(1000)\');' . "\n";
							$dao .= "\n";
							$dao .= "\t \t \t \t \t" . '$rs = $db->Execute($this->sql);' . "\n";
							$dao .= "\n";
							$dao .= "\t \t \t \t \t" . 'while(! $rs->EOF){' . "\n";
								$dao .= "\t \t \t \t \t \t" . '$return[] = $this->load($rs);' . "\n";
								$dao .= "\t \t \t \t \t \t" . '$rs->MoveNext();' . "\n";
							$dao .= "\t \t \t \t \t" . '}' . "\n";
							$dao .= "\t \t \t \t \t" . '$rs->close();' . "\n";
						$dao .= "\t \t \t \t" . 'break;' . "\n";
						$dao .= "\t \t \t \t" . 'case 1:' . "\n";
							$dao .= "\t \t \t \t \t" . '$this->sql = sprintf(\'SELECT *' . "\n";
								$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t" . 'FROM "' . strtolower($nome). '"' . "\n";
									$dao .= "\t \t \t \t \t \t \t \t \t \t \t \t \t" . 'WHERE "id' . $nome . '" = %u;\',' . "\n";
							$dao .= "\t \t \t \t \t \t \t \t \t \t" . '$key);' . "\n";
							$dao .= "\n";
							$dao .= "\t \t \t \t \t" . '$rs = $db->Execute($this->sql);' . "\n";
							$dao .= "\n";
							$dao .= "\t \t \t \t \t" . 'if(! $rs->EOF){' . "\n";
								$dao .= "\t \t \t \t \t \t" . '$return = $this->load($rs);' . "\n";
							$dao .= "\t \t \t \t \t" . '}' . "\n";
							$dao .= "\t \t \t \t \t" . '$rs->close();' . "\n";
						$dao .= "\t \t \t \t" . 'break;' . "\n";
					$dao .= "\t \t \t" . '}' . "\n";
				$dao .= "\t \t \t" . 'return $return;' . "\n";
			$dao .= "\t \t" . '}' . "\n";
		$dao .= "\t" . '}' . "\n";
	$dao .= '?>' . "\n";
	file_put_contents($nome."DAO.php", $dao);
	
	echo "Arquivo CursosDAO criado com sucesso <br>";*/
	#echo "<meta http-equiv='refresh' content='3; URL=criar.php'>";
	function strCapitalize($str){  
		$size = "";
		$noUp = array('um','uma','o','a','de','do','da','em');  
		$str = trim($str);
		$str = strtoupper($str[0]) . strtolower(substr($str, 1));  
		for($i=1; $i<strlen($str)-1; ++$i) {  
			if($str[$i]==' ') {  
				for($j=$i+1; $j<strlen($str) && $str[$j]!=' '; ++$j); //find next space  
				$size = $j-$i-1;  
				$shortWord = false;  
				if($size<=3) {  
					$theWord = substr($str,$i+1,$size);  
					for($j=0; $j<count($noUp) && !$shortWord; ++$j)  
					if($theWord==$noUp[$j])  
					$shortWord = true;  
				}  
				if( !$shortWord )  
				$str = substr($str, 0, $i+1) . strtoupper($str[$i+1]) . substr($str, $i+2);  
		   	}    
		   	$i+=$size;  
		}  
		return $str; 
	}  
?>
<script>
	$(document).ready(function(e) {
        $("#carrega").click(function(e) {
      			$("#criaPHP").load("cursos.php");    
        });
    });
</script>
<div id="criaPHP">

</div>
<!--doctype html>
<html lang="pt-br">
	<head>
        <meta charset="utf-8">
        <title>
	        Criando HTML com PHP
        </title>
    </head>
	<body>    	
	</body>
</html--> 