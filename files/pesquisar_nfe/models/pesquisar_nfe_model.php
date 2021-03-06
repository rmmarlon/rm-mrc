<? if(!defined('BASEPATH')) die();

	class pesquisar_nfe_model extends MY_Model {

		protected $_table_name = "nfe_nota";
		protected $_primary_key = "id_nfe";
		protected $_primary_filter = "intval";
		protected $_order_by = "nfe_nota.id_nfe";
		protected $_rules =  array(
					array("field" => "id_nfe",				                        "label" => "id_nfe",				            "rules" =>"trim|required", ),
					array("field" => "id_serie",				                    "label" => "id_serie",		            		"rules" =>"trim|required", ),
					array("field" => "nfe_serie_cod",				                "label" => "nfe_serie_cod",		            	"rules" =>"trim|integer", ),
                    array("field" => "reve_cod",				                    "label" => "nfe_serie_cod",		            	"rules" =>"trim|integer", ),
                    array("field" => "nfe_nr_nota",			                        "label" => "nfe_nr_nota",		            	"rules" =>"trim|required", ),
					array("field" => "nfe_situacao",			                    "label" => "nfe_situacao",		            	"rules" =>"trim|required", ),
					array("field" => "nat_ope_cod",				                    "label" => "nat_ope_cod",		            	"rules" =>"trim|integer", ),
					array("field" => "nfe_nat_ope_descricao",			            "label" => "nfe_nat_ope_descricao",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_nat_ope_tipo",			                "label" => "nfe_nat_ope_tipo",	        		"rules" =>"trim|required", ),
					array("field" => "nfe_data_nota",			                    "label" => "nfe_data_nota",		            	"rules" =>"trim|required", ),
					array("field" => "nfe_finalidade",			                    "label" => "nfe_finalidade",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_cod_clas_fis_descricao",			        "label" => "nfe_cod_clas_fis_descricao",		"rules" =>"trim|required", ),
					array("field" => "nfe_consumidor_final",			            "label" => "nfe_consumidor_final",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_consumidor_final_desc",			        "label" => "nfe_consumidor_final_desc",			"rules" =>"trim|required", ),
					array("field" => "nfe_observacao",			                    "label" => "nfe_observacao",			        "rules" =>"trim|required", ),
					array("field" => "nfe_observacao_fiscal",			            "label" => "nfe_observacao_final",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_reve_razao",			                    "label" => "nfe_reve_razao",	        		"rules" =>"trim|required", ),
					array("field" => "nfe_reve_cnpj",			                    "label" => "nfe_reve_cnpj",		            	"rules" =>"trim|required", ),
					array("field" => "nfe_reve_fantasia",			                "label" => "nfe_reve_fantasia",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_reve_ie",			                        "label" => "nfe_reve_ie",		            	"rules" =>"trim|required", ),
					array("field" => "nfe_reve_im",			                        "label" => "nfe_reve_im",		            	"rules" =>"trim|required", ),
					array("field" => "nfe_reve_email",			                    "label" => "nfe_reve_email",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_reve_modelo_nfe",			                "label" => "nfe_reve_modelo_nfe",	        	"rules" =>"trim|required", ),
					array("field" => "nfe_reve_ddd_fone",			                "label" => "nfe_reve_ddd_fone",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_reve_cnae_cod",				            "label" => "nfe_reve_cnae_cod",		        	"rules" =>"trim|integer", ),
					array("field" => "nfe_reve_cod_clas_fis",			            "label" => "nfe_reve_cod_clas_fis",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_reve_danfe_orientacao",			        "label" => "nfe_reve_danfe_orientacao",			"rules" =>"trim|required", ),
					array("field" => "nfe_endr_nome_rev",			                "label" => "nfe_endr_nome_rev",			        "rules" =>"trim|required", ),
					array("field" => "nfe_endr_numero_rev",			                "label" => "nfe_endr_numero_rev",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_endr_cep_rev",			                "label" => "nfe_endr_cep_rev",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_endr_bairro_rev",			                "label" => "nfe_endr_bairro_rev",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_endr_complemento_rev",			        "label" => "nfe_endr_complemento_rev",			"rules" =>"trim|required", ),
					array("field" => "nfe_cida_cod_rev",			                "label" => "nfe_cida_cod_rev",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_cida_nome_rev",			                "label" => "nfe_cida_nome_rev",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_cida_ibge_rev",			                "label" => "nfe_cida_ibge_rev",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_esta_cod_rev",			                "label" => "nfe_esta_cod_rev",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_esta_cod_bacen_rev",		            	"label" => "nfe_esta_cod_bacen_rev",			"rules" =>"trim|required", ),
					array("field" => "nfe_esta_nome_rev",	                		"label" => "nfe_esta_nome_rev",			        "rules" =>"trim|required", ),
					array("field" => "nfe_pais_cod_bancen_rev",		            	"label" => "nfe_pais_cod_bancen_rev",			"rules" =>"trim|required", ),
					array("field" => "nfe_pais_nome_rev",			                "label" => "nfe_pais_nome_rev",		        	"rules" =>"trim|required", ),
					array("field" => "clie_cod",				                    "label" => "clie_cod",				            "rules" =>"trim|integer", ),
					array("field" => "nfe_pess_nome",			                    "label" => "nfe_pess_nome",		            	"rules" =>"trim|required", ),
					array("field" => "nfe_clie_cpf_cnpj",			                "label" => "nfe_clie_cpf_cnpj",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_clie_apelido_fantasia",			        "label" => "nfe_clie_apelido_fantasia",			"rules" =>"trim|required", ),
					array("field" => "nfe_clie_rg_ie",			                    "label" => "nfe_clie_rg_ie",			        "rules" =>"trim|required", ),
					array("field" => "nfe_clie_email",			                    "label" => "nfe_clie_email",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_clie_ddd_fone",			                "label" => "nfe_clie_ddd_fone",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_clie_fone",		                    	"label" => "nfe_clie_fone",		            	"rules" =>"trim|required", ),
					array("field" => "nfe_cnae_cod",				                "label" => "nfe_cnae_cod",		            	"rules" =>"trim|integer", ),
					array("field" => "nfe_endr_nome_cli",			                "label" => "nfe_endr_nome_cli",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_endr_numero_cli",			                "label" => "nfe_endr_numero_cli",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_endr_cep_cli",			                "label" => "nfe_endr_cep_cli",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_endr_bairro_cli",		                	"label" => "nfe_endr_bairro_cli",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_endr_complemento_cli",			        "label" => "nfe_endr_complemento_cli",			"rules" =>"trim|required", ),
					array("field" => "nfe_cida_cod_cli",			                "label" => "nfe_cida_cod_cli",			        "rules" =>"trim|required", ),
					array("field" => "nfe_cida_nome_cli",			                "label" => "nfe_cida_nome_cli",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_cida_ibge_cli",			                "label" => "nfe_cida_ibge_cli",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_esta_cod_cli",			                "label" => "nfe_esta_cod_cli",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_esta_cod_bacen_cli",			            "label" => "nfe_esta_cod_bacen_cli",			"rules" =>"trim|required", ),
					array("field" => "nfe_esta_nome_cli",		                	"label" => "nfe_esta_nome_cli",			        "rules" =>"trim|required", ),
					array("field" => "nfe_pais_cod_bancen_cli",	            		"label" => "nfe_pais_cod_bancen_cli",			"rules" =>"trim|required", ),
					array("field" => "nfe_pais_nome_cli",			                "label" => "nfe_pais_nome_cli",	        		"rules" =>"trim|required", ),
					array("field" => "nfe_endr_nome_cli_entrega",		        	"label" => "nfe_endr_nome_cli_entrega",			"rules" =>"trim|required", ),
					array("field" => "nfe_endr_cnpj_entrega",			            "label" => "nfe_endr_cnpj_entrega",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_endr_numero_cli_entrega",	        		"label" => "nfe_endr_numero_cli_entrega",		"rules" =>"trim|required", ),
					array("field" => "nfe_endr_cep_cli_entrega",		        	"label" => "nfe_endr_cep_cli_entrega",			"rules" =>"trim|required", ),
					array("field" => "nfe_endr_bairro_cli_entrega",		        	"label" => "nfe_endr_bairro_cli_entrega",		"rules" =>"trim|required", ),
					array("field" => "nfe_endr_complemento_cli_entrega",			"label" => "nfe_endr_complemento_cli_entrega",	"rules" =>"trim|required", ),
					array("field" => "nfe_cida_cod_cli_entrega",			        "label" => "nfe_cida_cod_cli_entrega",			"rules" =>"trim|required", ),
					array("field" => "nfe_cida_nome_cli_entrega",			        "label" => "nfe_cida_nome_cli_entrega",			"rules" =>"trim|required", ),
					array("field" => "nfe_cida_ibge_cli_entrega",			        "label" => "nfe_cida_ibge_cli_entrega",			"rules" =>"trim|required", ),
					array("field" => "nfe_esta_cod_cli_entrega",	        		"label" => "nfe_esta_cod_cli_entrega",			"rules" =>"trim|required", ),
					array("field" => "nfe_esta_cod_bacen_cli_entrega",	    		"label" => "nfe_esta_cod_bacen_cli_entrega",	"rules" =>"trim|required", ),
					array("field" => "nfe_esta_nome_cli_entrega",		        	"label" => "nfe_esta_nome_cli_entrega",			"rules" =>"trim|required", ),
					array("field" => "nfe_pais_cod_bancen_cli_entrega",			    "label" => "nfe_pais_cod_bancen_cli_entrega",	"rules" =>"trim|required", ),
					array("field" => "nfe_pais_nome_cli_entrega",			        "label" => "nfe_pais_nome_cli_entrega",			"rules" =>"trim|required", ),
					array("field" => "nfe_endr_nome_cli_entrega",			        "label" => "nfe_endr_nome_cli_entrega",			"rules" =>"trim|required", ),
					array("field" => "nfe_endr_nome_cli_retirada",	        		"label" => "nfe_endr_nome_cli_retirada",		"rules" =>"trim|required", ),
					array("field" => "nfe_endr_cnpj_retirada",			            "label" => "nfe_endr_cnpj_retirada",			"rules" =>"trim|required", ),
					array("field" => "nfe_endr_numero_cli_retirada",	            "label" => "nfe_endr_numero_cli_retirada",		"rules" =>"trim|required", ),
					array("field" => "nfe_endr_cep_cli_retirada",       			"label" => "nfe_endr_cep_cli_retirada",			"rules" =>"trim|required", ),
					array("field" => "nfe_endr_bairro_cli_retirada",    			"label" => "nfe_endr_bairro_cli_retirada",		"rules" =>"trim|required", ),
					array("field" => "nfe_endr_complemento_cli_retirada",   		"label" => "nfe_endr_complemento_cli_retirada",	"rules" =>"trim|required", ),
					array("field" => "nfe_cida_cod_cli_retirada",			        "label" => "nfe_cida_cod_cli_retirada",			"rules" =>"trim|required", ),
					array("field" => "nfe_cida_nome_cli_retirada",			        "label" => "nfe_cida_nome_cli_retirada",		"rules" =>"trim|required", ),
					array("field" => "nfe_cida_ibge_cli_retirada",			        "label" => "nfe_cida_ibge_cli_retirada",		"rules" =>"trim|required", ),
					array("field" => "nfe_esta_cod_cli_retirada",		        	"label" => "nfe_esta_cod_cli_retirada",			"rules" =>"trim|required", ),
					array("field" => "nfe_esta_cod_bacen_cli_retirada",		        "label" => "nfe_esta_cod_bacen_cli_retirada",	"rules" =>"trim|required", ),
					array("field" => "nfe_esta_nome_cli_retirada",		        	"label" => "nfe_esta_nome_cli_retirada",		"rules" =>"trim|required", ),
					array("field" => "nfe_pais_cod_bancen_cli_retirada",			"label" => "nfe_pais_cod_bancen_cli_retirada",	"rules" =>"trim|required", ),
					array("field" => "nfe_pais_nome_cli_retirada",		        	"label" => "nfe_pais_nome_cli_retirada",		"rules" =>"trim|required", ),
					array("field" => "nfe_modalidade_frete",	            		"label" => "nfe_modalidade_frete",			    "rules" =>"trim|required", ),
					array("field" => "nfe_vl_frete",			                    "label" => "nfe_vl_frete",		            	"rules" =>"trim|required", ),
					array("field" => "nfe_forma_rateio_frete",			            "label" => "nfe_forma_rateio_frete",			"rules" =>"trim|required", ),
					array("field" => "nfe_vl_seguro",	                    		"label" => "nfe_vl_seguro",		            	"rules" =>"trim|required", ),
					array("field" => "nfe_placa_veiculo",		                	"label" => "nfe_placa_veiculo",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_ufe_veiculo",			                    "label" => "nfe_ufe_veiculo",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_antt",				                    "label" => "nfe_antt",				            "rules" =>"trim|required", ),
					array("field" => "nfe_transp_cod",			                	"label" => "nfe_transp_cod",		         	"rules" =>"trim|integer", ),
					array("field" => "nfe_pess_nome_transp",		            	"label" => "nfe_pess_nome_transp",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_transp_cpf_cnpj",	                		"label" => "nfe_transp_cpf_cnpj",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_transp_apelido_fantasia",		        	"label" => "nfe_transp_apelido_fantasia",		"rules" =>"trim|required", ),
					array("field" => "nfe_transp_ie",	                    		"label" => "nfe_transp_ie",		            	"rules" =>"trim|required", ),
					array("field" => "nfe_transp_email",		                	"label" => "nfe_transp_email",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_endr_nome_transp",		                "label" => "nfe_endr_nome_transp",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_endr_numero_transp",		            	"label" => "nfe_endr_numero_transp",			"rules" =>"trim|required", ),
					array("field" => "nfe_endr_cep_transp",			                "label" => "nfe_endr_cep_transp",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_endr_bairro_transp",		            	"label" => "nfe_endr_bairro_transp",			"rules" =>"trim|required", ),
					array("field" => "nfe_endr_complemento_transp",         		"label" => "nfe_endr_complemento_transp",		"rules" =>"trim|required", ),
					array("field" => "nfe_cida_cod_transp",			                "label" => "nfe_cida_cod_transp",			    "rules" =>"trim|required", ),
					array("field" => "nfe_cida_nome_transp",			            "label" => "nfe_cida_nome_transp",			    "rules" =>"trim|required", ),
					array("field" => "nfe_cida_ibge_transp",            			"label" => "nfe_cida_ibge_transp",	    		"rules" =>"trim|required", ),
					array("field" => "nfe_esta_cod_transp",			                "label" => "nfe_esta_cod_transp",	    		"rules" =>"trim|required", ),
					array("field" => "nfe_esta_cod_bacen_transp",		        	"label" => "nfe_esta_cod_bacen_transp",			"rules" =>"trim|required", ),
					array("field" => "nfe_esta_nome_transp",			            "label" => "nfe_esta_nome_transp",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_pais_cod_bancen_transp",		        	"label" => "nfe_pais_cod_bancen_transp",	    "rules" =>"trim|required", ),
					array("field" => "nfe_pais_nome_transp",			            "label" => "nfe_pais_nome_transp",			    "rules" =>"trim|required", ),
					array("field" => "nfe_vl_outras_despesas",		            	"label" => "nfe_vl_outras_despesas",			"rules" =>"trim|required", ),
					array("field" => "nfe_vl_desconto",	                    		"label" => "nfe_vl_desconto",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_vl_mercadorias",	                		"label" => "nfe_vl_mercadoria",			        "rules" =>"trim|required", ),
					array("field" => "nfe_vl_nota",	                        		"label" => "nfe_vl_nota",	            		"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_base_icms",		            	"label" => "nfe_imp_vl_base_icms",	    		"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_icms",	                    		"label" => "nfe_imp_vl_icms",		        	"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_isentas_icms",          			"label" => "nfe_imp_vl_isento_icms",			"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_outras_icms",		            	"label" => "nfe_imp_vl_outras_icms",			"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_base_ipi",		                	"label" => "nfe_imp_vl_base_ipi",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_ipi",		                    	"label" => "nfe_imp_vl_ipi",			        "rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_isentas_ipi",		            	"label" => "nfe_imp_vl_isentas_ipi",			"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_outras_ipi",		            	"label" => "nfe_imp_vl_outras_ipi",		       	"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_base_pis",		                	"label" => "nfe_imp_vl_base_pis",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_pis",			                    "label" => "nfe_imp_vl_pis",			        "rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_base_cofins",		            	"label" => "nfe_imp_vl_base_cofins",			"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_cofins",	                		"label" => "nfe_imp_vl_cofins",	        		"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_base_ii",			                "label" => "nfe_imp_vl_base_ii",		    	"rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_ii",	                    		"label" => "nfe_imp_vl_ii",			            "rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_base_irpj",		            	"label" => "nfe_imp_vl_base_irpj",			    "rules" =>"trim|required", ),
					array("field" => "nfe_imp_vl_irpj",	                    		"label" => "nfe_imp_vl_irpj",       			"rules" =>"trim|required", ),
					array("field" => "nfe_statusMonitor",		                	"label" => "nfe_statusMonitor",		        	"rules" =>"trim|required", ),
		);

		public function __construct()
		{
			parent::__construct();
		}

        public function get($id=NULL, $single=FALSE)
        {
            $this->db->select('nfe_nota.id_nfe as nfe_cod,*')
                     ->join('nfe_notaitens as ni', 'nfe_nota.id_nfe = ni.id_nfe','left')
                     ->join('modelos as mod', 'ni.mode_cod = mod.mode_cod','left')
                     ->where('reve_cod',$this->session->userdata('ss_empresa_conectada'));
            return parent::get($id,$single);
        }
        public function count_pages()
        {
            $this->db->select('nfe_nota.id_nfe as nfe_cod,*')
                ->join('nfe_notaitens as ni', 'nfe_nota.id_nfe = ni.id_nfe','left')
                ->join('modelos as mod', 'ni.mode_cod = mod.mode_cod','left')
                ->where('reve_cod',$this->session->userdata('ss_empresa_conectada'));
            return ceil($this->db->count_all_results($this->_table_name)/$this->_limit);
        }
        public function get_like($like,$p=1)
        {
            $p--;
            $this->db->select('nfe_nota.id_nfe as nfe_cod,*')
                     ->join('nfe_notaitens as ni', 'nfe_nota.id_nfe = ni.id_nfe','left')
                     ->join('modelos as mod', 'ni.mode_cod = mod.mode_cod','left')
                     ->where('reve_cod',$this->session->userdata('ss_empresa_conectada'))
                     ->limit($this->_limit,$p*$this->_limit)
                     ->ilike($like);
            return parent::get();
        }
        public function count_all()
        {
            $this->db->where('reve_cod',$this->session->userdata('ss_empresa_conectada'));
            return parent::count_all();
        }
        public function get_empresa()
        {
            $query = $this->db->select('*')
                ->from('nfe_empresa')
                ->where('situacao','A')
                ->where('reve_cod', $this->session->userdata('ss_empresa_conectada'))
                ->get();
            return $query->result();
        }
        public function get_configuracao_fiscal()
        {
            $query = $this->load->model('configuracao_fiscal/configuracao_fiscal_model');
            $query->order_by('conf_fisc_descricao');
            $query->order_direction('ASC');
            return $query->get();
        }
        public function get_finalidade()
        {
            $query = $this->db->select('*')
                ->from('nfe_classificacao_fiscal')
                ->where('cod_clas_fis_tipo','F')
                ->where('cod_clas_fis_situacao <>','E')
                ->get();
            return $query->result();
        }
        public function get_estado(){
            $query = $this->db->select('*')
            ->from('estados')
            ->order_by('esta_nome')
            ->get();
            return $query->result();
        }
	 } 
?>