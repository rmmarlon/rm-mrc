<? if(!defined('BASEPATH')) die();

	class agencias_model extends MY_Model {

		protected $_table_name = "agencias";
		protected $_primary_key = "agen_cod";
		protected $_primary_filter = "intval";
		protected $_order_by = "agen_cod";
		protected $_rules =  array();

		public function __construct()
		{
			parent::__construct();
		}
	 } 
?>