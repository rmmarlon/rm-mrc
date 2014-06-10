<?
	if(!isset($_POST['name'])){
		$_POST['name'] = NULL;
	}
	if(!isset($_POST['field'])){
		$_POST['field'] = NULL;
	}
?>

<?
    /*select com a funcao initcap() que funciona == a funcção php ucwords
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
			Criar arquivos
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
				Crair arquivos
			</header>
			<article>
				<form method="post" action="gerar_arquivos.php">
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
                            ?>

                        </tbody>
                    </table>
                </div>
			</article>
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