<?php
    /**
     * Created by PhpStorm.
     * User: Atendimento
     * Date: 22/05/14
     * Time: 15:38
     */

    class Configuracao_fiscal_revendas extends MY_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = $this->load->model('configuracao_fiscal_revendas_model');
        }

        public function index()
        {
            $this->data['sav_edt'] = "Cadastrar";
            $this->data['head_save'] = "Configuração da Revendas";
            $this->data['head_link'] = "configuracao_fiscal_revendas";
            $this->data['revendas'] = $this->dropdown_revendas();
            $this->load->library('parser');
            $this->parser->parse('crud/head_save', $this->data);
            $this->parser->parse('configuracao_fiscal_revendas/save', $this->data);
        }
        public function dropdown_revendas($selected='')
        {
            $revendas = array();
            foreach($this->model->get() as $r)
            {
                $revendas[$r->reve_cod] = $r->reve_cod;
            }
            return form_dropdown('revendas',$revendas,$selected,' class="form-control input-medium');
        }
    }