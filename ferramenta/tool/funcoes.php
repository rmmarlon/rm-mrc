<?php
/**
            Autor : Leandro Ferreira Marcelli
             Data : 30/07/2012

          Arquivo : funcoes.php
        Descrição : arquivo de funcoes diversas em php
*/

/**
		Autor : Leandro Ferreira Marcelli
		 Data : 30/07/2012
	    Descrição : envia e-mail
*/

    function paginacaoBtn($pagina,$caminho,$numPages){
        $maxLinks = 2;
        echo "<ul class='pagination'>";
        if(! ($pagina == 1)){
            echo "<li><a class='btn' href='".$caminho.".php?pagina=1' target='_self'>&laquo;&laquo;</a></li>";
        }
        for($i = $pagina-$maxLinks; $i <= $pagina-1; $i++) {
            if($i <=0) {
            } else {
                echo "<li><a class='btn' href='".$caminho.".php?pagina=".$i."' id='".$i."' target='_self'>".$i."</a></li>";
            }
        }
        echo '<li class="active"><a id="'.$i.'">'.$pagina.'</a></li>';
        for($i = $pagina+1; $i <= $pagina+$maxLinks; $i++) {
            if($i > $numPages) {
            }
            else {
                echo "<li><a class='btn' id='".$i."' href='".$caminho.".php?pagina=".$i."' target='_self'>".$i."</a></li>";
            }
        }
        if(!($pagina == $numPages)){
            echo "<li><a class='btn' id='".$i."' href='".$caminho.".php?pagina=".$numPages."' target='_self'>&raquo;&raquo;</a></li>";
        }
        echo "</ul>";
    }

	function enviaEmail($bodyMail, $assuntoMail, $mail1, $nomeMail1, $mail2, $nomeMail2, $mail3, $nomeMail3, $mail4, $nomeMail4, $mail5, $nomeMail5, $mail6, $nomeMail6){
		error_reporting(E_STRICT);
		date_default_timezone_set('America/Toronto');
		
		require_once('phpmailer/class.smtp.php');
		require_once('phpmailer/class.phpmailer.php');
		//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
		$mail             = new PHPMailer();
		$body             = $bodyMail;
		
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
																 // 1 = errors and messages
																 // 2 = messages only
		
		$mail->Mailer     = "smtp";
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
		$mail->Username   = "";  // GMAIL username
		$mail->Password   = "";            // GMAIL password		
		$mail->SetFrom('', '');
		$mail->Subject    = $assuntoMail;
		$mail->AltBody    = "Para visualizar este e-mail, favor utilizar um visualizador de e-mail compatível com HTML!"; // optional, comment out and test
		
		$mail->MsgHTML($body);
				
		if(! is_null($mail1)){
			$mail->AddAddress($mail1, $nomeMail1);	
		}
		if(! is_null($mail2)){
			$mail->AddAddress($mail2, $nomeMail2);	
		}
		if(! is_null($mail3)){
			$mail->AddAddress($mail3, $nomeMail3);	
		}
		if(! is_null($mail4)){
			$mail->AddAddress($mail4, $nomeMail4);	
		}
		if(! is_null($mail5)){
			$mail->AddAddress($mail5, $nomeMail5);	
		}
		if(! is_null($mail6)){
			$mail->AddAddress($mail6, $nomeMail6);	
		}
		$mail->Send();
	}
	/* FUNÇÃO PARA INSERIR NA AUDITORIA*/
	
	function auditoria($descricao){
		if(! isset($_SESSION['codigoAutenticado'])){
			session_start('integracao');
		}
		$listaEndereco = explode("?", $_SERVER ['REQUEST_URI']);
		$endereco = $listaEndereco[0];
		
		global $db;
		
		$sql = sprintf('insert into "auditoria" ("idCadastro", 
																  "descricao", 
																  "menuDescricao", 
																  "ip", 
																  "dataCadastro") values (%u, %s, %s, %s, now())',
																  $_SESSION["codigoAutenticado"],
																  $db->qstr($descricao),
																  $db->qstr($endereco),
																  $db->qstr($_SERVER['REMOTE_ADDR']));
		$db->BeginTrans();

		try {
			$db->Execute($sql);
			$db->CommitTrans();
		} catch (exception $e) {
			$_SESSION["msg"] = $e->getMessage();
			$db->RollBackTrans();
		}
	}
	
	function corrigeValor($valor){
		$valor = str_replace(".", "", $valor);
		$valor = str_replace(",", ".", $valor);
		
		return $valor;
	}
	
	function corrigeData($valor){
		$valor = substr($valor,6,4) ."-". substr($valor,3,2) ."-". substr($valor,0,2);	
		
		return $valor;
	}
	
	function qstr($valor){
		$filtro = array('\'' => '', '"' => '');
		$retorno = strTr($valor, $filtro);
		return $retorno;
	}
	
	function criptografia($string){
		$codificada = hash('whirlpool', $string);
		$codificada = hash('sha512', $codificada);
		return $codificada;
	}
	
	function mesExtenso($valor){
		switch ($valor) {
			case 1:
				$valor = "Janeiro";
			break;
			case 2:
				$valor = "Fevereiro";
			break;
			case 3:
				$valor = "Março";
			break;
			case 4:
				$valor = "Abril";
			break;
			case 5:
				$valor = "Maio";
			break;
			case 6:
				$valor = "Junho";
			break;
			case 7:
				$valor = "Julho";
			break;
			case 8:
				$valor = "Agosto";
			break;
			case 9:
				$valor = "Setembro";
			break;
			case 10:
				$valor = "Outubro";
			break;
			case 11:
				$valor = "Novembro";
			break;
			case 12:
				$valor = "Dezembro";
			break;
		}
		return $valor;
	}
	
	function semanaExtenso($valor){
		switch ($valor) {
			case "Sun":
			$valor = "Domingo";
			break;
			case "Mon":
			$valor = "Segunda-feira";
			break;
			case "Tue":
			$valor = "Terça-feira";
			break;
			case "Wed":
			$valor = "Quarta-feira";
			break;
			case "Thu":
			$valor = "Quinta-feira";
			break;
			case "Fri":
			$valor = "Sexta-feira";
			break;
			case "Sat":
			$valor = "Sábado";
			break;
		}
		return $valor;
	}
	
	function diferencaData($dataInicial, $dataFinal){
		if(strlen($dataInicial) == 10
		&& strlen($dataFinal) == 10){
			###VERIFICO SE A DATA ESTÁ NO FORMATO DD/MM/YYYY e converto para DDD-MM-AA
			if(substr($dataInicial, 2, 1) == "/"){
				$dataInicial = corrigeData($dataInicial);
			}
			if(substr($dataFinal, 2, 1) == "/"){
				$dataFinal = corrigeData($dataFinal);
			}
			###FIM CONVERSÃO
			
			$diferenca = mktime(0, 0,0,substr($dataFinal, 5, 2), substr($dataFinal, 8, 2), substr($dataFinal, 0, 4)) - 
							 mktime(0, 0, 0, substr($dataInicial, 5, 2), substr($dataInicial, 8, 2), substr($dataInicial, 0, 4));
			$retorno = $diferenca / (60*60*24);
		} else {
			$retorno = 0;
		}
		
		return $retorno;
	}
	
	function dataHojeExtenso(){
		$dia = date("d");
		$mes = date("n");
		$ano = date("Y");
		$diaSemana = date("D");
		
		return semanaExtenso($diaSemana) .", ". $dia ." de ". mesExtenso($mes) ." de ". $ano;
	}
	
	function valorExtenso($valor) {
   
		$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

		$z=0;

			$valor = number_format($valor, 2, ".", ".");
			$inteiro = explode(".", $valor);
			for($i=0;$i<count($inteiro);$i++)
				for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
					$inteiro[$i] = "0".$inteiro[$i];
		
			// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
			$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
			for ($i=0;$i<count($inteiro);$i++) {
				$valor = $inteiro[$i];
				$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
				$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
				$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
		
				$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
				$t = count($inteiro)-1-$i;
				$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
				if ($valor == "000")$z++; elseif ($z > 0) $z--;
				if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
				if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
			($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}
	
		return($rt ? $rt : "zero");
	}
	
	function calculoMeses($value){
		$ano = substr($value, 0, 4);
		$semestre = substr($value, 5, 1);
		$mes = $semestre == 1 ? '06' : '12';
		$tempoValor = mktime(0,0,0,$mes,30,$ano);
		$tempoAtual = mktime(0,0,0,date("m"), 30, date("Y"));
		if($tempoAtual > $tempoValor){
			$retorno = 0;
		} else {
			$retorno = round(($tempoValor - $tempoAtual)/(60*60*24*30))+1;
		}
		return $retorno;
	}
	function calculoData($anoSemestre = NULL, $periodoCalculo = NULL){
		if(is_null($anoSemestre)
		|| is_null($periodoCalculo)){
			$retorno = NULL;
		} else {
			###DEFINO A DATA DO TERMINO DO CURSO
			$ano = substr($anoSemestre, 0, 4);
			$semestre = substr($anoSemestre, 5, 1);
			$mes = $semestre == 1 ? '06' : '12';
			###FIM Do CALCULO
			
			###Defino a data do item
			if($periodoCalculo == 0){
				$retorno = date("Y-m-d", mktime(0,0,0,$mes+1,0, $ano));
			} else {
				$retorno = date("Y-m-d", mktime(0,0,0,$mes-($periodoCalculo-1),0, $ano));
			}
			###FIM DA VALIDAÇÃO
			
		}
		return $retorno;
	}
?>