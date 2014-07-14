<? if(! defined('BASEPATH')) die();
	class Conta_corrente extends MY_Controller{

		protected $_like_column = "cont_nome";
		protected $_controller_name = "conta_corrente";

		public function __construct()
		{
			parent::__construct();
			$this->model = $this->load->model('conta_corrente_model');
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
					$conta = $this->model->get($id);
                    $conta->agen_cod = $this->dropdown_agencia($conta->banc_cod,$conta->agen_cod);
                    $conta->banc_cod = $this->dropdown_bancos($conta->banc_cod);
					$this->data['item'] = array($conta);
					if($this->data['item'][0]->cont_status == 't')
						$this->data['checked_yes'] = 'checked';
					else
						$this->data['checked_no'] = 'checked';
				}
				else
				{
					$this->data['item'] = array(
						array(
							"cont_cod"						=> "",
							"cont_nome"						=> "",
							"cont_apelido"					=> "",
							"cont_gerente"					=> "",
							"cont_padrao"					=> "",
							"cont_status"					=> "t",
							"reve_cod"						=> $this->session->userdata('ss_empresa_conectada'),
							"conta_codigo"					=> "",
                            "agen_cod"                      => $this->dropdown_agencia(0,0),
                            "agen_nome"                     => "",
                            "agen_status"                   => "",
                            "banc_cod"						=> $this->dropdown_bancos(),
                            "agencia_codigo"                => "",
                            "banc_nome"                     => "",
                            "banc_url"                      => "",
                            "banc_status"                   => "",
                            "banco_codigo"                  => "",

						)
					);
					$this->data['checked_no'] = 'checked';
				}
                $this->data['sav_edt'] = ($id? "Atualizar" : "Cadastrar");
                $this->data['head_save'] = ucwords(str_replace("_", " ", $this->_controller_name));
                $this->data['head_link'] = $this->_controller_name;
                $this->load->library('parser');
                $this->parser->parse("crud/head_save", $this->data);
				$this->parser->parse($this->_controller_name.'/save', $this->data);
			}
			else
			{
				/*$this->form_validation->set_rules($this->model->rules());
				if($this->form_validation->run() === FALSE)
				{
					$this->_response = ERROR(123, validation_errors());
				}
				else
				{*/
					$id = $this->input->post("cont_cod");
					$data = array(
						"cont_cod"      => $this->input->post('cont_cod', TRUE),
						"cont_nome"     => ucwords($this->input->post('cont_nome', TRUE)),
						"cont_apelido"  => $this->input->post('cont_apelido', TRUE),
						//"cont_gerente"  => $this->input->post('cont_gerente', TRUE),
						"cont_padrao"   => "t",
						"cont_status"   => $this->input->post('cont_status', TRUE),
						"agen_cod"      => $this->input->post('agen_cod', TRUE),
						"reve_cod"      => $this->input->post('reve_cod', TRUE),
						"conta_codigo"  => $this->input->post('conta_codigo', TRUE),
					);
					$this->model->save($data, $id);
					//$this->data['success'] = "Registro " . ($id? "Atualizado" : "Inserido") . "com sucesso!";
					//$this->index();
				//}
			}
		}
        public function dropdown_bancos($selected = '')
        {
            $banco = array();
            foreach($this->model->get_banco() as $b)
            {
                $banco[$b->banc_cod] = $b->descricao;
            }
            return form_dropdown('banc_cod', $banco, $selected, ' id="banc_nome" class="form-control select2me"');
        }
        public function dropdown_agencia($like,$selected='')
        {
            $agencia = array();
            foreach($this->model->get_agencia($like) as $a)
            {
                $agencia[$a->agen_cod] = $a->descricao;
            }
            return form_dropdown('agen_cod',$agencia,$selected,' id="agen_cod" class="form-control select2me"');
        }
        public function dropdownAgencia()
        {
            $like = $this->input->post('like');
            $this->data['output'] = $this->dropdown_agencia($like);
            $this->load->library('parser');
            $this->parser->parse('crud/output',$this->data);
        }
	}