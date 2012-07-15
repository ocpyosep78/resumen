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

    $colname_scat = "-1";

    if (isset($_POST['idCategoria'])) {
      $colname_scat = $_POST['idCategoria'];
    }

		$query_scat = sprintf("SELECT * FROM tblsubcategorias WHERE idCategoria = %s", GetSQLValueString($colname_scat, "int"));
		$scat = mysql_query($query_scat, $bdresumen) or die(mysql_error());
		$row_scat = mysql_fetch_assoc($scat);
		$totalRows_scat = mysql_num_rows($scat);
		do {
      $json['subcategoria']['id'][] = $row_scat['idSubcategoria'];      
			$json['subcategoria']['codigo'][] = $row_scat['codigoSubcategoria'];

      $codsc = $row_scat['codigoSubcategoria'];

      mysql_select_db($database_bdresumen, $bdresumen);
      $query_r = "SELECT * FROM tblresumen WHERE idSubcategoria = '".$row_scat['idSubcategoria']."' ORDER BY idResumen DESC LIMIT 1 ";
      $r = mysql_query($query_r, $bdresumen) or die(mysql_error());
      $row_r = mysql_fetch_assoc($r);
      $totalRows_r = mysql_num_rows($r);

      if ($row_r['idResumen']+1<10) {
        $codigo = $codsc."-0".($row_r['idResumen']+1);
      } else {
        $codigo = $codsc."-".($row_r['idResumen']+1);
      }

      $json['subcategoria']['nextCode'][] = $codigo;
			$json['subcategoria']['nombre'][] = $row_scat['nombreSubcategoria'];
		}while($row_scat = mysql_fetch_assoc($scat));
		$rowsscat = mysql_num_rows($scat);
		
		if($rowsscat > 0) {
			mysql_data_seek($scat, 0);
			$row_scat = mysql_fetch_assoc($scat);
		}
    echo json_encode($json);
    mysql_free_result($scat);
?>