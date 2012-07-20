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
  $updateSQL = sprintf("UPDATE tblsubcategorias SET codigoSubcategoria=%s, nombreSubcategoria=%s, idCategoria=%s, idArea=%s WHERE idSubcategoria=%s",
                       GetSQLValueString($_POST['codigoSubcategoria'], "text"),
                       GetSQLValueString($_POST['nombreSubcategoria'], "text"),
                       GetSQLValueString($_POST['idCategoria'], "int"),
                       GetSQLValueString($_POST['idArea'], "int"),
                       GetSQLValueString($_POST['idSubcategoria'], "int"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($updateSQL, $bdresumen) or die(mysql_error());

  $updateGoTo = "subcategorias.php?p=subcategoriasCont";
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_bdresumen, $bdresumen);
$query_categorias = "SELECT * FROM tblcategoria";
$categorias = mysql_query($query_categorias, $bdresumen) or die(mysql_error());
$row_categorias = mysql_fetch_assoc($categorias);
$totalRows_categorias = mysql_num_rows($categorias);

$colname_subcategorias = "-1";
if (isset($_GET['idSubcategoria'])) {
  $colname_subcategorias = $_GET['idSubcategoria'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_subcategorias = sprintf("SELECT * FROM tblsubcategorias WHERE idSubcategoria = %s", GetSQLValueString($colname_subcategorias, "int"));
$subcategorias = mysql_query($query_subcategorias, $bdresumen) or die(mysql_error());
$row_subcategorias = mysql_fetch_assoc($subcategorias);
$totalRows_subcategorias = mysql_num_rows($subcategorias);

mysql_select_db($database_bdresumen, $bdresumen);
$query_ar = "SELECT * FROM tblareas";
$ar = mysql_query($query_ar, $bdresumen) or die(mysql_error());
$row_ar = mysql_fetch_assoc($ar);
$totalRows_ar = mysql_num_rows($ar);

?>
<div style="margin:20px;">
  <div class="container-fluid" style="margin:auto">
    <div class="row-fluid">
      <div class="span12">
        <div class="well">
          <div class="row-fluid">
          	<img src="img/subcategorias.png" width="50" height="50"><h2>Modificar Programa</h2>
            	<div class="atras"><button class="btn btn-success" onclick='window.location="subcategorias.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
          </div>
          <div class="row-fluid">
            <form name="mscat" id="mscat" class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST">
              <fieldset>
                <legend></legend>
                <div class="control-group">
                  <label class="control-label" for="codigoCategoria">Código</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="codigoSubcategoria" id="codigoSubcategoria" value="<?php echo $row_subcategorias['codigoSubcategoria']; ?>" placeholder="Código del Programa">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="nombreCategoria">Nombre</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="nombreSubcategoria" id="nombreSubcategoria" value="<?php echo $row_subcategorias['nombreSubcategoria']; ?>" placeholder="Nombre del Programa">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="categoria">Postgrado</label>
                  <div class="controls">
                    <select id="categoria" name="idCategoria">
                      <?php
do {  
?>
                      <option value="<?php echo $row_categorias['idCategoria']?>"<?php if (!(strcmp($row_categorias['idCategoria'], $row_subcategorias['idSubcategoria']))) {echo "selected=\"selected\"";} ?>><?php echo $row_categorias['nombreCategoria']?></option>
                      <?php
} while ($row_categorias = mysql_fetch_assoc($categorias));
  $rows = mysql_num_rows($categorias);
  if($rows > 0) {
      mysql_data_seek($categorias, 0);
	  $row_categorias = mysql_fetch_assoc($categorias);
  }
?>
                    </select>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="area">Área</label>
                  <div class="controls">
                    <select id="area" name="idArea">
                      <?php
                      do {  
                      ?>
                      <option value="<?php echo $row_ar['idArea']?>" <?php if (!(strcmp($row_subcategorias['idArea'], $row_ar['idArea']))) {echo "selected=\"selected\"";} ?>><?php echo $row_ar['nombreArea']?></option>
                      <?php
                      } while ($row_ar = mysql_fetch_assoc($ar));
                        $rows = mysql_num_rows($ar);
                        if($rows > 0) {
                            mysql_data_seek($ar, 0);
                          $row_ar = mysql_fetch_assoc($ar);
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-actions">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <button class="btn" type="reset">Limpiar</button>
                </div>
              </fieldset>
              <input name="idSubcategoria" type="hidden" value="<?php echo $_GET['idSubcategoria']; ?>" />
              <input type="hidden" name="MM_update" value="form" />
            </form>
            </div>
        </div>                    
        </div><!--/span-->
      
      </div>
    
    
    
    </div>
</div>

<script>
      		var frmMSCAT = new Validator("mscat");
			
			frmMSCAT.addValidation("codigoSubcategoria","req","Por favor ingrese un Código para el Programa");
			frmMSCAT.addValidation("nombreSubcategoria","req","Por favor ingrese un Nombre para el Programa");

      	</script>
<?php
mysql_free_result($categorias);

mysql_free_result($subcategorias);
?>
