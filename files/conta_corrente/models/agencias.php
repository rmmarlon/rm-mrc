<? if(! defined('BASEPATH')) die();
	class Agencias extends MY_Controller{

		protected $_like_column = "agen_nome";
		protected $_controller_name = "agencias";

		public function __construct()
		{
			parent::__construct();
			$this->model = $this->load->model('agencias_model');
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
					$agencia = $this->model->get($id);
					$this->data['item'] = array($agencia);
					if($this->data['item'][0]->agen_status == 't')
						$this->data['checked_yes'] = 'checked';
					else
						$this->data['checked_no'] = 'checked';
				}
				else
				{
					$this->data['item'] = array(
						array(
							"agen_cod"						=> "",
							"agen_nome"						=> "",
							"agen_status"						=> "t",
							"banc_cod"						=> "",
							"reve_cod"						=> "",
							"agencia_codigo"						=> "",
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
					$id = $this->input->post("agen_cod");
					$data = array(
						"agen_cod" => $this->input->post('agen_cod', TRUE),
						"agen_nome" => ucwords($this->input->post('agen_nome', TRUE)),
						"agen_status" => $this->input->post('agen_status', TRUE),
						"banc_cod" => $this->input->post('banc_cod', TRUE),
						"reve_cod" => $this->input->post('reve_cod', TRUE),
						"agencia_codigo" => $this->input->post('agencia_codigo', TRUE),
					);
					$this->model->save($data, $id);
					$this->data['success'] = "Registro " . ($id? "Atualizado" : "Inserido") . "com sucesso!";
					$this->index();
				}
			}
		}
	}
?>