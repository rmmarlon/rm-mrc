<?php

$saldo_inicial = $_POST['saldo_inicial'];
    if(strpos($saldo_inicial,".") || strpos($saldo_inicial,",")){
        $saldo_inicial = str_replace([",","."],"", $saldo_inicial);

        $saldo_inicial = intval($saldo_inicial) / 100;
    }
    else
    {
        $saldo_inicial = intval($saldo_inicial);
    }
echo $saldo_inicial."-----";
exit;
	$name = $_POST['name'];
	$valor = $_POST['field'];
	$campo = array('primary_key','primary_filter');
    $dir = mkdir($name);
    $mod = mkdir($name."/models");
    $control = mkdir($name."/controllers");
    $lists = mkdir($name.'/'.$name);

/*=========================================Create file Model====================================================================*/

	$model = "<? if(!defined('BASEPATH')) die();\n";
		$model .= "\n";
		$model .= "\t" . 'class ' . $name . '_model extends MY_Model {' . "\n";
			$model .= "\n";
			$model .= "\t\t".'protected $_table_name = "' . $name . '";' . "\n";
			for($i=0;$i<1;$i++){
				$model .= "\t\t".'protected $_'.$campo[$i].' = "' . $valor[$i] . '";' . "\n";
			}
			$model .= "\t\t".'protected $_primary_filter = "intval";' . "\n";
			$model .= "\t\t".'protected $_order_by = "' . $valor[0] . '";' . "\n";
			$model .= "\t\t" . 'protected $_rules =  array(' . "\n";
					foreach ($valor as $val) {
						if(strlen($val) > 9){
							if($val == substr($val,0, -4)."_cod"){
								$model .= "\t\t\t\t\t".'array("field" => "' . $val . '",'."\t\t\t\t\t\t".'"label" => "' . $val . '",' ."\t\t\t". '"rules" =>"trim|integer", ),' . "\n";
							} else{
								if(! $val->EOF){
									$model .= "\t\t\t\t\t".'array("field" => "' . $val . '",'."\t\t\t\t\t\t".'"label" => "' . $val . '",' ."\t\t\t". '"rules" =>"trim|required", ),' . "\n";
								} else{
									$model .= "\t\t\t\t\t".'array("field" => "' . $val . '",'."\t\t\t\t\t\t".'"label" => "' . $val . '",' ."\t\t\t". '"rules" =>"trim|required" )' . "\n";
								}
							}
						} else{
							if($val == substr($val,0, -4)."_cod"){
								$model .= "\t\t\t\t\t".'array("field" => "' . $val . '",'."\t\t\t\t\t\t\t\t\t".'"label" => "' . $val . '",' ."\t\t\t\t". '"rules" =>"trim|integer", ),' . "\n";
							} else{
								$model .= "\t\t\t\t\t".'array("field" => "' . $val . '",'."\t\t\t\t\t\t\t\t\t".'"label" => "' . $val . '",' ."\t\t\t\t". '"rules" =>"trim|required", ),' . "\n";
							}
						}
					}
			$model .= "\t\t".');'."\n";
			$model .= "\n";
			$model .= "\t\t" . 'public function __construct()' . "\n";
			$model .= "\t\t".'{'."\n";
				$model .= "\t\t\t" . 'parent::__construct();' . "\n";
			$model .= "\t\t".'}'."\n";
		$model .= "\t } \n";
	$model .= "?>";

	if(file_put_contents($name."/models/".$name."_model.php", $model)){
			echo "Arquivo Criado".$name."_model<br>";
		}else{
		echo "erro";
	}
/*=======================================================end Create file Model====================================================*/

/*=======================================================Create file Controller====================================================*/

	$controller = "<? if(! defined('BASEPATH')) die();\n";
		$model .= "\n";
		$controller .= "\t" . 'class ' . ucfirst($name) . ' extends MY_Controller{' . "\n";
			$controller .= "\n";
			$controller .= "\t\t" . 'protected $_like_column = "' . $valor[1] . '";' . "\n";
			$controller .= "\t\t" . 'protected $_controller_name = "' . $name . '";' . "\n";
			$controller .= "\n";
			$controller .= "\t\t" . 'public function __construct()' . "\n";
			$controller .= "\t\t" . '{' . "\n";
				$controller .= "\t\t\t" . 'parent::__construct();' . "\n";
				$controller .= "\t\t\t" . '$this->model = $this->load->model(\'' . $name . '_model\');' . "\n";
			$controller .= "\t\t" . '}' . "\n";
			$controller .= "\n";
			$controller .= "\t\t" . 'public function save()' . "\n";
			$controller .= "\t\t" . '{' . "\n";
				$controller .= "\t\t\t" . 'if($find = $this->input->post(\'find\'))' . "\n";
				$controller .= "\t\t\t" . '{' . "\n";
					$controller .= "\t\t\t\t" . '$this->data[\'find\'] = $find;' . "\n";
				$controller .= "\t\t\t" . '}' . "\n";
				$controller .= "\t\t\t" . 'if(!$this->input->post(\'save\'))' . "\n";
				$controller .= "\t\t\t" . '{' . "\n";
					$controller .= "\t\t\t\t" . '//Get form' . "\n";
					$controller .= "\t\t\t\t" . '$id = $this->input->post(\'id\');' . "\n";
					$controller .= "\t\t\t\t" . 'if($id)' . "\n";
					$controller .= "\t\t\t\t" . '{' . "\n";
						$controller .= "\t\t\t\t\t" . '$' . substr($name, 0, -1) . ' = $this->model->get($id);' . "\n";
						$controller .= "\t\t\t\t\t" . '$this->data[\'item\'] = array($'.substr($name, 0, -1).');' . "\n";
						$controller .= "\t\t\t\t\t" . 'if($this->data[\'item\'][0]->' . substr($valor[0],0, -4) . '_status == \'t\')' . "\n";
							$controller .= "\t\t\t\t\t\t" . '$this->data[\'checked_yes\'] = \'checked\';' . "\n";
							$controller .= "\t\t\t\t\t" . 'else' . "\n";
							$controller .= "\t\t\t\t\t\t" . '$this->data[\'checked_no\'] = \'checked\';' . "\n";
					$controller .= "\t\t\t\t" . '}' . "\n";
					$controller .= "\t\t\t\t" . 'else' . "\n";
					$controller .= "\t\t\t\t" . '{' . "\n";
						$controller .= "\t\t\t\t\t" . '$this->data[\'item\'] = array(' . "\n";
								$controller .= "\t\t\t\t\t\t" . 'array(' . "\n";							
								foreach($valor as $val){
									if($val == substr($val, 0, -7)."_status"){
										$controller .= "\t\t\t\t\t\t\t" . '"' . $val . '"' . "\t\t\t\t\t\t" . '=> "t",' . "\n";
									} else{
										$controller .= "\t\t\t\t\t\t\t" . '"' . $val . '"' . "\t\t\t\t\t\t" . '=> "",' . "\n";
									}
								}
								$controller .= "\t\t\t\t\t\t" . ')' . "\n";
						$controller .= "\t\t\t\t\t" . ');' . "\n";
						$controller .= "\t\t\t\t\t" . '$this->data[\'checked_yes\'] = \'checked\';' . "\n";
					$controller .= "\t\t\t\t" . '}' . "\n";
					$controller .= "\t\t\t\t" . '$this->data[\'head_save\'] = $this->_controller_name;' . "\n";
					$controller .= "\t\t\t\t" . '$this->load->library(\'parser\');' . "\n";
					$controller .= "\t\t\t\t" . '$this->parser->parse(\'crud/head_save\', $this->data);' . "\n";
					$controller .= "\t\t\t\t" . '$this->parser->parse($this->_controller_name.\'/save\', $this->data);' . "\n";
				$controller .= "\t\t\t" . '}' . "\n";
				$controller .= "\t\t\t" . 'else' . "\n";
				$controller .= "\t\t\t" . '{' . "\n";
					$controller .= "\t\t\t\t" . '$this->form_validation->set_rules($this->model->rules());' . "\n";
					$controller .= "\t\t\t\t" . 'if($this->form_validation->run() === FALSE)' . "\n";
					$controller .= "\t\t\t\t" . '{' . "\n";
						$controller .= "\t\t\t\t\t" . '$this->_response = ERROR(123, validation_errors());' . "\n";
					$controller .= "\t\t\t\t" . '}' . "\n";
					$controller .= "\t\t\t\t" . 'else' . "\n";
					$controller .= "\t\t\t\t" . '{' . "\n";
						$controller .= "\t\t\t\t\t" . '$id = $this->input->post("'. $valor[0].'");' . "\n";
						$controller .= "\t\t\t\t\t" . '$data = array(' . "\n";
							foreach($valor as $val){

								if($val == substr($val, 0, -5)."_nome" || $val == substr($val, 0, -10)."_descricao"){
									$controller .= "\t\t\t\t\t\t" . '"'.$val.'" => ucwords($this->input->post(\''.$val.'\', TRUE)),' . "\n";
								} else{
									$controller .= "\t\t\t\t\t\t" . '"'.$val.'" => $this->input->post(\''.$val.'\', TRUE),' . "\n";
								}
							}
						$controller .= "\t\t\t\t\t" . ');' . "\n";
						$controller .= "\t\t\t\t\t" . '$this->model->save($data, $id);' . "\n";
						$controller .= "\t\t\t\t\t" . '$this->data[\'success\'] = "Registro " . ($id? "Atualizado" : "Inserido") . "com sucesso!";' . "\n";
						$controller .= "\t\t\t\t\t" . '$this->index();' . "\n";
					$controller .= "\t\t\t\t" . '}' . "\n";
				$controller .= "\t\t\t" . '}' . "\n";
			$controller .= "\t\t" . '}' . "\n";
		$controller .= "\t" . '}' . "\n"; 
	$controller .= "?>";

	if(file_put_contents($name."/controllers/".$name.".php", $controller)){
		echo "Arquivo Criado {$name}\n";
	} else{
		echo "erro";
	}
/*=======================================================end Create file Controller====================================================*/

/*=========================================================create file html list============================================*/
/*HTML*/
$html = "<!--BEGIN EXAMPLE TABLE PORTLET-->" . "\n";
$html .= "<div class='box light-grey'>" . "\n";
    $html .= "\t" . "<div class='portlet-body'>" . "\n";
        $html .= "\t\t" . "<table class='table table-striped table-bordered table-hover' id='simple_2'>" . "\n";
            $html .= "\t\t\t" . "<thead>" . "\n";
                $html .= "\t\t\t\t" . "<tr>" . "\n";
                    $html .= "\t\t\t\t\t" .'<th width="4%" class="table-checkbox">'."\n";
                        $html .= "\t\t\t\t\t\t" .'<input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />'."\n";
                    $html .= "\t\t\t\t\t" .'</th>'."\n";
                foreach($valor as $l)
                {
                    $html .= "\t\t\t\t\t" . "<th width='5%'>" . "\n";
                    $html .= "\t\t\t\t\t\t" . "{$l}" . "\n";
                    $html .= "\t\t\t\t\t" . "</th>" . "\n";
                }
                    $html .= "\t\t\t\t" . "<td width='3%'>" . "\n";
                        $html .= "\t\t\t\t\t\t" . "Ações" . "\n";
                    $html .= "\t\t\t\t\t" . "</td>" . "\n";
                $html .= "\t\t\t\t" . "</tr>" . "\n";
            $html .= "\t\t\t" . "</thead>" . "\n";

            $html .= "\t\t\t" . "<tbody>" . "\n";
                $html .= "\t\t\t\t" . "{itens}" . "\n";
                    $html .= "\t\t\t\t\t" . "<tr>" . "\n";
                        $html .= "\t\t\t\t\t" .'<td>'."\n";
                            $html .= "\t\t\t\t\t\t" .'<input type="checkbox" class="checkboxes" value="1" />'."\n";
                        $html .= "\t\t\t\t\t" .'</td>'."\n";
                        foreach($valor as $l)
                        {
                            $html .= "\t\t\t\t\t\t" . "<td>" . "\n";
                            $html .= "\t\t\t\t\t\t\t" . "{{$l}}" . "\n";
                            $html .= "\t\t\t\t\t\t" . "</td>" . "\n";
                        }
                            $html .= "\t\t\t\t\t\t" . "<td>" . "\n";
                            $html .= "\t\t\t\t\t\t\t" . "<button data-id='{{$list[0]}}' data-find='{find}' class='form-edit btn btn-link btn-xs' type='button'>" . "\n";
                                $html .= "\t\t\t\t\t\t\t\tAlterar \n";
                            $html .= "\t\t\t\t\t\t\t" . "</button>" . "\n";
                            $html .= "\t\t\t\t\t\t\t" . "<button data-id='{{$list[0]}}' data-find='{find}' class='form-delete brn btn-link btn-xs' type='button'>" . "\n";
                                $html .= "\t\t\t\t\t\t\t\t" . "Excluir" . "\n";
                            $html .= "\t\t\t\t\t\t\t" . "</button>" . "\n";
                        $html .= "\t\t\t\t\t\t" . "</td>" . "\n";
                    $html .= "\t\t\t\t\t" . "</tr>" . "\n";
                $html .= "\t\t\t\t\t" . "{/itens}" . "\n";
            $html .= "\t\t\t" . "</tbody>" . "\n";
        $html .= "\t\t" . "</table>" . "\n";
        $html .= "\t\t" . "<!-- /.modal -->" . "\n";
    $html .= "\t" . "</div>" . "\n";
$html .= "</div>" . "\n";
if(file_put_contents($name.'/'.$name."/lista.php", $html)){
    echo "Arquivo Criado ".$name."<br>";
    echo "<meta http-equiv='refresh' content='3; URL=index.php'>";
    exit;
}else{
    echo "erro".$lis_sav;
}
/*HTML*/
/*=========================================================end create file html list============================================*/