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
  $insertSQL = sprintf("INSERT INTO tblcategoria (codigoCategoria, nombreCategoria) VALUES (%s, %s)",
                       GetSQLValueString($_POST['codigoCategoria'], "text"),
                       GetSQLValueString($_POST['nombreCategoria'], "text"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($insertSQL, $bdresumen) or die(mysql_error());

  $insertGoTo = "categorias.php?p=categoriasCont";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $insertGoTo));
}
?>

<div style="margin:20px;">
<div class="container-fluid" style="margin:auto">
    <div class="row-fluid">
      <div class="span12">
        <div class="well">          
          <div class="row-fluid">
          	<img src="img/categorias.png" width="50" height="50"><h2>Nuevo Postgrado</h2>
           	<div class="atras"><button class="btn btn-success" onclick='window.location="categorias.php?p=categoriasCont"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
          </div>
                <div class="row-fluid">
                    <form name="ncat" id="ncat" class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST">
                    <fieldset>
                      <legend></legend>
                      <div class="control-group">
                        <label class="control-label" for="codigoCategoria">Código</label>
                        <div class="controls">
                          <input type="text" class="input-xlarge" name="codigoCategoria" id="codigoCategoria" placeholder="Código del Postgrado">
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label" for="nombreCategoria">Nombre</label>
                        <div class="controls">
                          <input type="text" class="input-xlarge" name="nombreCategoria" id="nombreCategoria" placeholder="Nombre del Postgrado">
                        </div>
                      </div>
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button class="btn" type="reset">Limpiar</button>
                      </div>
                    </fieldset>
                    <input type="hidden" name="MM_insert" value="form">
                  </form>
              </div>
          </div>                    
        </div><!--/span-->
        
      <script>
      	var frmNCAT = new Validator("ncat");
			
			frmNCAT.addValidation("codigoCategoria","req","Por favor ingrese un Código para Postgrado");
			frmNCAT.addValidation("nombreCategoria","req","Por favor ingrese un Nombre para Postgrado");

      </script>
      
      </div>
</div>
