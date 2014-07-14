<?php
    /**
     * Created by PhpStorm.
     * User: Atendimento
     * Date: 06/06/14
     * Time: 13:20
     */

    class movimentacao_conta extends MY_Model
    {
        protected $_table_name = '';
        protected $_primary_key = '';
        protected $_primary_filter = '';
        protected $_order_by = '';
        protected $_rules = array();

        public function __construct()
        {
            parent::__construct();
        }
    }