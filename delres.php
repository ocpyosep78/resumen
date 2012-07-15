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

mysql_select_db($database_bdresumen, $bdresumen);
$query_resumenes = "SELECT * FROM tblresumen WHERE idResumen = '".$_GET['idResumen']."'";
$resumenes = mysql_query($query_resumenes, $bdresumen) or die(mysql_error());
$row_resumenes = mysql_fetch_assoc($resumenes);
$totalRows_resumenes = mysql_num_rows($resumenes);
unlink('uploads/'.$row_resumenes['archivoResumen']);

if ((isset($_GET['idResumen'])) && ($_GET['idResumen'] != "")) {
  $deleteSQL = sprintf("DELETE FROM tblresumen WHERE idResumen=%s",
                       GetSQLValueString($_GET['idResumen'], "int"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($deleteSQL, $bdresumen) or die(mysql_error());

  $deleteGoTo = "resumen.php";
  header(sprintf("Location: %s", $deleteGoTo));
}

?>
