<? if(!defined('BASEPATH')) die();

	class conta_corrente_model extends MY_Model {

		protected $_table_name = "contas";
		protected $_primary_key = "cont_cod";
		protected $_primary_filter = "intval";
		protected $_order_by = "contas.cont_cod";
		protected $_rules =  array(/*
					array("field" => "cont_cod",						"label" => "cont_cod",				"rules" =>"trim|integer", ),
					array("field" => "cont_nome",						"label" => "cont_nome",				"rules" =>"trim|required", ),
					array("field" => "cont_apelido",					"label" => "cont_apelido",			"rules" =>"trim|required", ),
					array("field" => "cont_gerente",					"label" => "cont_gerente",			"rules" =>"trim|required", ),
					array("field" => "cont_padrao",						"label" => "cont_padrao",			"rules" =>"trim|required", ),
					array("field" => "cont_status",						"label" => "cont_status",			"rules" =>"trim|required", ),
					array("field" => "agen_cod",						"label" => "agen_cod",				"rules" =>"trim|integer", ),
					array("field" => "reve_cod",						"label" => "reve_cod",				"rules" =>"trim|integer", ),
					array("field" => "conta_codigo",					"label" => "conta_codigo",			"rules" =>"trim|required", ),
                    */
		);

		public function __construct()
		{
			parent::__construct();
		}

        public function get($id=NULL,$single=FALSE)
        {
            $this->db->select('a.*,b.*,contas.*')
            ->join('agencias as a','contas.agen_cod = a.agen_cod','left')
            ->join('bancos as b','a.banc_cod = b.banc_cod','left')
            ->where('contas.reve_cod', $this->session->userdata('ss_empresa_conectada'));
            return parent::get($id,$single);
        }
        public function count_pages()
        {
            $this->db->select('a.*,b.*,contas.*')
            ->join('agencias as a','contas.agen_cod = a.agen_cod','left')
            ->join('bancos as b','a.banc_cod = b.banc_cod','left')
            ->where('contas.reve_cod', $this->session->userdata('ss_empresa_conectada'));
            return ceil($this->db->count_all_results($this->_table_name)/$this->_limit);
        }
        public function get_like($like,$p=1)
        {
            $p--;
            $this->db->select('a.*,b.*,contas.*')
            ->join('agencias as a','contas.agen_cod = a.agen_cod','left')
            ->join('bancos as b','a.banc_cod = b.banc_cod','left')
            ->where('contas.reve_cod', $this->session->userdata('ss_empresa_conectada'))
            ->limit($this->_limit,$p*$this->_limit)
            ->ilike($like);
            return parent::get();
        }
        public function count_all($like=NULL)
        {
            $this->db->where('reve_cod',$this->session->userdata('ss_empresa_conectada'));
            return parent::count_all($like);
        }
        public function get_banco()
        {
            $where = array('banco_codigo !='=>'NULL','banc_status'=>'t');
            $query = $this->db->select("banc_cod, banco_codigo ||' - '|| banc_nome as descricao")
                ->from('bancos')
                ->where($where)
                ->order_by('banco_codigo');
            return $query->get()->result();
        }
        public function get_agencia($like)
        {
            $where = array(
                'banc_cod'=>$like,
                'agen_status'=>'t',
                'reve_cod'=>$this->session->userdata('ss_empresa_conectada')
            );
            $query = $this->db->select("agen_cod, agencia_codigo || ' - ' || agen_nome as descricao")
                ->from('agencias')
                ->where($where)
                ->get();
            return $query->result();
        }
        public function save($data,$id=NULL)
        {
            $this->load->model('agencias_model');
            if($this->input->post('agenc_opcoes') == 'N')
            {
                $agen_cod =
                    array(
                        "agen_nome"         => $data['agen_nome'],
                        "agen_status"       => "t",
                        "banc_cod"          => $data['banc_cod'],
                        "reve_cod"          => $this->session->userdata('ss_empresa_conectada'),
                        "agencia_codigo"    => $data['agencia_codigo'],

                );
                $data['agen_cod'] = $agen_cod;
                var_dump($this->session->userdata('ss_empresa_conectada'));exit;
                //$id = parent::save($data,$id);
            }
            else
            {
                //return parent::save($data,$id);
            }

            if($this->input->post('tipo_movimento') == 'R')
            {

            }
            else
            {

            }
        }
        /*
         * agencias novas
         * INSERT INTO agencias(agen_nome, agen_status, banc_cod, reve_cod, agencia_codigo)
         *              VALUES ('$agencia_nome', 't', '$banc_cod', $empresa, '$agencia_codigo')
         *
         *
         *
         * saldo positivo negativo
         * if($tipo_movimento=='R'){ //saldo positivo
			$sql = "INSERT INTO movimentacao_contas(dtemissao,
                                                    dtvencimento,
                                                    dtreferencia,
                                                    descricao,
                                                    conciliado,
                                                    cate_cod,
                                                    subc_cod,
                                                    reve_cod,
                                                    id_baixa_agrupada,
                                                    valor_multa,
                                                    valor_juros,
                                                    valor_desconto,
                                                    valor_titulo,
                                                    valor_pago,
                                                    dre,
                                                    tipo_movimento,
                                                    clie_cod,
                                                    nro_documento,
                                                    dtbaixa,
                                                    conta_cod,
                                                    tipo_pagamento_id)
                                            VALUES ('$dtemissao',
                                                    '$dtvencimento',
                                                    '$dtreferencia',
                                                    '$descricao',
                                                    't',
                                                    54,
                                                    0,
                                                    $empresa,
                                                    0, '0', '0', '0',
                                                    '$saldo_inicial',
                                                    '$saldo_inicial',
                                                    'f',
                                                    '$tipo_movimento',
                                                    0,
                                                    '',
                                                    '$dtbaixa',
                                                    $cont_cod, 6)";
		}else{ //saldo negativo
			$sql = "INSERT INTO movimentacao_contas(dtemissao,
                                                     dtvencimento,
                                                    dtreferencia,
                                                    descricao,
                                                    conciliado,
                                                    cate_cod,
                                                    subc_cod,
                                                    reve_cod,
                                                    id_baixa_agrupada,
                                                    valor_multa,
                                                    valor_juros,
                                                    valor_desconto,
                                                    valor_titulo,
                                                    valor_pago,
                                                    dre,
                                                    tipo_movimento,
                                                    clie_cod,
                                                    nro_documento,
                                                    dtbaixa,
                                                    conta_cod,
                                                    tipo_pagamento_id)
        VALUES ('$dtemissao', '$dtvencimento', '$dtreferencia', '$descricao', 't', 53, 0, $empresa, 0, '0', '0', '0', '$saldo_inicial', '$saldo_inicial', 'f', '$tipo_movimento', 0, '', '$dtbaixa', $cont_cod, 6)";
		}
         * */
	 }