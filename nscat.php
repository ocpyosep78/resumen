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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO tblsubcategorias (codigoSubcategoria, nombreSubcategoria, idCategoria) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['codigoSubcategoria'], "text"),
                       GetSQLValueString($_POST['nombreSubcategoria'], "text"),
                       GetSQLValueString($_POST['idCategoria'], "int"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($insertSQL, $bdresumen) or die(mysql_error());

  $insertGoTo = "subcategorias.php?p=subcategoriasCont";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_bdresumen, $bdresumen);
$query_categorias = "SELECT * FROM tblcategoria";
$categorias = mysql_query($query_categorias, $bdresumen) or die(mysql_error());
$row_categorias = mysql_fetch_assoc($categorias);
$totalRows_categorias = mysql_num_rows($categorias);
?>
<div style="margin:20px;">
  <div class="container-fluid" style="margin:auto">
    <div class="row-fluid">
      <div class="span12">
        <div class="well">
          <div class="row-fluid">
          	<img src="img/subcategorias.png" width="50" height="50"><h2>Nuevo Programa</h2>
            	<div class="atras"><button class="btn btn-success" onclick='window.location="subcategorias.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
          </div>
          <div class="row-fluid">
            <form name="nscat" id="nscat" class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST">
              <fieldset>
                <legend></legend>
                <div class="control-group">
                  <label class="control-label" for="codigoCategoria">Código</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="codigoSubcategoria" id="codigoSubategoria" placeholder="Código del Programa">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="nombreCategoria">Nombre</label>
                  <div class="controls">
                    <input type="text" class="input-xlarge" name="nombreSubcategoria" id="nombreSubcategoria" placeholder="Nombre del Programa">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="categoria">Postgrado</label>
                  <div class="controls">
                    <select id="categoria" name="idCategoria">
                      <?php
do {  
?>
                      <option value="<?php echo $row_categorias['idCategoria']?>"><?php echo $row_categorias['nombreCategoria']?></option>
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
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <button class="btn" type="reset">Limpiar</button>
                </div>
              </fieldset>
              <input type="hidden" name="MM_insert" value="form" />
            </form>
            </div>
        </div>                    
        </div><!--/span-->
      
      </div>
    
    
    
    </div>
</div>

<script>
      		var frmNSCAT = new Validator("nscat");
			
			frmNSCAT.addValidation("codigoSubcategoria","req","Por favor ingrese un Código para el Programa");
			frmNSCAT.addValidation("nombreSubcategoria","req","Por favor ingrese un Nombre para el Programa");

      	</script>
        
        
<?php
mysql_free_result($categorias);
?>
