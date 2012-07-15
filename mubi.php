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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE tblubicaciones SET nombreUbicacion=%s WHERE idUbicacion=%s",
                       GetSQLValueString($_POST['nombreUbicacion'], "text"),
                       GetSQLValueString($_POST['idUbicacion'], "int"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($updateSQL, $bdresumen) or die(mysql_error());

  $updateGoTo = "ubicaciones.php";
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_ubicacion = "-1";
if (isset($_GET['idUbicacion'])) {
  $colname_ubicacion = $_GET['idUbicacion'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_ubicacion = sprintf("SELECT * FROM tblubicaciones WHERE idUbicacion = %s", GetSQLValueString($colname_ubicacion, "int"));
$ubicacion = mysql_query($query_ubicacion, $bdresumen) or die(mysql_error());
$row_ubicacion = mysql_fetch_assoc($ubicacion);
$totalRows_ubicacion = mysql_num_rows($ubicacion);
 extract($_GET);?>

<div style="margin:20px;">
<div class="container-fluid" style="margin:auto">
    <div class="row-fluid">
      <div class="span12">
        <div class="well">
            <div class="row-fluid">
          		<img src="img/ubicaciones.png" width="50" height="50"><h2>Modificar Ubicación</h2>
           		<div class="atras"><button class="btn btn-success" onclick='window.location="ubicaciones.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
          	</div>
                <div class="row-fluid">
                    <form name="mubi" id="mubi" class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST">
                    <fieldset>
                      <legend></legend>
                      <div class="control-group">
                        <label class="control-label" for="nombreUbicacion">Nombre</label>
                        <div class="controls">
                          <input type="text" class="input-xlarge" name="nombreUbicacion" id="nombreUbicacion" value="<?php echo $row_ubicacion['nombreUbicacion']; ?>" placeholder="Nombre de la Ubicación">
                        </div>
                      </div>
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Modificar</button>
                        <button class="btn" type="reset">Limpiar</button>
                      </div>
                    </fieldset>
                    <input type="hidden" name="idUbicacion" value="<?php if (isset($idUbicacion)) { echo $idUbicacion; }?>">
                    <input type="hidden" name="MM_update" value="form" />
                  </form>
              </div>
          </div>                    
        </div><!--/span-->
        
 
      
      
      </div>
</div>
		<script>
      		var frmMUBI = new Validator("mubi");
			
			frmMUBI.addValidation("nombreUbicacion","req","Por favor ingrese un Nombre para la Ubicación");

      	</script>
        
<?php
mysql_free_result($ubicacion);
?>
