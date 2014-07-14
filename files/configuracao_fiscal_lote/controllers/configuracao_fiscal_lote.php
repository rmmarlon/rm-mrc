<? if(! defined('BASEPATH')) die();
	class Configuracao_fiscal_lote extends MY_Controller
    {
		protected $_like_column = "conf_fisc_descricao";
		protected $_controller_name = "configuracao_fiscal_lote";

		public function __construct()
		{
			parent::__construct();
			$this->model = $this->load->model('configuracao_fiscal_lote_model');
		}

		public function save()
		{
			if($find = $this->input->post('find'))
			{
				$this->data['find'] = $find;
			}
			if(!$this->input->post('save'))
			{
				//Get form
				$id = $this->input->post('id');
				if($id)
				{
					$conf_fisc = $this->model->get($id);
                    if(preg_match('/^[1-3]{1}/i',substr($conf_fisc->cfop_cod,0,1)))
                        $conf_fisc->nat_ope_cod = $this->dropdown_natureza_operacao('E',$conf_fisc->nat_ope_cod);
                    else
                        $conf_fisc->nat_ope_cod = $this->dropdown_natureza_operacao('S',$conf_fisc->nat_ope_cod);
                    $conf_fisc->cfop_cod = $this->dropdown_cfop($conf_fisc->cfop_cod);
                    $conf_fisc->cod_clas_fis_cod_cofins = $this->dropdown_imposto($conf_fisc->cod_clas_fis_cod_cofins,'cod_clas_fis_cod_cofins','C');
                    $conf_fisc->cod_clas_fis_cod_simples_nacional = $this->dropdown_imposto($conf_fisc->cod_clas_fis_cod_simples_nacional,'cod_clas_fis_cod_simples_nacional','N');
                    $conf_fisc->cod_clas_fis_cod_origem = $this->dropdown_imposto($conf_fisc->cod_clas_fis_cod_origem,'cod_clas_fis_cod_origem','O');
                    $conf_fisc->cod_clas_fis_cod_ipi = $this->dropdown_imposto($conf_fisc->cod_clas_fis_cod_ipi,'cod_clas_fis_cod_ipi','P');
                    $conf_fisc->cod_clas_fis_cod_pis = $this->dropdown_imposto($conf_fisc->cod_clas_fis_cod_pis,'cod_clas_fis_cod_pis','S');
                    $conf_fisc->cod_clas_fis_cod_icms = $this->dropdown_imposto($conf_fisc->cod_clas_fis_cod_icms,'cod_clas_fis_cod_icms', 'I');
					$this->data['item'] = array($conf_fisc);
                    if($this->data['item'][0]->conf_fisc_tipo == '1')
                        $this->data['tipo_yes'] = 'checked';
                    else
                        $this->data['tipo_no'] = 'checked';
                    if($this->data['item'][0]->conf_fisc_situacao == 'A')
                        $this->data['situacao_yes'] = 'checked';
                    else
                        $this->data['situacao_no'] = 'checked';
				}
				else
				{
					$this->data['item'] = array(
						array(
							"conf_fisc_id"			            => "",
							"cfop_cod"			                => $this->dropdown_cfop(),
							"nat_ope_cod"			            => $this->dropdown_natureza_operacao('E'),
							"conf_fisc_descricao"			    => "",
							"conf_fisc_mensagem"			    => "",
							"cod_clas_fis_cod_origem"			=> $this->dropdown_imposto('','cod_clas_fis_cod_origem',"O"),
							"cod_clas_fis_cod_simples_nacional"	=> $this->dropdown_imposto('','cod_clas_fis_cod_simples_nacional', 'N'),
							"cod_clas_fis_cod_icms"			    => $this->dropdown_imposto('','cod_clas_fis_cod_icms', 'I'),
							"conf_fisc_icms_perc_reducao_base"	=> "",
							"conf_fisc_icms_aliq_interna"		=> "",
							"cod_clas_fis_cod_ipi"			    => $this->dropdown_imposto('','cod_clas_fis_cod_ipi','P'),
							"conf_fisc_ipi_perc_base"			=> "",
							"conf_fisc_ipi_aliq"			    => "",
							"conf_fisc_ipi_vl_unidade"			=> "",
							"cod_clas_fis_cod_pis"			    => $this->dropdown_imposto('','cod_clas_fis_cod_pis','S'),
							"conf_fisc_pis_perc_base"			=> "",
							"conf_fisc_pis_aliq"			    => "",
							"cod_clas_fis_cod_cofins"			=> $this->dropdown_imposto('','cod_clas_fis_cod_cofins','C'),
							"conf_fisc_cofins_perc_base"		=> "",
							"conf_fisc_cofins_aliq"			    => "",
							"conf_fisc_irpj_perc_base"			=> "",
							"conf_fisc_irpj_aliq"			    => "",
							"conf_fisc_ii_perc_base"			=> "",
							"conf_fisc_ii_aliq"			        => "",
							"conf_fisc_situacao"			    => "",
							"conf_fisc_tipo"			        => "",
						)
					);

                    $this->data['tipo_yes'] = 'checked';
                    $this->data['situacao_yes'] = 'checked';
				}
                $this->data['sav_edt'] = ($id? "Atualizar" : "Cadastrar");
                $this->data['head_save'] = ucwords(str_replace("_", " ", $this->_controller_name));
                $this->data['head_link'] = $this->_controller_name;
				$this->load->library('parser');
				$this->parser->parse('crud/head_save', $this->data);
				$this->parser->parse($this->_controller_name.'/save', $this->data);
			}
			else
			{
                if($this->input->post("cod_clas_fis_cod_simples_nacional") == NULL){
                    $this->form_validation->set_rules($this->model->rules());
                } else{
                    $this->form_validation->set_rules($this->model->rules(
                        array(
                            array("field" => "conf_fisc_id",			            "label" => "ID",			                        "rules" =>"trim|integer", ),
                            array("field" => "cfop_cod",				            "label" => "Código CFOP",				            "rules" =>"trim|required|integer", ),
                            array("field" => "nat_ope_cod",				            "label" => "Natureza da Operação",			        "rules" =>"trim|required|integer", ),
                            array("field" => "conf_fisc_descricao",			        "label" => "Descricao da Configuração Fiscal",		"rules" =>"trim|required|max_length[40]", ),
                            array("field" => "conf_fisc_mensagem",			        "label" => "Mensagem Fisca",			            "rules" =>"trim|max_length[490]", ),
                            array("field" => "cod_clas_fis_cod_origem",			    "label" => "Origem da Mercadoria",		            "rules" =>"trim|required", ),
                            array("field" => "cod_clas_fis_cod_simples_nacional",	"label" => "Simples Nacional",          	        "rules" =>"trim|required", ),
                            array("field" => "conf_fisc_situacao",			        "label" => "Situação",			                    "rules" =>"trim|required", ),
                            array("field" => "conf_fisc_tipo",			            "label" => "Tipo",			                        "rules" =>"trim|required", ),
                        )
                    ));
                }
				if($this->form_validation->run() === FALSE)
				{
					$this->_response = ERROR(123, validation_errors());
				}
				else
				{
                    /*
                    [RevMais PgSQL] #32  --- duplicate key value violates unique constraint "nfe_configuracao_fiscal_pkey"
                    the logic of the primary key was broken, updating the primary key should be taken
                    */
                    $conf_fisc_id = $this->model->get_max_cf()+1;

					$id = $this->input->post("conf_fisc_id");

					$data = array(
                        "conf_fisc_id"                          => intval(($id? $id : $conf_fisc_id)),
						"cfop_cod"                              => $this->input->post('cfop_cod', TRUE),
						"nat_ope_cod"                           => $this->input->post('nat_ope_cod', TRUE),
						"conf_fisc_descricao"                   => ucwords($this->input->post('conf_fisc_descricao', TRUE)),
						"conf_fisc_mensagem"                    => $this->input->post('conf_fisc_mensagem', TRUE),
						"cod_clas_fis_cod_origem"               => $this->input->post('cod_clas_fis_cod_origem', TRUE),
						"cod_clas_fis_cod_simples_nacional"     => validaNull(intval($this->input->post('cod_clas_fis_cod_simples_nacional', TRUE))),
						"cod_clas_fis_cod_icms"                 => validaNull($this->input->post('cod_clas_fis_cod_icms', TRUE)),
						"conf_fisc_icms_perc_reducao_base"      => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_icms_perc_reducao_base', TRUE))),
						"conf_fisc_icms_aliq_interna"           => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_icms_aliq_interna', TRUE))),
						"cod_clas_fis_cod_ipi"                  => validaNull($this->input->post('cod_clas_fis_cod_ipi', TRUE)),
						"conf_fisc_ipi_perc_base"               => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_ipi_perc_base', TRUE))),
						"conf_fisc_ipi_aliq"                    => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_ipi_aliq', TRUE))),
						"conf_fisc_ipi_vl_unidade"              => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_ipi_vl_unidade', TRUE))),
						"cod_clas_fis_cod_pis"                  => validaNull($this->input->post('cod_clas_fis_cod_pis', TRUE)),
						"conf_fisc_pis_perc_base"               => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_pis_perc_base', TRUE))),
						"conf_fisc_pis_aliq"                    => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_pis_aliq', TRUE))),
						"cod_clas_fis_cod_cofins"               => validaNull($this->input->post('cod_clas_fis_cod_cofins', TRUE)),
						"conf_fisc_cofins_perc_base"            => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_cofins_perc_base', TRUE))),
						"conf_fisc_cofins_aliq"                 => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_cofins_aliq', TRUE))),
						"conf_fisc_irpj_perc_base"              => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_irpj_perc_base', TRUE))),
						"conf_fisc_irpj_aliq"                   => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_irpj_aliq', TRUE))),
						"conf_fisc_ii_perc_base"                => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_ii_perc_base', TRUE))),
						"conf_fisc_ii_aliq"                     => validaNull(fu_trata_valor_insert($this->input->post('conf_fisc_ii_aliq', TRUE))),
						"conf_fisc_situacao"                    => $this->input->post('conf_fisc_situacao', TRUE),
						"conf_fisc_tipo"                        => $this->input->post('conf_fisc_tipo', TRUE),
					);

                    $this->model->save($data, $id);
					$this->data['success'] = "Registro " . ($id? " Atualizado" : " Inserido") . " com sucesso!";
					$this->index();
				}
			}
		}

        public function dropdown_imposto($selected = '',$name,$tipo)
        {
            $imposto = array();

            if($name == 'cod_clas_fis_cod_simples_nacional')
                $imposto[NULL] = "Não se Aplica";
            else
                $imposto[NULL] = '';
            foreach($this->model->get_selects('id,cod_clas_fis_cod, cod_clas_fis_cst,cod_clas_fis_descricao,','nfe_classificacao_fiscal', array('cod_clas_fis_tipo'=>$tipo),'cod_clas_fis_cst') as $im)
            {
                $imposto[$im->cod_clas_fis_cod] = $im->cod_clas_fis_cst . " - " . $im->cod_clas_fis_descricao;
            }
            if($name != 'cod_clas_fis_cod_simples_nacional' && $name != 'cod_clas_fis_cod_origem')
                return form_dropdown($name,$imposto,$selected,' class="form-control imposto-disabled"');
            else
                return form_dropdown($name,$imposto,$selected,' id="'.$name.'" class="form-control"');
        }

        public function dropdown_cfop($selected='')
        {
            $cfop = array();
            foreach($this->model->get_selects('cfop_cod,cfop_descricao,cfop_ent_sai','nfe_cfop',$where=NULL,'cfop_cod') as $c)
            {
                $cfop[$c->cfop_cod] = $c->cfop_cod .' - '. $c->cfop_descricao;
            }
            return form_dropdown('cfop_cod',$cfop,$selected,' id="cfop_cod" class="form-control"');
        }

        public function dropdown_natureza_operacao($tp,$selected = '')
        {
            $natureza_operacao = array();
            foreach($this->model->get_selects('id,nat_ope_descricao','nfe_natureza_operacao', array('nat_ope_tipo'=>$tp),'id',TRUE) as $no)
            {
                $natureza_operacao[$no->id] = $no->nat_ope_descricao;
            }
            return form_dropdown('nat_ope_cod',$natureza_operacao,$selected,' id="nat_ope_cod" class="form-control"');
        }

        public function dropdownNaturezaOperacao()
        {
            $id = $this->input->post('id');
            $this->data['output'] = $this->dropdown_natureza_operacao($id);
            $this->load->library('parser');
            $this->parser->parse('crud/output', $this->data);
        }
	}
