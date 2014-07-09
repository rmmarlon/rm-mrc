<?
	if(!isset($_POST['name'])){
		$_POST['name'] = NULL;
	}
	if(!isset($_POST['field'])){
		$_POST['field'] = NULL;
	}´
?>

<?
    /*select com a funsdtgertcao initcap() que funciona == a funcção php ucwords
    SELECT INITCAP("pais_nome")
    from nfe_pais
    se for em aspas simples ele imprime o valor(no caso pais_nome)
    se for em aspas duplas ele imprime o campo(no caso pais_nome)
    */
?>
<!doctype>
<html>
	<head>
		<meta charset="utf-8">
		<title>
			Criar arquivosdsfsdfsd
		</title>
        <link rel="stylesheet" href="miniDropdown-js/css/site.css">
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript">
            function replaceAll(string, token, newToken){
                while(string.indexOf(token) != -1){
                    string = string.replace(token, newToken);
                }
                return string;
            }
			$(document).ready(function(e){

				$("#btnAdd").click(function(){
					$("#campos").append('<p class="fields"><input type="text" name="field[]"></p>');
				});
				$("#btnRemove").click(function(){
					$(".fields:last").remove();
				});
                var buffer = "bancos operacao";
                if(/^[cnae|ncm|cfop]{3,4}$/i.test(buffer.substr(-4))){
                    //alert(buffer.substr(buffer.indexOf(' ')+1));
                }
                //resolver /^[cnae|ncm|cfop]{3,4}$/i.test(value.substr(-4).trim())
                /*for (i =0; i < 127; i++) {
                    var Chars = String.fromCharCode(i);
                    document.write(Chars)+"\n";

                }*/
			});
            /*function Password() {
                var pass = "";
                var chars = 10; //Número de caracteres da senha
                generate = function(chars) {
                    for (var i= 0; i
                         pass += this.getRandomChar();
                }
//document.getElementById("senha").innerHTML( pass );
                $("#senha").val(pass);
            }
            this.getRandomChar = function() {
                /*
                 * matriz contendo em cada linha indices (inicial e final) da tabela ASCII para retornar alguns caracteres.
                 * [48, 57] = numeros;
                 * [64, 90] = "@" mais letras maiusculas;
                 * [97, 122] = letras minusculas;
                 *
                var ascii = [[48, 57],[64,90],[97,122]];
                var i = Math.floor(Math.random()*ascii.length);

                return String.fromCharCode(Math.floor(Math.random()*(ascii[i][1]-ascii[i][0]))+ascii[i][0]);
            }
            generate(chars);
            }*/
            $(document).ready(function(e){
                var ascii = "marlo1232434HANSLDOPEDAcPEnALA";
                var i = Math.floor(Math.random()*ascii.length);

                var result = String.fromCharCode(Math.floor(Math.random()*(ascii[i][1]-ascii[i][0]))+ascii[i][0]);
                $("#senha").val(result);
                //alert(ascii.substr(i,1));
				$("#veic_status").click(function(){
					if($(this).parent().find('div'))
					{
						//var es = $(this).parent().parent().siblings().text();
						alert('es');
					}else{
						var es = $(this).parent().siblings().text();
						alert(es);
					}
					//var valor = $(this).parent().parent().siblings().text();
				});
				$("#upp").keyup(function(){
					this.value = this.value.toLowerCase();
						
				});
				$("#btnNumbers").click(function()
				{
					var decimal=0;
					var objeto = $("#numbers").val();
					for(var i=0;i<objeto.length;i++)
					{
						//alert(objeto.substr(i,1));
						if(objeto.substr(i,1)==",")
						{
							alert(decimal = i);
						}
					}
				});
            });

        </script>
        <style>
            th
            {
                text-align: center;
            }
        </style>
	</head>
	<body>
    <!--div id="container">
        <header>
            <h1>
                <strong>miniDropdown demo</strong> - jQuery Plugin
            </h1>
        </header>

        <h2>Default</h2>
        <nav id="mini-dropdown-1">
            <ul class="dropdown">
                <li>
                    <a href="#">Home</a>
                    <ul>
                        <li><a href="#">Generic</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Item</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">About</a>
                    <ul>
                        <li><a href="#">Another</a></li>
                        <li><a href="#">Generic</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Item</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Another</a>
                    <ul>
                        <li><a href="#">Generic</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Item</a></li>
                    </ul>
                </li>
                <li><a href="#">Generic</a></li>
                <li><a href="#">Menu</a></li>
            </ul>
        </nav>

        <h2>Animation</h2>
        <nav id="mini-dropdown-2">
            <ul class="dropdown">
                <li>
                    <a href="#">Home</a>
                    <ul>
                        <li><a href="#">Generic</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Item</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">About</a>
                    <ul>
                        <li><a href="#">Another</a></li>
                        <li><a href="#">Generic</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Item</a></li>
                    </ul>
                </li>
                <li><a href="#">Another</a></li>
                <li><a href="#">Generic</a></li>
                <li><a href="#">Menu</a></li>
            </ul>
        </nav>

        <h2>Custom Animation</h2>
        <nav id="mini-dropdown-3">
            <ul class="dropdown">
                <li>
                    <a href="#">Home</a>
                    <ul>
                        <li><a href="#">Generic</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Item</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">About</a>
                    <ul>
                        <li><a href="#">Another</a></li>
                        <li><a href="#">Generic</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Item</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Another</a>
                    <ul>
                        <li><a href="#">Another</a></li>
                        <li><a href="#">Generic</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Item</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Generic</a>
                    <ul>
                        <li><a href="#">Another</a></li>
                        <li><a href="#">Generic</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Item</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Menu</a>
                    <ul>
                        <li><a href="#">Another</a></li>
                        <li><a href="#">Generic</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Item</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

    <script src="miniDropdown-js/js/libs/jquery.min.js"></script>
    <script src="miniDropdown-js/js/miniDropdown.js"></script>
    <script>
        $(function(){
            // Basic example
            $('#mini-dropdown-1 .dropdown').miniDropdown();

            // Built in animation
            $('#mini-dropdown-2 .dropdown').miniDropdown({
                animation: 'slide',
                show: 100,
                hide: 100,
                delayIn: 100,
                delayOut: 100
            });

            // Custom animations
            $('#mini-dropdown-3 .dropdown').miniDropdown({
                showFunction: function(item, subnav) {
                    subnav.css({right: 0, opacity: 0}).show();
                    subnav.animate({right: $(window).width() - item.offset().left - item.width() , opacity: 1}, 200)
                },
                hideFunction: function(item, subnav) {
                    subnav.animate({right:  $(window).width(), opacity: 0}, 300, function(){
                        $(this).hide();
                    })
                }

            });
        });
    </script-->
		<section>
			<header>
				<strong>Crair arquivos</strong>
			</header>
			<?
				$mesIni = 07;
				$anoIni = 2014;
				$mes = date("m", mktime(0, 0, 0, $mesIni - $i, 28, $anoIni));
                $ano = date("Y", mktime(0, 0, 0, $mesIni - $i, 28, $anoIni));
				
				
				$dataInicialLoop = date("Y-m-t", mktime(0, 0, 0, $mes, 1, $ano));
                $dataFinalLoop = $ano."-".$mes."-1";
										
				echo "MES :".$mes." ANO :".$ano." DATA INI :".$dataInicialLoop." DATA FIN :".$dataFinalLoop;
			?>
			<div>
				<header>UPPER</header>
				<input type="text" id="upp">
				
			</div>
			<article>
				<form method="post" action="gerar_arquivos.php">
					<input type="text" name="saldo_inicial" id="numbers" onkeypress="javascript: return FloatValidate(this.value, true, event);">
					<input type="button" value="testar" id="btnNumbers">
					<p>
						<input type="text" name="name" id="repla">
					</p>
					<input type="button" accesskey="+" id="btnAdd" value="+">
					<input type="button" id="btnRemove" value="-">
					<div id="campos"></div>
					<br>
					<input type="submit" value="Criar">
                    <?
                        $html = "<blockquote><p>mais fácil é explodir um <strong>átomo</strong> que um preconceito.</p></blockquote><p><em>Albert Einstein</em></p>";
                        preg_match_all('/<strong>(\w*)/',$html,$cotacao);
                        var_dump($cotacao);

                    ?>

				</form>
                <div id="ascii">
                    <span>finally = finalmente</span>
                    <span>do = fazer</span>
                    <span>they = eles</span>
                    <p>
                        <h4>Present Continuous
                            descrive ações que estão acontecendo no momento
                            Tanto forma Afirmativa, interrogativa e negativa
                        </h4>
                        <p>I am making pancakes. = Eu estou fazendo panquicas</p>
                        <p>what is dad doing? = o que é isso pai</p>
                        <p>what do you do? = o que você faz</p>
                        <p>what are they doing? = o que eles estão fazendo</p>
                        <p>what they you doing? = o que você está fazendo</p>
                    </p>
                    <table border="1">
                        <thead>
                            <tr>
                                <th colspan="7">
                                    <strong>Forma afirmativa do Present Continuous</strong>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Sujeito
                                </td>
                                <td><strong>+</strong></td>
                                <td>
                                    Verbo <strong>TO BE</strong><br>
                                    No tempo presente
                                </td>
                                <td><strong>+</strong></td>
                                <td>
                                    verbo terminado <br>
                                    em <strong>ING</strong>
                                </td>
                                <td><strong>+</strong></td>
                                <td>
                                    Complemento
                                </td>
                            </tr>
                            <?
                                $sujeito = array(
                                            'EU'=>'I',
                                            'VOCÊ'=>'YOU',
                                            'ELE'=>'HE',
                                            'ELA'=>'SHE',
                                            'ELE'=>'IT',
                                            'NÓS'=>'WE',
                                            'ELES'=>'THEY',
                                        );
                                $verbo = array('ESTAR' =>'AM',
                                                'SÃO'=>'ARE',
                                                'É'=>'IS',
                                                'É'=>'IS',
                                                'É'=>'IS',
                                                'SÃO'=>'ARE',
                                                'SÃO'=>'ARE',
                                            );
                                foreach($sujeito as $c=>$s)
                                {
                                ?>
                                    <tr>
                                        <td>
                                            <?=$c .' = '. $s;?>
                                        </td>
                            <?
                                }
                                foreach($verbo as $k=>$v)
                                {
                            ?>
                                        <td><strong>+</strong></td>
                                        <td>
                                            <?=$k .' = '. $v;?>
                                        </td>
                                        <td><strong>+</strong></td>
                                        <td>
                                            <strong>WRITING</strong>
                                        </td>
                                        <td><strong>+</strong></td>
                                        <td>
                                            A LETTER
                                        </td>
                                    </tr>
                            <?
                                }
															
							$pizza  = "piece1_piece2-piece3 piece4 piece5-piece6";
							$pieces = explode('-', $pizza);
							var_dump($pieces);
							
                            $num=str_replace(".","",'80.000');
                            intval($num);
                            //echo gettype($num);
							$str = "A 'quote' is <b>bold</b>";

							// Outputs: A 'quote' is &lt;b&gt;bold&lt;/b&gt;
							echo htmlentities($str);

							// Outputs: A &#039;quote&#039; is &lt;b&gt;bold&lt;/b&gt;
							echo htmlentities($str, ENT_QUOTES);
							echo strtoupper("produzida e instanciada pela class SelectQuery");
                            ?>

                        </tbody>
                    </table>
                </div>
			</article>
			<table>
				<tr>
					<td class="text">
						<span class="obrigatorio">*</span>Status:
					</td>
					<td>
						
							<select onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur" name="veic_status" id="veic_status">
								<option value="">----Selecione----</option>
								<option value="1">NOVO</option>
								<option value="2">USADO</option>
							</select>
						
					</td>
                </tr>
			</table>
		</section>

    </body>
</html>
<? /*
function aleatorio(){
$novo_valor= "";
$valor = "ABCDEFGHJKLMNPQRSTUVWYZ123456789";
srand((double)microtime()*1000000);
for ($i=0; $i<6; $i++){
$novo_valor.= $valor[rand()%strlen($valor)];
}
return substr($novo_valor,0,1);
}
echo aleatorio();
*/
?>
nshgttb = <A1g&-r6i2K3
INITCAP('field') = function SQL to recovery data in Capitaliza.