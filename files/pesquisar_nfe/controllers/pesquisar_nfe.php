<? if(! defined('BASEPATH')) die();
	class Pesquisar_nfe extends MY_Controller{

		protected $_like_column = "mode_nome";
		protected $_controller_name = "pesquisar_nfe";

		public function __construct()
		{
			parent::__construct();
			$this->model = $this->load->model('pesquisar_nfe_model');
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
					$pesquisar_nf = $this->model->get($id);
                    $pesquisar_nf->nfe_reve_razao = $this->dropdown_empresa($pesquisar_nf->nfe_reve_razao);
					$this->data['item'] = array($pesquisar_nf);
					if($this->data['item'][0]->id_status == 't')
						$this->data['checked_yes'] = 'checked';
					else
						$this->data['checked_no'] = 'checked';
				}
				else
				{
					$this->data['item'] = array(
						array(
							"id_nfe"			            => "",
							"id_serie"			            => "",
							"nfe_serie_cod"			        => "",
                            "reve_cod"                      => $this->session->userdata('ss_empresa_conectada'),
							"nfe_nr_nota"			        => "",
							"nfe_situacao"			        => "",
							"nat_ope_cod"			        => "",
							"nfe_nat_ope_descricao"			=> "",
							"nfe_nat_ope_tipo"			    => "",
							"nfe_data_nota"			        => "",
							"nfe_finalidade"			    => $this->dropdown_finalidade(),
							"nfe_cod_clas_fis_descricao"	=> "",
							"nfe_consumidor_final"			=> "",
							"nfe_consumidor_final_desc"		=> "",
							"nfe_observacao"			    => "",
							"nfe_observacao_fiscal"			=> "",
                            "nfe_item_cfop_cod"             => $this->dropdown_configuracal_fiscal(),
							"nfe_reve_razao"			    => $this->dropdown_empresa(),
							"nfe_reve_cnpj"			        => "",
							"nfe_reve_fantasia"			    => "",
							"nfe_reve_ie"			        => "",
							"nfe_reve_im"			        => "",
							"nfe_reve_email"			    => "",
							"nfe_reve_modelo_nfe"			=> "",
							"nfe_reve_ddd_fone"			    => "",
							"nfe_reve_cnae_cod"			    => "",
							"nfe_reve_cod_clas_fis"			=> "",
							"nfe_reve_danfe_orientacao"		=> "",
							"nfe_endr_nome_rev"			    => "",
							"nfe_endr_numero_rev"			=> "",
							"nfe_endr_cep_rev"			    => "",
							"nfe_endr_bairro_rev"			=> "",
							"nfe_endr_complemento_rev"		=> "",
							"nfe_cida_cod_rev"			    => "",
							"nfe_cida_nome_rev"			    => "",
							"nfe_cida_ibge_rev"			    => "",
							"nfe_esta_cod_rev"			    => "",
							"nfe_esta_cod_bacen_rev"		=> "",
							"nfe_esta_nome_rev"			    => "",
							"nfe_pais_cod_bancen_rev"		=> "",
							"nfe_pais_nome_rev"			    => "",
							"clie_cod"			            => "",
							"nfe_pess_nome"			        => "",
							"nfe_clie_cpf_cnpj"			    => "",
							"nfe_clie_apelido_fantasia"		=> "",
							"nfe_clie_rg_ie"			    => "",
							"nfe_clie_email"			    => "",
							"nfe_clie_ddd_fone"			    => "",
							"nfe_clie_fone"			        => "",
							"nfe_cnae_cod"			        => "",
							"nfe_endr_nome_cli"			    => "",
							"nfe_endr_numero_cli"			=> "",
							"nfe_endr_cep_cli"			    => "",
							"nfe_endr_bairro_cli"			=> "",
							"nfe_endr_complemento_cli"		=> "",
							"nfe_cida_cod_cli"			    => "",
							"nfe_cida_nome_cli"			    => "",
							"nfe_cida_ibge_cli"			    => "",
							"nfe_esta_cod_cli"			    => "",
							"nfe_esta_cod_bacen_cli"		=> "",
							"nfe_esta_nome_cli"			    => "",
							"nfe_pais_cod_bancen_cli"		=> "",
							"nfe_pais_nome_cli"			    => "",
							"nfe_endr_nome_cli_entrega"		=> "",
							"nfe_endr_cnpj_entrega"			=> "",
							"nfe_endr_numero_cli_entrega"	=> "",
							"nfe_endr_cep_cli_entrega"		=> "",
							"nfe_endr_bairro_cli_entrega"	=> "",
							"nfe_endr_complemento_cli_entrega"	=> "",
							"nfe_cida_cod_cli_entrega"			=> "",
							"nfe_cida_nome_cli_entrega"			=> "",
							"nfe_cida_ibge_cli_entrega"			=> "",
							"nfe_esta_cod_cli_entrega"			=> "",
							"nfe_esta_cod_bacen_cli_entrega"	=> "",
							"nfe_esta_nome_cli_entrega"			=> "",
							"nfe_pais_cod_bancen_cli_entrega"	=> "",
							"nfe_pais_nome_cli_entrega"			=> "",
							"nfe_endr_nome_cli_entrega"			=> "",
							"nfe_endr_nome_cli_retirada"		=> "",
							"nfe_endr_cnpj_retirada"			=> "",
							"nfe_endr_numero_cli_retirada"		=> "",
							"nfe_endr_cep_cli_retirada"			=> "",
							"nfe_endr_bairro_cli_retirada"		=> "",
							"nfe_endr_complemento_cli_retirada"	=> "",
							"nfe_cida_cod_cli_retirada"			=> "",
							"nfe_cida_nome_cli_retirada"		=> "",
							"nfe_cida_ibge_cli_retirada"		=> "",
							"nfe_esta_cod_cli_retirada"			=> "",
							"nfe_esta_cod_bacen_cli_retirada"	=> "",
							"nfe_esta_nome_cli_retirada"		=> "",
							"nfe_pais_cod_bancen_cli_retirada"	=> "",
							"nfe_pais_nome_cli_retirada"		=> "",
							"nfe_modalidade_frete"			    => "",
							"nfe_vl_frete"			            => "",
							"nfe_forma_rateio_frete"			=> "",
							"nfe_vl_seguro"			            => "",
							"nfe_placa_veiculo"			        => "",
							"nfe_ufe_veiculo"			        => "",
							"nfe_antt"			                => "",
							"nfe_transp_cod"			        => "",
							"nfe_pess_nome_transp"			    => "",
							"nfe_transp_cpf_cnpj"			    => "",
							"nfe_transp_apelido_fantasia"		=> "",
							"nfe_transp_ie"			            => "",
							"nfe_transp_email"			        => "",
							"nfe_endr_nome_transp"			    => "",
							"nfe_endr_numero_transp"			=> "",
							"nfe_endr_cep_transp"			    => "",
							"nfe_endr_bairro_transp"			=> "",
							"nfe_endr_complemento_transp"		=> "",
							"nfe_cida_cod_transp"			    => "",
							"nfe_cida_nome_transp"			    => "",
							"nfe_cida_ibge_transp"			    => "",
							"nfe_esta_cod_transp"			    => "",
							"nfe_esta_cod_bacen_transp"			=> "",
							"nfe_esta_nome_transp"			    => "",
							"nfe_pais_cod_bancen_transp"		=> "",
							"nfe_pais_nome_transp"			    => "",
							"nfe_vl_outras_despesas"			=> "",
							"nfe_vl_desconto"			        => "",
							"nfe_vl_mercadorias"		        => "",
							"nfe_vl_nota"			            => "",
							"nfe_imp_vl_base_icms"			    => "",
							"nfe_imp_vl_icms"			        => "",
							"nfe_imp_vl_isentas_icms"			=> "",
							"nfe_imp_vl_outras_icms"			=> "",
							"nfe_imp_vl_base_ipi"			    => "",
							"nfe_imp_vl_ipi"			        => "",
							"nfe_imp_vl_isentas_ipi"			=> "",
							"nfe_imp_vl_outras_ipi"			    => "",
							"nfe_imp_vl_base_pis"			    => "",
							"nfe_imp_vl_pis"			        => "",
							"nfe_imp_vl_base_cofins"			=> "",
							"nfe_imp_vl_cofins"			        => "",
							"nfe_imp_vl_base_ii"			    => "",
							"nfe_imp_vl_ii"			            => "",
							"nfe_imp_vl_base_irpj"			    => "",
							"nfe_imp_vl_irpj"			        => "",
							"nfe_statusMonitor"			        => "",
						)
					);
					$this->data['checked_yes'] = 'checked';
				}
                $sigla = substr($this->_controller_name,0,8) .' '. substr(strtoupper($this->_controller_name),-3);
                $this->data['estado'] = $this->dropdown_estado();
                $this->data['sav_edt'] = ($id? "Atualizar" : "Cadastrar");
                $this->data['head_save'] = ucfirst(str_replace("_", " ", $sigla));
                $this->data['head_link'] = $this->_controller_name;
                $this->load->library('parser');
                $this->parser->parse("crud/head_save", $this->data);
                $this->parser->parse($this->_controller_name.'/save',$this->data);
			}
			else
			{
				$this->form_validation->set_rules($this->model->rules());
				if($this->form_validation->run() === FALSE)
				{
					$this->_response = ERROR(123, validation_errors());
				}
				else
				{
					$id = $this->input->post("id_nfe");
					$data = array(
						"id_nfe"                                    => $this->input->post('id_nfe', TRUE),
						"id_serie"                                  => $this->input->post('id_serie', TRUE),
						"nfe_serie_cod"                             => $this->input->post('nfe_serie_cod', TRUE),
						"nfe_nr_nota"                               => $this->input->post('nfe_nr_nota', TRUE),
						"nfe_situacao"                              => $this->input->post('nfe_situacao', TRUE),
						"nat_ope_cod"                               => $this->input->post('nat_ope_cod', TRUE),
						"nfe_nat_ope_descricao"                     => ucwords($this->input->post('nfe_nat_ope_descricao', TRUE)),
						"nfe_nat_ope_tipo"                          => $this->input->post('nfe_nat_ope_tipo', TRUE),
						"nfe_data_nota"                             => $this->input->post('nfe_data_nota', TRUE),
						"nfe_finalidade"                            => $this->input->post('nfe_finalidade', TRUE),
						"nfe_cod_clas_fis_descricao"                => ucwords($this->input->post('nfe_cod_clas_fis_descricao', TRUE)),
						"nfe_consumidor_final"                      => $this->input->post('nfe_consumidor_final', TRUE),
						"nfe_consumidor_final_desc"                 => $this->input->post('nfe_consumidor_final_desc', TRUE),
						"nfe_observacao"                            => $this->input->post('nfe_observacao', TRUE),
						"nfe_observacao_fiscal"                     => $this->input->post('nfe_observacao_fiscal', TRUE),
						"nfe_reve_razao"                            => $this->input->post('nfe_reve_razao', TRUE),
						"nfe_reve_cnpj"                             => $this->input->post('nfe_reve_cnpj', TRUE),
						"nfe_reve_fantasia"                         => $this->input->post('nfe_reve_fantasia', TRUE),
						"nfe_reve_ie"                               => $this->input->post('nfe_reve_ie', TRUE),
						"nfe_reve_im"                               => $this->input->post('nfe_reve_im', TRUE),
						"nfe_reve_email"                            => $this->input->post('nfe_reve_email', TRUE),
						"nfe_reve_modelo_nfe"                       => $this->input->post('nfe_reve_modelo_nfe', TRUE),
						"nfe_reve_ddd_fone"                         => $this->input->post('nfe_reve_ddd_fone', TRUE),
						"nfe_reve_cnae_cod"                         => $this->input->post('nfe_reve_cnae_cod', TRUE),
						"nfe_reve_cod_clas_fis"                     => $this->input->post('nfe_reve_cod_clas_fis', TRUE),
						"nfe_reve_danfe_orientacao"                 => $this->input->post('nfe_reve_danfe_orientacao', TRUE),
						"nfe_endr_nome_rev"                         => $this->input->post('nfe_endr_nome_rev', TRUE),
						"nfe_endr_numero_rev"                       => $this->input->post('nfe_endr_numero_rev', TRUE),
						"nfe_endr_cep_rev"                          => $this->input->post('nfe_endr_cep_rev', TRUE),
						"nfe_endr_bairro_rev"                       => $this->input->post('nfe_endr_bairro_rev', TRUE),
						"nfe_endr_complemento_rev"                  => $this->input->post('nfe_endr_complemento_rev', TRUE),
						"nfe_cida_cod_rev"                          => $this->input->post('nfe_cida_cod_rev', TRUE),
						"nfe_cida_nome_rev"                         => $this->input->post('nfe_cida_nome_rev', TRUE),
						"nfe_cida_ibge_rev"                         => $this->input->post('nfe_cida_ibge_rev', TRUE),
						"nfe_esta_cod_rev"                          => $this->input->post('nfe_esta_cod_rev', TRUE),
						"nfe_esta_cod_bacen_rev"                    => $this->input->post('nfe_esta_cod_bacen_rev', TRUE),
						"nfe_esta_nome_rev"                         => $this->input->post('nfe_esta_nome_rev', TRUE),
						"nfe_pais_cod_bancen_rev"                   => $this->input->post('nfe_pais_cod_bancen_rev', TRUE),
						"nfe_pais_nome_rev"                         => $this->input->post('nfe_pais_nome_rev', TRUE),
						"clie_cod"                                  => $this->input->post('clie_cod', TRUE),
						"nfe_pess_nome"                             => ucwords($this->input->post('nfe_pess_nome', TRUE)),
						"nfe_clie_cpf_cnpj"                         => $this->input->post('nfe_clie_cpf_cnpj', TRUE),
						"nfe_clie_apelido_fantasia"                 => $this->input->post('nfe_clie_apelido_fantasia', TRUE),
						"nfe_clie_rg_ie"                            => $this->input->post('nfe_clie_rg_ie', TRUE),
						"nfe_clie_email"                            => $this->input->post('nfe_clie_email', TRUE),
						"nfe_clie_ddd_fone"                         => $this->input->post('nfe_clie_ddd_fone', TRUE),
						"nfe_clie_fone"                             => $this->input->post('nfe_clie_fone', TRUE),
						"nfe_cnae_cod"                              => $this->input->post('nfe_cnae_cod', TRUE),
						"nfe_endr_nome_cli"                         => $this->input->post('nfe_endr_nome_cli', TRUE),
						"nfe_endr_numero_cli"                       => $this->input->post('nfe_endr_numero_cli', TRUE),
						"nfe_endr_cep_cli"                          => $this->input->post('nfe_endr_cep_cli', TRUE),
						"nfe_endr_bairro_cli"                       => $this->input->post('nfe_endr_bairro_cli', TRUE),
						"nfe_endr_complemento_cli"                  => $this->input->post('nfe_endr_complemento_cli', TRUE),
						"nfe_cida_cod_cli"                          => $this->input->post('nfe_cida_cod_cli', TRUE),
						"nfe_cida_nome_cli"                         => $this->input->post('nfe_cida_nome_cli', TRUE),
						"nfe_cida_ibge_cli"                         => $this->input->post('nfe_cida_ibge_cli', TRUE),
						"nfe_esta_cod_cli"                          => $this->input->post('nfe_esta_cod_cli', TRUE),
						"nfe_esta_cod_bacen_cli"                    => $this->input->post('nfe_esta_cod_bacen_cli', TRUE),
						"nfe_esta_nome_cli"                         => $this->input->post('nfe_esta_nome_cli', TRUE),
						"nfe_pais_cod_bancen_cli"                   => $this->input->post('nfe_pais_cod_bancen_cli', TRUE),
						"nfe_pais_nome_cli"                         => $this->input->post('nfe_pais_nome_cli', TRUE),
						"nfe_endr_nome_cli_entrega"                 => $this->input->post('nfe_endr_nome_cli_entrega', TRUE),
						"nfe_endr_cnpj_entrega"                     => $this->input->post('nfe_endr_cnpj_entrega', TRUE),
						"nfe_endr_numero_cli_entrega"               => $this->input->post('nfe_endr_numero_cli_entrega', TRUE),
						"nfe_endr_cep_cli_entrega"                  => $this->input->post('nfe_endr_cep_cli_entrega', TRUE),
						"nfe_endr_bairro_cli_entrega"               => $this->input->post('nfe_endr_bairro_cli_entrega', TRUE),
						"nfe_endr_complemento_cli_entrega"          => $this->input->post('nfe_endr_complemento_cli_entrega', TRUE),
						"nfe_cida_cod_cli_entrega"                  => $this->input->post('nfe_cida_cod_cli_entrega', TRUE),
						"nfe_cida_nome_cli_entrega"                 => $this->input->post('nfe_cida_nome_cli_entrega', TRUE),
						"nfe_cida_ibge_cli_entrega"                 => $this->input->post('nfe_cida_ibge_cli_entrega', TRUE),
						"nfe_esta_cod_cli_entrega"                  => $this->input->post('nfe_esta_cod_cli_entrega', TRUE),
						"nfe_esta_cod_bacen_cli_entrega"            => $this->input->post('nfe_esta_cod_bacen_cli_entrega', TRUE),
						"nfe_esta_nome_cli_entrega"                 => $this->input->post('nfe_esta_nome_cli_entrega', TRUE),
						"nfe_pais_cod_bancen_cli_entrega"           => $this->input->post('nfe_pais_cod_bancen_cli_entrega', TRUE),
						"nfe_pais_nome_cli_entrega"                 => $this->input->post('nfe_pais_nome_cli_entrega', TRUE),
						"nfe_endr_nome_cli_entrega"                 => $this->input->post('nfe_endr_nome_cli_entrega', TRUE),
						"nfe_endr_nome_cli_retirada"                => $this->input->post('nfe_endr_nome_cli_retirada', TRUE),
						"nfe_endr_cnpj_retirada"                    => $this->input->post('nfe_endr_cnpj_retirada', TRUE),
						"nfe_endr_numero_cli_retirada"              => $this->input->post('nfe_endr_numero_cli_retirada', TRUE),
						"nfe_endr_cep_cli_retirada"                 => $this->input->post('nfe_endr_cep_cli_retirada', TRUE),
						"nfe_endr_bairro_cli_retirada"              => $this->input->post('nfe_endr_bairro_cli_retirada', TRUE),
						"nfe_endr_complemento_cli_retirada"         => $this->input->post('nfe_endr_complemento_cli_retirada', TRUE),
						"nfe_cida_cod_cli_retirada"                 => $this->input->post('nfe_cida_cod_cli_retirada', TRUE),
						"nfe_cida_nome_cli_retirada"                => $this->input->post('nfe_cida_nome_cli_retirada', TRUE),
						"nfe_cida_ibge_cli_retirada"                => $this->input->post('nfe_cida_ibge_cli_retirada', TRUE),
						"nfe_esta_cod_cli_retirada"                 => $this->input->post('nfe_esta_cod_cli_retirada', TRUE),
						"nfe_esta_cod_bacen_cli_retirada"           => $this->input->post('nfe_esta_cod_bacen_cli_retirada', TRUE),
						"nfe_esta_nome_cli_retirada"                => $this->input->post('nfe_esta_nome_cli_retirada', TRUE),
						"nfe_pais_cod_bancen_cli_retirada"          => $this->input->post('nfe_pais_cod_bancen_cli_retirada', TRUE),
						"nfe_pais_nome_cli_retirada"                => $this->input->post('nfe_pais_nome_cli_retirada', TRUE),
						"nfe_modalidade_frete"                      => $this->input->post('nfe_modalidade_frete', TRUE),
						"nfe_vl_frete"                              => $this->input->post('nfe_vl_frete', TRUE),
						"nfe_forma_rateio_frete"                    => $this->input->post('nfe_forma_rateio_frete', TRUE),
						"nfe_vl_seguro"                             => $this->input->post('nfe_vl_seguro', TRUE),
						"nfe_placa_veiculo"                         => $this->input->post('nfe_placa_veiculo', TRUE),
						"nfe_ufe_veiculo"                           => $this->input->post('nfe_ufe_veiculo', TRUE),
						"nfe_antt"                                  => $this->input->post('nfe_antt', TRUE),
						"nfe_transp_cod"                            => $this->input->post('nfe_transp_cod', TRUE),
						"nfe_pess_nome_transp"                      => $this->input->post('nfe_pess_nome_transp', TRUE),
						"nfe_transp_cpf_cnpj"                       => $this->input->post('nfe_transp_cpf_cnpj', TRUE),
						"nfe_transp_apelido_fantasia"               => $this->input->post('nfe_transp_apelido_fantasia', TRUE),
						"nfe_transp_ie"                             => $this->input->post('nfe_transp_ie', TRUE),
						"nfe_transp_email"                          => $this->input->post('nfe_transp_email', TRUE),
						"nfe_endr_nome_transp"                      => $this->input->post('nfe_endr_nome_transp', TRUE),
						"nfe_endr_numero_transp"                    => $this->input->post('nfe_endr_numero_transp', TRUE),
						"nfe_endr_cep_transp"                       => $this->input->post('nfe_endr_cep_transp', TRUE),
						"nfe_endr_bairro_transp"                    => $this->input->post('nfe_endr_bairro_transp', TRUE),
						"nfe_endr_complemento_transp"               => $this->input->post('nfe_endr_complemento_transp', TRUE),
						"nfe_cida_cod_transp"                       => $this->input->post('nfe_cida_cod_transp', TRUE),
						"nfe_cida_nome_transp"                      => $this->input->post('nfe_cida_nome_transp', TRUE),
						"nfe_cida_ibge_transp"                      => $this->input->post('nfe_cida_ibge_transp', TRUE),
						"nfe_esta_cod_transp"                       => $this->input->post('nfe_esta_cod_transp', TRUE),
						"nfe_esta_cod_bacen_transp"                 => $this->input->post('nfe_esta_cod_bacen_transp', TRUE),
						"nfe_esta_nome_transp"                      => $this->input->post('nfe_esta_nome_transp', TRUE),
						"nfe_pais_cod_bancen_transp"                => $this->input->post('nfe_pais_cod_bancen_transp', TRUE),
						"nfe_pais_nome_transp"                      => $this->input->post('nfe_pais_nome_transp', TRUE),
						"nfe_vl_outras_despesas"                    => $this->input->post('nfe_vl_outras_despesas', TRUE),
						"nfe_vl_desconto"                           => $this->input->post('nfe_vl_desconto', TRUE),
						"nfe_vl_mercadorias"                         => $this->input->post('nfe_vl_mercadorias', TRUE),
						"nfe_vl_nota"                               => $this->input->post('nfe_vl_nota', TRUE),
						"nfe_imp_vl_base_icms"                      => $this->input->post('nfe_imp_vl_base_icms', TRUE),
						"nfe_imp_vl_icms"                           => $this->input->post('nfe_imp_vl_icms', TRUE),
						"nfe_imp_vl_isento_icms"                    => $this->input->post('nfe_imp_vl_isento_icms', TRUE),
						"nfe_imp_vl_outras_icms"                    => $this->input->post('nfe_imp_vl_outras_icms', TRUE),
						"nfe_imp_vl_base_ipi"                       => $this->input->post('nfe_imp_vl_base_ipi', TRUE),
						"nfe_imp_vl_ipi"                            => $this->input->post('nfe_imp_vl_ipi', TRUE),
						"nfe_imp_vl_isentas_ipi"                    => $this->input->post('nfe_imp_vl_isentas_ipi', TRUE),
						"nfe_imp_vl_outras_ipi"                     => $this->input->post('nfe_imp_vl_outras_ipi', TRUE),
						"nfe_imp_vl_base_pis"                       => $this->input->post('nfe_imp_vl_base_pis', TRUE),
						"nfe_imp_vl_pis"                            => $this->input->post('nfe_imp_vl_pis', TRUE),
						"nfe_imp_vl_base_cofins"                    => $this->input->post('nfe_imp_vl_base_cofins', TRUE),
						"nfe_imp_vl_cofins"                         => $this->input->post('nfe_imp_vl_cofins', TRUE),
						"nfe_imp_vl_base_ii"                        => $this->input->post('nfe_imp_vl_base_ii', TRUE),
						"nfe_imp_vl_ii"                             => $this->input->post('nfe_imp_vl_ii', TRUE),
						"nfe_imp_vl_base_irpj"                      => $this->input->post('nfe_imp_vl_base_irpj', TRUE),
						"nfe_imp_vl_irpj"                           => $this->input->post('nfe_imp_vl_irpj', TRUE),
						"nfe_statusMonitor"                         => $this->input->post('nfe_statusMonitor', TRUE),
					);
					$this->model->save($data, $id);
					$this->data['success'] = "Registro " . ($id? "Atualizado" : "Inserido") . "com sucesso!";
					$this->index();
				}
			}
		}
        public function dropdown_empresa($selected='')
        {
            $empresa = array();
            foreach($this->model->get_empresa() as $e)
            {
                $empresa[$e->id] = $e->nfe_reve_fantasia;
            }
            return form_dropdown('nfe_empresa',$empresa,$selected,' class="form-control"');
        }
        public function dropdown_configuracal_fiscal($selected='')
        {
            $conf_fisc = array();
            foreach($this->model->get_configuracao_fiscal() as $cf)
            {
                $conf_fisc[$cf->conf_fisc_id] = $cf->conf_fisc_descricao;
            }
            return form_dropdown('conf_fisc_id',$conf_fisc,$selected,' class="form-control"');
        }
        public function dropdown_finalidade($selected='')
        {
            $finalidaade = array();
            foreach($this->model->get_finalidade() as $f)
            {
                $finalidaade[$f->id] = $f->cod_clas_fis_descricao;
            }
            return form_dropdown('nfe_finalidade',$finalidaade,$selected, ' class="form-control"');
        }
        public function dropdown_estado($selected='')
        {
            $estado = array();
            foreach($this->model->get_estado() as $es)
            {
                $estado[$es->esta_cod] = $es->esta_nome;
            }
            return form_dropdown('estado', $estado, $selected,' class="form-control"');
        }
	}