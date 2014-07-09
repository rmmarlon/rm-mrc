<? if(! defined('BASEPATH')) die();
	class Servicos extends MY_Controller{

		protected $_like_column = "{like_column}";
		protected $_controller_name = "{controller_name}";
		public function __construct()
		{
			parent::__construct();
			$this->model = $this->load->model('servicos_model');
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
					$servico = $this->model->get($id);
					$this->data['item'] = array($servico);
					if($this->data['item'][0]->serv_status == 't')
						$this->data['checked_yes'] = 'checked';
					else
						$this->data['checked_no'] = 'checked';
				}
				else
				{
					$this->data['item'] = array(
						array(
							"serv_cod"			=> "",
							"serv_nome"			=> "",
							"serv_status"		=> "t",
						)
					);
					$this->data['checked_yes'] = 'checked';
				}
				$this->data['head_save'] = $this->_controller_name;
				$this->load->library('parser');
				$this->parser->parse('crud/head_save', $this->data);
				$this->parser->parse($this->_controller_name.'/save', $this->data);
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
					$id = $this->input->post("serv_cod");
					$data = array(
						"serv_nome" => strtoupper($this->input->post('serv_nome', TRUE)),
						"serv_status" => $this->input->post('serv_status', TRUE),
					);
					$this->model->save($data, $id);
					$this->data['success'] = "Registro " . ($id? "Atualizado" : "Inserido") . "com sucesso!";
					$this->index();
				}
			}
		}
	}
?>