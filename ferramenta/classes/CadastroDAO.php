<?
	require_once("autoload.php");
	
	class CadastroDAO{
		private $sql = NULL;
		
		public function getSQL(){
			return $this->sql;
		}
		private function load($rs){
			return new Cadastro($rs->Fields("idCadastro"),
									  $rs->Fields("nome"),
									  $rs->Fields("senha"),
									  $rs->Fields("CPF"),
									  $rs->Fields("email"),
									  $rs->Fields("dataCadastro"),
									  $rs->Fields("dataAlteracao"));
		}
		##ADD
		public function add(&$obj){
			global $db;
			
			$return = false;
			
			if(! is_null($obj)){
				$this->sql = "";
				$this->sql = sprintf('INSERT INTO "cadastro" ("nome",
																			 "senha",
																			 "cpf",
																			 "email",
																			 "dataCadastro")
																			 VALUES (%s,
																			 			%s,
																						%s,
																						%s,
																						now())',
											$db->qstr($obj->getNome()),
											$db->qstr($obj->getSenha()),
											$db->qstr($obj->getCPF()),
											$db->qstr($obj->getEmail()));
				
				$db->BeginTRans();
				try {
				$db->Execute($this->sql);
					$db->CommitTrans();
					$return = true;
					
					$sqlInsert = sprintf("SELECT LASTVAL() as ins_id");
					$rs = $db->Execute($sqlInsert);
					
					$obj->updIdCadastro($rs->Fields("ins_id"));
				} catch (exception $e){
					$db->RollBackTrans();
				}
			}
			return $return;
		}
		
		public function update(&$obj){
			global $db;
			
			$return = false;
			$this->sql = "";
			
			if(! is_null($obj)){
				$this->sql = sprintf('UPDATE "cadastro" 
															SET "nome" = %s,
																 "senha" = %s,
																 "cpf" = %s,
																 "email" = %s,
																 "dataAlteracao" = now()
															WHERE "idCadastro" = %u',
											$db->qstr($obj->getNome()),
											$db->qstr($obj->getSenha()),
											$db->qstr($obj->getCPF()),
											$db->qstr($obj->getEmail()),
											$obj->getCodigo());
											#echo $this->sql;
				
				$db->BeginTrans();
				
				try{
					$db->Execute($this->sql);
					$db->CommitTrans();
					$return = true;
				} catch(execption $e){
					$db->RollBackTrans();
				}
			}
			return $return;
		}
		
		public function delete(&$obj){
			global $db;
			
			$return = false;
			$this->sql = "";
			
			if(! is_null($obj)){
				
			}
			return $return;
		}
		
		public function select($option = 0,
									  $key = NULL,
									  $order = NULL){
			global $db;
			$return = NULL;
			
			$this->sql = "";
			
			switch($option){
				case 0:
					$this->sql = sprintf('SELECT *
													FROM "cadastro"
													ORDER BY "nome"
													LIMIT(1000)');
	
					$rs = $db->Execute($this->sql);
					
					while(! $rs->EOF){
						$return[] = $this->load($rs);
						$rs->MoveNext();
					}
					$rs->Close();
				break;
				
				case 1:
					$this->sql = sprintf('SELECT *
													FROM "cadastro"
														WHERE "idCadastro" = %u',
												$key);
	
					$rs = $db->Execute($this->sql);
					
					if(! $rs->EOF){
						$return = $this->load($rs);
					}
					
					$rs->Close();
				break;
				
				case 2:
					$this->sql = sprintf('SELECT *
													FROM "cadastro"
														WHERE ("senha" = %s
														AND "email" = %s);',
												$db->qstr($key[0]),
												$db->qstr($key[1]));

					$rs = $db->Execute($this->sql);
					
					if(! $rs->EOF){
						$return = $this->load($rs);
					}
					
					$rs->Close();
				break;
				case 3:
					$this->sql = sprintf('	SELECT *
											FROM "cadastro"
											WHERE "idCadastro" != %u
											ORDER BY "nome"',
												$key);

					$rs = $db->Execute($this->sql);
					
					while(! $rs->EOF){
						$return[] = $this->load($rs);
						$rs->MoveNext();
					}
					$rs->Close();
				break;
				case 4:
					$this->sql = sprintf('SELECT nome
													FROM "cadastro"
														WHERE "idCadastro" = %u
														order by "nome"',
												$key);

					$rs = $db->Execute($this->sql);
					
					while(! $rs->EOF){
						$return[] = $this->load($rs);
						$rs->MoveNext();
					}
					$rs->Close();
				break;
			}
			return $return;
		}
	}
?>