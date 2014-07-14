<? if(!defined('BASEPATH')) die();

	class configuracao_fiscal_lote_model extends MY_Model {

		protected $_table_name = "nfe_configuracao_fiscal_padrao";
		protected $_primary_key = "conf_fisc_id";
		protected $_primary_filter = "intval";
		protected $_order_by = "conf_fisc_id";
		protected $_rules =  array(
					array("field" => "conf_fisc_id",			            "label" => "ID",			                        "rules" =>"trim|integer", ),
					array("field" => "cfop_cod",				            "label" => "Código CFOP",				            "rules" =>"trim|required|integer", ),
					array("field" => "nat_ope_cod",				            "label" => "Natureza da Operação",			        "rules" =>"trim|required|integer", ),
					array("field" => "conf_fisc_descricao",			        "label" => "Descricao da Configuração Fiscal",		"rules" =>"trim|required|max_length[40]", ),
					array("field" => "cod_clas_fis_cod_origem",			    "label" => "Origem",			                    "rules" =>"trim|required|integer", ),
                    array("field" => "cod_clas_fis_cod_simples_nacional",	"label" => "Smples Nacional",			            "rules" =>"trim|integer", ),
                    array("field" => "cod_clas_fis_cod_icms",				"label" => "Código ICMS", 	                        "rules" =>"trim|required|integer", ),
                    array("field" => "conf_fisc_icms_perc_reducao_base",	"label" => "Percentual ICMS",				        "rules" =>"trim|required", ),
                    array("field" => "conf_fisc_icms_aliq_interna",			"label" => "Aliquota ICMS",			                "rules" =>"trim|required", ),
                    array("field" => "cod_clas_fis_cod_ipi",			    "label" => "Código IPI",		                    "rules" =>"trim|required|integer", ),
                    array("field" => "conf_fisc_ipi_perc_base",			    "label" => "Percentual  IPI",			            "rules" =>"trim|required", ),
                    array("field" => "conf_fisc_ipi_aliq",				    "label" => "Aliquota IPI", 	                        "rules" =>"trim|required", ),
                    array("field" => "conf_fisc_ipi_vl_unidade",	        "label" => "Valor Unitário do IPI",				    "rules" =>"trim|required", ),
                    array("field" => "cod_clas_fis_cod_pis",			    "label" => "Percentual PIS",		            "rules" =>"trim|required|integer", ),
                    array("field" => "conf_fisc_pis_perc_base",			    "label" => "Código PIS",        		            "rules" =>"trim|required", ),
                    array("field" => "conf_fisc_pis_aliq",			        "label" => "Aliquota PIS",			                "rules" =>"trim|required", ),
                    array("field" => "cod_clas_fis_cod_cofins",				"label" => "Código Cofins", 	                    "rules" =>"trim|required|integer", ),
                    array("field" => "conf_fisc_cofins_perc_base",	        "label" => "Percentual Cofins",				        "rules" =>"trim|required", ),
                    array("field" => "conf_fisc_cofins_aliq",			    "label" => "Aliquota Cofins",			            "rules" =>"trim|required", ),
                    array("field" => "conf_fisc_irpj_perc_base",			"label" => "Percentual IRPJ",		                "rules" =>"trim|required", ),
                    array("field" => "conf_fisc_irpj_aliq",			        "label" => "Aliquota  IRPJ",			            "rules" =>"trim|required", ),
                    array("field" => "conf_fisc_ii_perc_base",				"label" => "Percentual II", 	                    "rules" =>"trim|required", ),
                    array("field" => "conf_fisc_ii_aliq",	                "label" => "Aliquota  II",				            "rules" =>"trim|required", ),
                    array("field" => "conf_fisc_tipo",			            "label" => "Tipo",			                        "rules" =>"trim|required|integer", ),
                    array("field" => "conf_fisc_situacao",			        "label" => "Situação",		                        "rules" =>"trim|required|alpha|exact_length[1]", ),
        );

		public function __construct()
		{
			parent::__construct();
		}
        /*
        * restore primary key
        *[RevMais PgSQL] #32  --- duplicate key value violates unique constraint "nfe_configuracao_fiscal_pkey"
        *the logic of the primary key was broken, updating the primary key should be taken
         * ERROR:  lastval is not yet defined in this session (on insert)
        */

        public function get_max_cf(){
            $this->db->select_max('conf_fisc_id','cf_id');
            $query = $this->db->get('nfe_configuracao_fiscal_padrao')->row();
            return $query->cf_id;
        }
        public function save($data, $id = NULL){
            if ($this->_timestamps == TRUE) {
                $now = date('Y-m-d H:i:s');
                $id || $data['created'] = $now;
                $data['modified'] = $now;
            }
            // Insert
            if ($id == NULL) {
                $this->db->set($data);
                $this->db->insert($this->_table_name);
                $id = $this->db->insert_id();

            }
            else {
                $filter = $this->_primary_filter;
                $id = $filter($id);
                $this->db->set($data);
                $this->db->where($this->_primary_key, $id);
                $this->db->update($this->_table_name);
            }
            return $id;
        }

        public function get_selects($fields, $table,$where, $order,$reve=FALSE){
            $query = $this->db->select($fields);
            $query->from($table);
            if($where != NULL && $reve == FALSE)
            {
                $query->where($where);
            }
            elseif($reve == TRUE)
            {
                $query->where('reve_cod',4)
                      ->where($where);
            }
            $query->order_by($order);
            return $query->get()->result();
        }
	 }