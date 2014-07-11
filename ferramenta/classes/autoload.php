<?php
   /*
            Autor : Leandro Ferreira Marcelli
             Data : 01/08/2012

          Arquivo : autoload.php
        Descriчуo : carregamento automatico de classes

       Data        Responsсvel         Breve definiчуo
       ==========  ==================  ==================================================
       01/08/2012  Leandro F Marcelli  Definiчуo inicial
   */
	
	function __autoload($class_name){
   	require_once $class_name . '.php';
	}
?>