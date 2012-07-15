<?php require_once("cop.php") ?>
<?php

	extract($_GET);
	
	if (isset($p)) {
		require_once("$p.php");
	} else {
		require_once("subcategoriasCont.php");
	}
	

?>