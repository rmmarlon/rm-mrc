<? 
	require_once("autoload.php");
	  
	class Revendas extends DataRegistro{
	 	#Atributos
	 	private $codigo =  NULL;
	 	private $reve_dtcadastro =  NULL;
	 	private $reve_razao =  NULL;
	 	private $reve_cnpj =  NULL;
	 	private $reve_ie =  NULL;
	 	private $reve_email =  NULL;
	 	private $reve_url =  NULL;
		private $reve_status =  NULL;
	 	private $pess_cod =  NULL;
	 	private $reve_nota_vend =  NULL;
	 	private $reve_vencimento =  NULL;
	 	private $reve_texto =  NULL;
	 	private $reve_dtaniver1 =  NULL;
	 	private $reve_dtaniver2 =  NULL;
	 	private $reve_foto =  NULL;
	 	private $qtd_carros_vitrine =  NULL;
	 	private $reve_cont_02 =  NULL;
	 	private $reve_cont_01 =  NULL;
	 	private $dt_cancelamento =  NULL;
	 	private $dt_alteracao =  NULL;
		private $id_pacote =  NULL;
	 	private $reve_produtos =  NULL;
	 	private $texto_servico =  NULL;
	 	private $texto_comochegar =  NULL;
		private $id_representante =  NULL;
		private $id_filialbv =  NULL;
		private $id_codbv =  NULL;
	 	private $operador_bv =  NULL;
	 	private $qtde_contratos =  NULL;
	 	private $valor_bonificado =  NULL;
	 	private $tipo_faturamento =  NULL;
	 	private $tipo_pessoa =  NULL;
	 	private $valor_mensalidade =  NULL;
	 	private $reve_im =  NULL;
		private $id_serie =  NULL;
	 	private $reve_modelo_nfe =  NULL;
	 	private $cod_clas_fis_cod =  NULL;
	 	private $cnae_cod =  NULL;
		private $inTegrador =  NULL;
	 	private $reve_dominio_exp =  NULL;
	 	#SET e GET
	 	private function setCodigo($value){
	 	 	$this->codigo = $value; 
	 	}
	 	public function getCodigo(){
	 	 	 return $this->codigo;
	 	}
	 	private function setReve_dtcadastro($value){
	 	 	$this->reve_dtcadastro = $value; 
	 	}
	 	public function getReve_dtcadastro(){
	 	 	 return $this->reve_dtcadastro;
	 	}
	 	private function setReve_razao($value){
	 	 	$this->reve_razao = $value; 
	 	}
	 	public function getReve_razao(){
	 	 	 return $this->reve_razao;
	 	}
	 	private function setReve_cnpj($value){
	 	 	$this->reve_cnpj = $value; 
	 	}
	 	public function getReve_cnpj(){
	 	 	 return $this->reve_cnpj;
	 	}
	 	private function setReve_ie($value){
	 	 	$this->reve_ie = $value; 
	 	}
	 	public function getReve_ie(){
	 	 	 return $this->reve_ie;
	 	}
	 	private function setReve_email($value){
	 	 	$this->reve_email = $value; 
	 	}
	 	public function getReve_email(){
	 	 	 return $this->reve_email;
	 	}
	 	private function setReve_url($value){
	 	 	$this->reve_url = $value; 
	 	}
	 	public function getReve_url(){
	 	 	 return $this->reve_url;
	 	}
	 	private function setReve_status($value){
	 	 	$this->reve_status = $value; 
	 	}
	 	public function getReve_status(){
	 	 	 return $this->reve_status;
	 	}
	 	public function getReve_statusDescricao(){
	 	 	switch($this->reve_status){	 			
				case 0:
					$oReve_statusDescricao = "Inativo";
				break;
	 			case 1:
					$oReve_statusDescricao = "Ativo";
				break;
	 			case 2:
	 				$oReve_statusDescricao = "Inadimplente";
				break;
				case 3:
	 				$oReve_statusDescricao = "Pendente Comercial";
				break;
				case 4:
	 				$oReve_statusDescricao = "Pendente WebSite";
				break;
				case 5:
	 				$oReve_statusDescricao = "Pendente Retenção SCM";
				break;
	 		}
	 		return $oReve_statusDescricao;
	 	}
	 	private function setPess_cod($value){
	 	 	$this->pess_cod = $value; 
	 	}
	 	public function getPess_cod(){
	 	 	 return $this->pess_cod;
	 	}
	 	private function setReve_nota_vend($value){
	 	 	$this->reve_nota_vend = $value; 
	 	}
	 	public function getReve_nota_vend(){
	 	 	 return $this->reve_nota_vend;
	 	}
	 	private function setReve_vencimento($value){
	 	 	$this->reve_vencimento = $value; 
	 	}
	 	public function getReve_vencimento(){
	 	 	 return $this->reve_vencimento;
	 	}
	 	private function setReve_texto($value){
	 	 	$this->reve_texto = $value; 
	 	}
	 	public function getReve_texto(){
	 	 	 return $this->reve_texto;
	 	}
	 	private function setReve_dtaniver1($value){
	 	 	$this->reve_dtaniver1 = $value; 
	 	}
	 	public function getReve_dtaniver1(){
	 	 	 return $this->reve_dtaniver1;
	 	}
	 	private function setReve_dtaniver2($value){
	 	 	$this->reve_dtaniver2 = $value; 
	 	}
	 	public function getReve_dtaniver2(){
	 	 	 return $this->reve_dtaniver2;
	 	}
	 	private function setReve_foto($value){
	 	 	$this->reve_foto = $value; 
	 	}
	 	public function getReve_foto(){
	 	 	 return $this->reve_foto;
	 	}
	 	private function setQtd_carros_vitrine($value){
	 	 	$this->qtd_carros_vitrine = $value; 
	 	}
	 	public function getQtd_carros_vitrine(){
	 	 	 return $this->qtd_carros_vitrine;
	 	}
	 	private function setReve_cont_02($value){
	 	 	$this->reve_cont_02 = $value; 
	 	}
	 	public function getReve_cont_02(){
	 	 	 return $this->reve_cont_02;
	 	}
	 	private function setReve_cont_01($value){
	 	 	$this->reve_cont_01 = $value; 
	 	}
	 	public function getReve_cont_01(){
	 	 	 return $this->reve_cont_01;
	 	}
	 	private function setDt_cancelamento($value){
	 	 	$this->dt_cancelamento = $value; 
	 	}
	 	public function getDt_cancelamento(){
	 	 	 return $this->dt_cancelamento;
	 	}
	 	private function setDt_alteracao($value){
	 	 	$this->dt_alteracao = $value; 
	 	}
	 	public function getDt_alteracao(){
	 	 	 return $this->dt_alteracao;
	 	}
	 	private function setId_pacote($value){
	 	 	$this->id_pacote = $value; 
	 	}
	 	public function getId_pacote(){
	 		/*if(! isset($o_pacote)){
	 			$o_pacote = NULL;
	 		}
	 		if(is_null($o_pacote)){
	 			$dao = new CadastroDAO();
	 			$o_pacote = $dao->select(1, $this->id_pacote);
	 		}
	 		unset($dao);
	 		return $o_pacote;
			consulta em outra tabela FK
			*/
			return $this->id_pacote;
	 	}
	 	private function setReve_produtos($value){
	 	 	$this->reve_produtos = $value; 
	 	}
	 	public function getReve_produtos(){
	 	 	 return $this->reve_produtos;
	 	}
	 	private function setTexto_servico($value){
	 	 	$this->texto_servico = $value; 
	 	}
	 	public function getTexto_servico(){
	 	 	 return $this->texto_servico;
	 	}
	 	private function setTexto_comochegar($value){
	 	 	$this->texto_comochegar = $value; 
	 	}
	 	public function getTexto_comochegar(){
	 	 	 return $this->texto_comochegar;
	 	}
	 	private function setId_representante($value){
	 	 	$this->id_representante = $value; 
	 	}
	 	public function getId_representante(){
	 		/*if(! isset($o_representante)){
	 			$o_representante = NULL;
	 		}
	 		if(is_null($o_representante)){
	 			$dao = new CadastroDAO();
	 			$o_representante = $dao->select(1, $this->id_representante);
	 		}
	 		unset($dao);
	 		return $o_representante;
			consulta em outra tabela FK
			*/
			return $this->id_filialbv;
	 	}
	 	private function setId_filialbv($value){
	 	 	$this->id_filialbv = $value; 
	 	}
	 	public function getId_filialbv(){
	 		/*if(! isset($o_filialbv)){
	 			$o_filialbv = NULL;
	 		}
	 		if(is_null($o_filialbv)){
	 			$dao = new CadastroDAO();
	 			$o_filialbv = $dao->select(1, $this->id_filialbv);
	 		}
	 		unset($dao);
	 		return $o_filialbv;
			consulta em outra tabela FK
			*/
			return $this->id_filialbv;
	 	}
	 	private function setId_codbv($value){
	 	 	$this->id_codbv = $value; 
	 	}
	 	public function getId_codbv(){
	 		/*if(! isset($o_codbv)){
	 			$o_codbv = NULL;
	 		}
	 		if(is_null($o_codbv)){
	 			$dao = new CadastroDAO();
	 			$o_codbv = $dao->select(1, $this->id_codbv);
	 		}
	 		unset($dao);
	 		return $o_codbv;
			consulta em outra tabela FK
			*/
			return $this->id_codbv;
	 	}
	 	private function setOperador_bv($value){
	 	 	$this->operador_bv = $value; 
	 	}
	 	public function getOperador_bv(){
	 	 	 return $this->operador_bv;
	 	}
	 	private function setQtde_contratos($value){
	 	 	$this->qtde_contratos = $value; 
	 	}
	 	public function getQtde_contratos(){
	 	 	 return $this->qtde_contratos;
	 	}
	 	private function setValor_bonificado($value){
	 	 	$this->valor_bonificado = $value; 
	 	}
	 	public function getValor_bonificado(){
	 	 	 return $this->valor_bonificado;
	 	}
	 	private function setTipo_faturamento($value){
	 	 	$this->tipo_faturamento = $value; 
	 	}
	 	public function getTipo_faturamento(){
	 	 	 return $this->tipo_faturamento;
	 	}
	 	private function setTipo_pessoa($value){
	 	 	$this->tipo_pessoa = $value; 
	 	}
	 	public function getTipo_pessoa(){
	 	 	 return $this->tipo_pessoa;
	 	}
	 	private function setValor_mensalidade($value){
	 	 	$this->valor_mensalidade = $value; 
	 	}
	 	public function getValor_mensalidade(){
	 	 	 return $this->valor_mensalidade;
	 	}
	 	private function setReve_im($value){
	 	 	$this->reve_im = $value; 
	 	}
	 	public function getReve_im(){
	 	 	 return $this->reve_im;
	 	}
	 	private function setId_serie($value){
	 	 	$this->id_serie = $value; 
	 	}
	 	public function getId_serie(){
	 		/*if(! isset($o_serie)){
	 			$o_serie = NULL;
	 		}
	 		if(is_null($o_serie)){
	 			$dao = new CadastroDAO();
	 			$o_serie = $dao->select(1, $this->id_serie);
	 		}
	 		unset($dao);
	 		return $o_serie;
			*/
			return $this->id_serie;
	 	}
	 	private function setReve_modelo_nfe($value){
	 	 	$this->reve_modelo_nfe = $value; 
	 	}
	 	public function getReve_modelo_nfe(){
	 	 	 return $this->reve_modelo_nfe;
	 	}
	 	private function setCod_clas_fis_cod($value){
	 	 	$this->cod_clas_fis_cod = $value; 
	 	}
	 	public function getCod_clas_fis_cod(){
	 	 	 return $this->cod_clas_fis_cod;
	 	}
	 	private function setCnae_cod($value){
	 	 	$this->cnae_cod = $value; 
	 	}
	 	public function getCnae_cod(){
	 	 	 return $this->cnae_cod;
	 	}
	 	private function setIntegrador($value){
	 	 	$this->integrador = $value; 
	 	}
	 	public function getIntegrador(){
	 	 	 return $this->integrador;
	 	}
	 	private function setReve_dominio_exp($value){
	 	 	$this->reve_dominio_exp = $value; 
	 	}
	 	public function getReve_dominio_exp(){
	 	 	 return $this->reve_dominio_exp;
	 	}
	 	#Função limpar
	 	public function clear(){
	 	 	$this->setCodigo(NULL);
	 	 	$this->setReve_dtcadastro(NULL);
	 	 	$this->setReve_razao(NULL);
	 	 	$this->setReve_cnpj(NULL);
	 	 	$this->setReve_ie(NULL);
	 	 	$this->setReve_email(NULL);
	 	 	$this->setReve_url(NULL);
	 	 	$this->setReve_status(NULL);
	 	 	$this->setPess_cod(NULL);
	 	 	$this->setReve_nota_vend(NULL);
	 	 	$this->setReve_vencimento(NULL);
	 	 	$this->setReve_texto(NULL);
	 	 	$this->setReve_dtaniver1(NULL);
	 	 	$this->setReve_dtaniver2(NULL);
	 	 	$this->setReve_foto(NULL);
	 	 	$this->setQtd_carros_vitrine(NULL);
	 	 	$this->setReve_cont_02(NULL);
	 	 	$this->setReve_cont_01(NULL);
	 	 	$this->setDt_cancelamento(NULL);
	 	 	$this->setDt_alteracao(NULL);
	 	 	$this->setId_pacote(NULL);
	 	 	$this->setReve_produtos(NULL);
	 	 	$this->setTexto_servico(NULL);
	 	 	$this->setTexto_comochegar(NULL);
	 	 	$this->setId_representante(NULL);
	 	 	$this->setId_filialbv(NULL);
	 	 	$this->setId_codbv(NULL);
	 	 	$this->setOperador_bv(NULL);
	 	 	$this->setQtde_contratos(NULL);
	 	 	$this->setValor_bonificado(NULL);
	 	 	$this->setTipo_faturamento(NULL);
	 	 	$this->setTipo_pessoa(NULL);
	 	 	$this->setValor_mensalidade(NULL);
	 	 	$this->setReve_im(NULL);
	 	 	$this->setId_serie(NULL);
	 	 	$this->setReve_modelo_nfe(NULL);
	 	 	$this->setCod_clas_fis_cod(NULL);
	 	 	$this->setCnae_cod(NULL);
	 	 	$this->setInTegrador(NULL);
	 	 	$this->setReve_dominio_exp(NULL);

	 	 	parent::clear();
	 	}
	 	#Metodos e Atualizações
	 	public function updReve_cod($value){
	 	 	$this->codigo = $value;
	 	}
	 	public function updReve_dtcadastro($value){
	 	 	$this->reve_dtcadastro = $value;
	 	}
	 	public function updReve_razao($value){
	 	 	$this->reve_razao = $value;
	 	}
	 	public function updReve_cnpj($value){
	 	 	$this->reve_cnpjs = $value;
	 	}
	 	public function updReve_ie($value){
	 	 	$this->reve_ie = $value;
	 	}
	 	public function updReve_email($value){
	 	 	$this->reve_email = $value;
	 	}
	 	public function updReve_url($value){
	 	 	$this->reve_url = $value;
	 	}
	 	public function updReve_status($value){
	 	 	$this->inReve_status = $value;
	 	}
	 	public function updPess_cod($value){
	 	 	$this->pess_cod = $value;
	 	}
	 	public function updReve_nota_vend($value){
	 	 	$this->reve_nota_vend = $value;
	 	}
	 	public function updReve_vencimento($value){
	 	 	$this->reve_vencimento = $value;
	 	}
	 	public function updReve_texto($value){
	 	 	$this->reve_texto = $value;
	 	}
	 	public function updReve_dtaniver1($value){
	 	 	$this->reve_dtaniver1 = $value;
	 	}
	 	public function updReve_dtaniver2($value){
	 	 	$this->reve_dtaniver2 = $value;
	 	}
	 	public function updReve_foto($value){
	 	 	$this->reve_foto = $value;
	 	}
	 	public function updQtd_carros_vitrine($value){
	 	 	$this->qtd_carros_vitrine = $value;
	 	}
	 	public function updReve_cont_02($value){
	 	 	$this->reve_cont_02 = $value;
	 	}
	 	public function updReve_cont_01($value){
	 	 	$this->reve_cont_01 = $value;
	 	}
	 	public function updDt_cancelamento($value){
	 	 	$this->dt_cancelamento = $value;
	 	}
	 	public function updDt_alteracao($value){
	 	 	$this->dt_alteracao = $value;
	 	}
	 	public function updId_pacote($value){
	 	 	$this->id_pacote = $value;
	 	}
	 	public function updReve_produtos($value){
	 	 	$this->reve_produtos = $value;
	 	}
	 	public function updTexto_servico($value){
	 	 	$this->texto_servico = $value;
	 	}
	 	public function updTexto_comochegar($value){
	 	 	$this->texto_comochegar = $value;
	 	}
	 	public function updId_representante($value){
	 	 	$this->id_representante = $value;
	 	}
	 	public function updId_filialbv($value){
	 	 	$this->id_filialbv = $value;
	 	}
	 	public function updId_codbv($value){
	 	 	$this->id_codbv = $value;
	 	}
	 	public function updOperador_bv($value){
	 	 	$this->operador_bv = $value;
	 	}
	 	public function updQtde_contratos($value){
	 	 	$this->qtde_contratos = $value;
	 	}
	 	public function updValor_bonificado($value){
	 	 	$this->valor_bonificado = $value;
	 	}
	 	public function updTipo_faturamento($value){
	 	 	$this->tipo_faturamento = $value;
	 	}
	 	public function updTipo_pessoa($value){
	 	 	$this->tipo_pessoa = $value;
	 	}
	 	public function updValor_mensalidade($value){
	 	 	$this->valor_mensalidade = $value;
	 	}
	 	public function updReve_im($value){
	 	 	$this->reve_im = $value;
	 	}
	 	public function updId_serie($value){
	 	 	$this->id_serie = $value;
	 	}
	 	public function updReve_modelo_nfe($value){
	 	 	$this->reve_modelo_nfe = $value;
	 	}
	 	public function updCod_clas_fis_cod($value){
	 	 	$this->cod_clas_fis_cod = $value;
	 	}
	 	public function updCnae_cod($value){
	 	 	$this->cnae_cod = $value;
	 	}
	 	public function updIntegrador($value){
	 	 	$this->integrador = $value;
	 	}
	 	public function updReve_dominio_exp($value){
	 	 	$this->reve_dominio_exp = $value;
	 	}
	 	#construct
	 	public function __construct($codigo = NULL,
	 	 	 	 	 	 	 	 	$reve_dtcadastro = NULL,
	 	 	 	 	 	 	 	 	$reve_razao = NULL,
	 	 	 	 	 	 	 	 	$reve_cnpj = NULL,
	 	 	 	 	 	 	 	 	$reve_ie = NULL,
	 	 	 	 	 	 	 	 	$reve_email = NULL,
	 	 	 	 	 	 	 	 	$reve_url = NULL,
	 	 	 	 	 	 	 	 	$reve_status = NULL,
	 	 	 	 	 	 	 	 	$pess_cod = NULL,
	 	 	 	 	 	 	 	 	$reve_nota_vend = NULL,
	 	 	 	 	 	 	 	 	$reve_vencimento = NULL,
	 	 	 	 	 	 	 	 	$reve_texto = NULL,
	 	 	 	 	 	 	 	 	$reve_dtaniver1 = NULL,
	 	 	 	 	 	 	 	 	$reve_dtaniver2 = NULL,
	 	 	 	 	 	 	 	 	$reve_foto = NULL,
	 	 	 	 	 	 	 	 	$qtd_carros_vitrine = NULL,
	 	 	 	 	 	 	 	 	$reve_cont_02 = NULL,
	 	 	 	 	 	 	 	 	$reve_cont_01 = NULL,
	 	 	 	 	 	 	 	 	$dt_cancelamento = NULL,
	 	 	 	 	 	 	 	 	$dt_alteracao = NULL,
	 	 	 	 	 	 	 	 	$id_pacote = NULL,
	 	 	 	 	 	 	 	 	$reve_produtos = NULL,
	 	 	 	 	 	 	 	 	$texto_servico = NULL,
	 	 	 	 	 	 	 	 	$texto_comochegar = NULL,
	 	 	 	 	 	 	 	 	$id_representante = NULL,
	 	 	 	 	 	 	 	 	$id_filialbv = NULL,
	 	 	 	 	 	 	 	 	$id_codbv = NULL,
	 	 	 	 	 	 	 	 	$operador_bv = NULL,
	 	 	 	 	 	 	 	 	$qtde_contratos = NULL,
	 	 	 	 	 	 	 	 	$valor_bonificado = NULL,
	 	 	 	 	 	 	 	 	$tipo_faturamento = NULL,
	 	 	 	 	 	 	 	 	$tipo_pessoa = NULL,
	 	 	 	 	 	 	 	 	$valor_mensalidade = NULL,
	 	 	 	 	 	 	 	 	$reve_im = NULL,
	 	 	 	 	 	 	 	 	$id_serie = NULL,
	 	 	 	 	 	 	 	 	$reve_modelo_nfe = NULL,
	 	 	 	 	 	 	 	 	$cod_clas_fis_cod = NULL,
	 	 	 	 	 	 	 	 	$cnae_cod = NULL,
	 	 	 	 	 	 	 	 	$integrador = NULL,
	 	 	 	 	 	 	 	 	$reve_dominio_exp = NULL,
	 	 	 	 	 	 	 	 	$dataCadastro = NULL, 
	 	 	 	 	 	 	 	 	$dataAlteracao  = NULL){ 

	 	 	$this->clear();

	 	 	$this->setCodigo($codigo);
	 	 	$this->setReve_dtcadastro($reve_dtcadastro); 
	 	 	$this->setReve_razao($reve_razao); 
	 	 	$this->setReve_cnpj($reve_cnpj); 
	 	 	$this->setReve_ie($reve_ie); 
	 	 	$this->setReve_email($reve_email); 
	 	 	$this->setReve_url($reve_url); 
	 	 	$this->setReve_status($reve_status); 
	 	 	$this->setPess_cod($pess_cod); 
	 	 	$this->setReve_nota_vend($reve_nota_vend); 
	 	 	$this->setReve_vencimento($reve_vencimento); 
	 	 	$this->setReve_texto($reve_texto); 
	 	 	$this->setReve_dtaniver1($reve_dtaniver1); 
	 	 	$this->setReve_dtaniver2($reve_dtaniver2); 
	 	 	$this->setReve_foto($reve_foto); 
	 	 	$this->setQtd_carros_vitrine($qtd_carros_vitrine); 
	 	 	$this->setReve_cont_02($reve_cont_02); 
	 	 	$this->setReve_cont_01($reve_cont_01); 
	 	 	$this->setDt_cancelamento($dt_cancelamento); 
	 	 	$this->setDt_alteracao($dt_alteracao); 
	 	 	$this->setId_pacote($id_pacote); 
	 	 	$this->setReve_produtos($reve_produtos); 
	 	 	$this->setTexto_servico($texto_servico); 
	 	 	$this->setTexto_comochegar($texto_comochegar); 
	 	 	$this->setId_representante($id_representante); 
	 	 	$this->setId_filialbv($id_filialbv); 
	 	 	$this->setId_codbv($id_codbv); 
	 	 	$this->setOperador_bv($operador_bv); 
	 	 	$this->setQtde_contratos($qtde_contratos); 
	 	 	$this->setValor_bonificado($valor_bonificado); 
	 	 	$this->setTipo_faturamento($tipo_faturamento); 
	 	 	$this->setTipo_pessoa($tipo_pessoa); 
	 	 	$this->setValor_mensalidade($valor_mensalidade); 
	 	 	$this->setReve_im($reve_im); 
	 	 	$this->setId_serie($id_serie); 
	 	 	$this->setReve_modelo_nfe($reve_modelo_nfe); 
	 	 	$this->setCod_clas_fis_cod($cod_clas_fis_cod); 
	 	 	$this->setCnae_cod($cnae_cod); 
	 	 	$this->setIntegrador($integrador); 
	 	 	$this->setReve_dominio_exp($reve_dominio_exp); 

	 	 	parent::setDataCadastro($dataCadastro); 
	 	 	parent::setDataAlteracao($dataAlteracao); 
	 	}
	}
?>