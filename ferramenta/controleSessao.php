<?	
	session_start();
	if(! isset($_SESSION["lojaAutenticada"])){
		$_SESSION["lojaAutenticada"] = 0;
	}
	if(! $_SESSION['lojaAutenticada'] > 0){
		session_destroy();
		require("encerraSessao.php");
		exit();
	}
?>