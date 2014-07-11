<?
	if(isset($_SESSION)){
		if(isset($_SESSION["msg"])){
			if($_SESSION["msg"] != ""){
?>
				<script>
					jAlert("<? echo $_SESSION["msg"]; ?>");
				</script>
<?
			}
			unset($_SESSION["msg"]);
		}	
	}
?>
