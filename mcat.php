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
  $updateSQL = sprintf("UPDATE tblcategoria SET codigoCategoria=%s, nombreCategoria=%s WHERE idCategoria=%s",
                       GetSQLValueString($_POST['codigoCategoria'], "text"),
                       GetSQLValueString($_POST['nombreCategoria'], "text"),
                       GetSQLValueString($_POST['idCategoria'], "int"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($updateSQL, $bdresumen) or die(mysql_error());

  $updateGoTo = "categorias.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_categoria = "-1";
if (isset($_GET['idCategoria'])) {
  $colname_categoria = $_GET['idCategoria'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_categoria = sprintf("SELECT * FROM tblcategoria WHERE idCategoria = %s", GetSQLValueString($colname_categoria, "int"));
$categoria = mysql_query($query_categoria, $bdresumen) or die(mysql_error());
$row_categoria = mysql_fetch_assoc($categoria);
$totalRows_categoria = mysql_num_rows($categoria);
 extract($_GET);?>
<div style="margin:20px;">
<div class="container-fluid" style="margin:auto">
    <div class="row-fluid">
      <div class="span12">
        <div class="well">
          <div class="row-fluid">
          	<img src="img/categorias.png" width="50" height="50"><h2>Modificar Postgrado</h2>
           	<div class="atras"><button class="btn btn-success" onclick='window.location="categorias.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
          </div>
                <div class="row-fluid">
                    <form name="mcat" id="mcat" class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST">
                    <fieldset>
                      <legend></legend>
                      <div class="control-group">
                        <label class="control-label" for="codigoCategoria">Código</label>
                        <div class="controls">
                          <input type="text" class="input-xlarge" name="codigoCategoria" id="codigoCategoria" value="<?php echo $row_categoria['codigoCategoria']; ?>" placeholder="Código del Postgrado">
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label" for="nombreCategoria">Nombre</label>
                        <div class="controls">
                          <input type="text" class="input-xlarge" name="nombreCategoria" id="nombreCategoria" value="<?php echo $row_categoria['nombreCategoria']; ?>" placeholder="Nombre del Postgrado">
                        </div>
                      </div>
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Modificar</button>
                        <button class="btn" type="reset">Limpiar</button>
                      </div>
                    </fieldset>
                    <input type="hidden" name="idCategoria" value="<?php if (isset($idCategoria)) { echo $idCategoria; }?>">
                    <input type="hidden" name="MM_update" value="form" />
                  </form>
              </div>
          </div>                    
        </div><!--/span-->
        
  		<script>
      		var frmMCAT = new Validator("mcat");
			
			frmMCAT.addValidation("codigoCategoria","req","Por favor ingrese un Código para el Postgrado");
			frmMCAT.addValidation("nombreCategoria","req","Por favor ingrese un Nombre para el Postgrado");

      	</script>
      
      
      
      </div>
</div>
<?php
mysql_free_result($categoria);
?>
