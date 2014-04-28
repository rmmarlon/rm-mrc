<?php

Class ClassGenerator extends MY_Controller
{
	public function index()
	{
		$this->generate_class(["controller_name" => "servicos"]);
		
);
	}
	
	public function generate_class($options)
	{
		$this->load->library('parser');
		$this->parser->parse('controller_template.php',$options);
	}
}
