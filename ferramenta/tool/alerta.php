<?
	if(isset($_SESSION)){
		if(isset($_SESSION["msg"])){
			if($_SESSION["msg"] != ""){
?>
				<script>
					bootbox.alert("<? echo $_SESSION["msg"]; ?>");
				</script>
<?
			}
			unset($_SESSION["msg"]);
		}	
	}
?>
