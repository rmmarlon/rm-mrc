<?php
   /*
            Autor : Leandro Ferreira Marcelli
             Data : 01/08/2012

          Arquivo : autoload.php
        Descri��o : carregamento automatico de classes

       Data        Respons�vel         Breve defini��o
       ==========  ==================  ==================================================
       01/08/2012  Leandro F Marcelli  Defini��o inicial
   */
	
	function __autoload($class_name){
   	require_once $class_name . '.php';
	}
?>