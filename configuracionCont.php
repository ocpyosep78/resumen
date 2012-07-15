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
  $updateSQL = sprintf("UPDATE tblconfiguraciones SET dias_actConfiguraciones=%s",
                       GetSQLValueString($_POST['dias_actConfiguraciones'], "int"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($updateSQL, $bdresumen) or die(mysql_error());

  $updateGoTo = "backend.php";
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_configuracion = "-1";
if (isset($_GET['idconfiguracion'])) {
  $colname_configuracion = $_GET['idconfiguracion'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_configuracion = "SELECT * FROM tblconfiguraciones";
$configuracion = mysql_query($query_configuracion, $bdresumen) or die(mysql_error());
$row_configuracion = mysql_fetch_assoc($configuracion);
$totalRows_configuracion = mysql_num_rows($configuracion);
extract($_GET);?>

<div style="margin:20px;">
<div class="container-fluid" style="margin:auto">
    <div class="row-fluid">
      <div class="span12">
        <div class="well">
            <div class="row-fluid">
              <img src="img/configuraciones.png" width="50" height="50"><h2>Modificar Configuración</h2>
              <div class="atras"><button class="btn btn-success" onclick='window.location="backend.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
            </div>
                <div class="row-fluid">
                    <form name="mubi" id="mubi" class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST">
                    <fieldset>
                      <legend></legend>
                      <div class="control-group">
                        <label class="control-label" for="dias_actConfiguraciones">Días de Actividad</label>
                        <div class="controls">
                          <input type="text" class="input span1" name="dias_actConfiguraciones" id="dias_actConfiguraciones" value="<?php echo $row_configuracion['dias_actConfiguraciones']; ?>" placeholder="Cantidad de días activos para modificación">
                        </div>
                      </div>
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Modificar</button>
                        <button class="btn" type="reset">Limpiar</button>
                      </div>
                    </fieldset>
                    <input type="hidden" name="MM_update" value="form" />
                  </form>
              </div>
          </div>                    
        </div><!--/span-->
        
      
      </div>
</div>
    <script>
      var frmMUBI = new Validator("mubi");
      frmMUBI.addValidation("dias_actConfiguraciones","req","Por favor ingrese un Número");
      frmMUBI.addValidation("dias_actConfiguraciones","num","Por favor ingrese un Número");
      frmMUBI.addValidation("dias_actConfiguraciones","gt=1","El Número debe ser mayor a 1");
    </script>
        
<?php
mysql_free_result($configuracion);
?>
