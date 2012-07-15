<?php require_once("cop.php") ?>
<?php require_once('Connections/bdresumen.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$ni=$_POST['ni']+1;


$colname_tblusuario = "-1";
if (isset($_POST['login'])) {
  $colname_tblusuario = $_POST['login'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_tblusuario = sprintf("SELECT * FROM tblusuario WHERE loginUsuario = %s", GetSQLValueString($colname_tblusuario, "text"));
$tblusuario = mysql_query($query_tblusuario, $bdresumen) or die(mysql_error());
$row_tblusuario = mysql_fetch_assoc($tblusuario);
$totalRows_tblusuario = mysql_num_rows($tblusuario);

if($totalRows_tblusuario > 0)
{
	$usuario_tblusuario = "-1";
	if (isset($_POST['login'])) {
	  $usuario_tblusuario = $_POST['login'];
	}
	$clave_tblusuario = "-1";
	if (isset($_POST['clave'])) {
	  $clave_tblusuario = md5($_POST['clave']);
	}
	mysql_select_db($database_bdresumen, $bdresumen);
	echo $query_tblusuario = sprintf("SELECT * FROM tblusuario WHERE loginUsuario = %s AND claveUsuario = %s AND statusUsuario = 'A'", GetSQLValueString($usuario_tblusuario, "text"), GetSQLValueString($clave_tblusuario, "text"));
	$tblusuario = mysql_query($query_tblusuario, $bdresumen) or die(mysql_error());
	$row_tblusuario = mysql_fetch_assoc($tblusuario);
	$totalRows_tblusuario = mysql_num_rows($tblusuario);
	if($totalRows_tblusuario > 0)
	{
		session_name("resumen");
		session_start();
		$_SESSION['nombreUsuario']=$row_tblusuario['nombreUsuario'];
		$_SESSION['apellidoUsuario']=$row_tblusuario['apellidoUsuario'];
		$_SESSION['cedulaUsuario']=$row_tblusuario['cedulaUsuario'];
		$_SESSION['idUsuario']=$row_tblusuario['idUsuario'];
		
		$usuario_tblpermisos = "-1";
		if (isset($row_tblusuario['idUsuario'])) {
		  $usuario_tblpermisos = $row_tblusuario['idUsuario'];
		}
		mysql_select_db($database_bdresumen, $bdresumen);
		echo $query_tblpermisos = sprintf("SELECT * FROM tblpermisos WHERE idUsuario = %s", GetSQLValueString($usuario_tblpermisos, "text"));
		$tblpermisos = mysql_query($query_tblpermisos, $bdresumen) or die(mysql_error());
		$row_tblpermisos = mysql_fetch_assoc($tblpermisos);
		$totalRows_tblpermisos = mysql_num_rows($tblpermisos);
		
		$_SESSION['modUsuario']=$row_tblpermisos['modUsuario'];
		$_SESSION['agregarUsuario']=$row_tblpermisos['agregarUsuario'];
		$_SESSION['modificarUsuario']=$row_tblpermisos['modificarUsuario'];
		$_SESSION['eliminarUsuario']=$row_tblpermisos['eliminarUsuario'];
		$_SESSION['modTutores']=$row_tblpermisos['modTutores'];
		$_SESSION['agregarTutores']=$row_tblpermisos['agregarTutores'];
		$_SESSION['modificarTutores']=$row_tblpermisos['modificarTutores'];
		$_SESSION['eliminarTutores']=$row_tblpermisos['eliminarTutores'];
		$_SESSION['modCategorias']=$row_tblpermisos['modCategorias'];
		$_SESSION['agregarCategorias']=$row_tblpermisos['agregarCategorias'];
		$_SESSION['modificarCategorias']=$row_tblpermisos['modificarCategorias'];
		$_SESSION['eliminarCategorias']=$row_tblpermisos['eliminarCategorias'];
		$_SESSION['modSubcategorias']=$row_tblpermisos['modSubcategorias'];
		$_SESSION['agregarSubcategorias']=$row_tblpermisos['agregarSubcategorias'];
		$_SESSION['modificarSubcategorias']=$row_tblpermisos['modificarSubcategorias'];
		$_SESSION['eliminarSubcategorias']=$row_tblpermisos['eliminarSubcategorias'];
		$_SESSION['modResumen']=$row_tblpermisos['modResumen'];
		$_SESSION['agregarResumen']=$row_tblpermisos['agregarResumen'];
		$_SESSION['modificarResumen']=$row_tblpermisos['modificarResumen'];
		$_SESSION['eliminarResumen']=$row_tblpermisos['eliminarResumen'];
		$_SESSION['modUbicaciones']=$row_tblpermisos['modUbicaciones'];
		$_SESSION['agregarUbicaciones']=$row_tblpermisos['agregarUbicaciones'];
		$_SESSION['modificarUbicaciones']=$row_tblpermisos['modificarUbicaciones'];
		$_SESSION['eliminarUbicaciones']=$row_tblpermisos['eliminarUbicaciones'];
		$_SESSION['modArea']=$row_tblpermisos['modUbicaciones'];
		$_SESSION['agregarArea']=$row_tblpermisos['agregarUbicaciones'];
		$_SESSION['modificarArea']=$row_tblpermisos['modificarUbicaciones'];
		$_SESSION['eliminarArea']=$row_tblpermisos['eliminarUbicaciones'];
		
		header("location: backend.php");
	} else 
	{
		
		header("location: index.php?ec&ni=$ni");
	
	}

} else 
{
	
	header("location: index.php?eu&ni=$ni");
	
}
mysql_free_result($tblusuario);
?>
