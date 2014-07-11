<?
	session_start();
	require_once("classes/autoload.php");
	require_once("conADODBopen.php");
	require_once("tool/funcoes.php");
	
	if(! isset($_POST['acao'])){
		$_POST['acao'] = NULL;
	}
	if($_POST['acao'] == 'validar'){
		$parametro[] = $_POST['usua_email'];
		$parametro[] = md5($_POST['usua_senha']);
		
		$dao = new UsuariosDAO();
		$oU = $dao->select(2,$parametro);
		
		if(is_null($oU)){
			$_SESSION['msg'] = 'Usuário não cadastrado no sistema';
			session_destroy();
		} else{

			$_SESSION['lojaAutenticada'] = $oU->getCodigo();
			header("Location: areaAutenticada.php");
		}
	}
?>
<!doctype html>
<html>
	<head>
        <meta charset="utf-8">
        <title>
        	lOGIN DE ACESSO
        </title>
        <link rel="stylesheet" type="text/css" href="personalizado/estilo.css">
        <link rel="stylesheet" type="text/css" href="personalizado/bootstrap.min.css">
        <script src="tool/jquery.js"></script>
        <script src="tool/bootbox.min.js"></script>
        <script src="tool/bootstrap.min.js"></script>
        <script src="tool/script.js"></script>
        <script>
			$(document).ready(function(e) {
                $("#btnEntrar").click(function(e) {
                    if($("#usua_email").val() == ""){
						bootbox.alert("Favor preencher o campo email!!");
					} else if($("#usua_senha").val() == ""){
						bootbox.alert("Favor preencher o campo senha!!");
					} else{
						$("#acao").val('validar');
						$("form").submit();
					}
                });
            });
		</script>
		<style>
            .novo{
                width: 50%;
                margin: 15% auto;
                border-radius: 5px;
            }
		</style>
	</head>
	<body>
        <div class="novo">
            <div class="col-md-9">
                <div class="portlet-body form">
                    <form class="form-horizontal" method="post">
                        <input type="hidden" id="acao" name="acao">
                        <h4 class="page-breadcrumb breadcrumb" align="center">
                            Acesse
                        </h4>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Login
                            </label>
                            <div class="col-md-5">
                                <input type="text" placeholder="Login" class="form-control" name="usua_email" id="usua_email">
                            </div>
                        </div>
                        <div class="clear"><br></div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Senha
                            </label>
                            <div class="col-md-5">
                                <input type="password" placeholder="senha" name="usua_senha" class="form-control" id="usua_senha">
                            </div>
                        </div>
                        <div class="clear"><br></div>
                        <div class="page-breadcrumb breadcrumb">
                            <div class="pull-right">
                                <input type="button"  class="btn btn-primary" name="btnEntrar" id="btnEntrar" value="Entrar">
                            </div>
                            <div class="clear"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</body>
</html>
<?
	require_once("tool/alerta.php");
	require_once("conADODBclose.php");
?>
