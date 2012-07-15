<?php
@session_name("resumen");
@session_start();
if (!isset($_SESSION['nombreUsuario'])) 
{
	header("location: index.php");
}
if (isset($_GET['salir'])) 
{
	session_name("resumen");
	session_destroy();
	header("location: index.php");
}

?>