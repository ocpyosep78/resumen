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
	if ((!empty($_FILES["archivoResumen"]["name"])) && ($_FILES["archivoResumen"]["name"] <> $_POST['archivoResumen'])) {
		$val = explode(".",$_FILES["archivoResumen"]["name"]);
		$ext = $val[1];
		if ($ext == "pdf") {
			if ($_FILES["archivoResumen"]["error"] > 0) {
				$errorf = "<div class='alert alert-error'>Error al subir Archivo: " . $_FILES["archivoResumen"]["error"]."</div>";
			} else {
			  if (!file_exists("uploads/" . $_FILES["archivoResumen"]["name"])) {
					unlink("uploads/" . $_POST["archivoResumen2"]);
					move_uploaded_file($_FILES["archivoResumen"]["tmp_name"],"uploads/" . $_FILES["archivoResumen"]["name"]);
					$updateSQL = sprintf("UPDATE tblresumen SET codigoResumen = %s, anoResumen = %s, idUbicacion = %s, tituloResumen = %s, textoResumen = %s, archivoResumen = %s, autoresResumen = %s, idCategoria = %s, idSubcategoria = %s, idTutor = %s WHERE idResumen = %s", GetSQLValueString($_POST['codigoResumen'], "int"),
						   GetSQLValueString($_POST['anoResumen'], "text"),
						   GetSQLValueString($_POST['idUbicacion'], "int"),
						   GetSQLValueString($_POST['tituloResumen'], "text"),
						   GetSQLValueString($_POST['textoResumen'], "text"),
						   GetSQLValueString($_FILES["archivoResumen"]["name"], "text"),
						   GetSQLValueString($_POST['autoresResumen'], "text"),
						   GetSQLValueString($_POST['idCategoria'], "int"),
						   GetSQLValueString($_POST['idSubcategoria'], "int"),
						   GetSQLValueString($_POST['idTutor'], "int"),
						   GetSQLValueString($_POST['idResumen'], "int"));
		
		
					  mysql_select_db($database_bdresumen, $bdresumen);
					  $Result1 = mysql_query($updateSQL, $bdresumen) or die(mysql_error());
		
					  $updateGoTo = "resumen.php";
					  header(sprintf("Location: %s", $updateGoTo));
		
				} else {
				  $errorf = "<div class='alert alert-error'><h3>Error:</h3>Ya existe un archivo con éste nombre</div>";
				}
		  }
		} else {
			$errorf = "<div class='alert alert-error'><h3>Error:</h3>Archivo Inválido</div>";
		}
	} else {
		
		$updateSQL = sprintf("UPDATE tblresumen SET codigoResumen = %s, anoResumen = %s, idUbicacion = %s, tituloResumen = %s, textoResumen = %s, autoresResumen = %s, idSubcategoria = %s, idTutor = %s WHERE idResumen = %s", GetSQLValueString($_POST['codigoResumen'], "text"),
						   GetSQLValueString($_POST['anoResumen'], "text"),
						   GetSQLValueString($_POST['idUbicacion'], "int"),
						   GetSQLValueString($_POST['tituloResumen'], "text"),
						   GetSQLValueString($_POST['textoResumen'], "text"),
						   GetSQLValueString($_POST['autoresResumen'], "text"),
						   GetSQLValueString($_POST['idSubcategoria'], "int"),
						   GetSQLValueString($_POST['idTutor'], "int"),
						   GetSQLValueString($_POST['idResumen'], "int"));
		
		
					  mysql_select_db($database_bdresumen, $bdresumen);
					  $Result1 = mysql_query($updateSQL, $bdresumen) or die(mysql_error());
		
					  $updateGoTo = "resumen.php";
					  header(sprintf("Location: %s", $updateGoTo));
	
	}
}

mysql_select_db($database_bdresumen, $bdresumen);
$query_resumenes = "SELECT * FROM tblresumen WHERE idResumen = '".$_GET['idResumen']."'";
$resumenes = mysql_query($query_resumenes, $bdresumen) or die(mysql_error());
$row_resumenes = mysql_fetch_assoc($resumenes);
$totalRows_resumenes = mysql_num_rows($resumenes);

mysql_select_db($database_bdresumen, $bdresumen);
$query_ubicaciones = "SELECT * FROM tblubicaciones";
$ubicaciones = mysql_query($query_ubicaciones, $bdresumen) or die(mysql_error());
$row_ubicaciones = mysql_fetch_assoc($ubicaciones);
$totalRows_ubicaciones = mysql_num_rows($ubicaciones);

mysql_select_db($database_bdresumen, $bdresumen);
$query_tutores = "SELECT * FROM tbltutores";
$tutores = mysql_query($query_tutores, $bdresumen) or die(mysql_error());
$row_tutores = mysql_fetch_assoc($tutores);
$totalRows_tutores = mysql_num_rows($tutores);

mysql_select_db($database_bdresumen, $bdresumen);
$query_subcategorias = "SELECT * FROM tblsubcategorias";
$subcategorias = mysql_query($query_subcategorias, $bdresumen) or die(mysql_error());
$row_subcategorias = mysql_fetch_assoc($subcategorias);
$totalRows_subcategorias = mysql_num_rows($subcategorias);

mysql_select_db($database_bdresumen, $bdresumen);
$query_categorias = "SELECT * FROM tblcategoria";
$categorias = mysql_query($query_categorias, $bdresumen) or die(mysql_error());
$row_categorias = mysql_fetch_assoc($categorias);
$totalRows_categorias = mysql_num_rows($categorias);

?>
<style>
.control-group {
	float:left;
	margin:20px;
}
.control-group:nth-of-type(11) {
	float:none;
}
</style>
<div style="margin:20px;">
<div class="container-fluid" style="margin:auto">
    <div class="row-fluid">
      <div class="span12">
        <div class="well">
        	<div class="row-fluid">
          		<img src="img/resumen.png" width="50" height="50"><h2>Modificar Resumen</h2>
           		<div class="atras"><button class="btn btn-success" onclick='window.location="resumen.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
          	</div>
                <div class="row-fluid">
                    <form name="mres" id="mres" class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data">

                      <legend></legend>

                      <div class="control-group">
                  <label class="control-label" for="idCategoria">Postgrado</label>
                  <div class="controls">
                    

                    <select id="idCategoria" name="idCategoria">
                      <?php
                      do {  
                      ?>
                      <option value="<?php echo $row_categorias['idCategoria']?>"<?php if (!(strcmp($row_categorias['idCategoria'], $row_subcategorias['idCategoria']))) {echo "selected=\"selected\"";} ?>><?php echo $row_categorias['nombreCategoria']?></option>
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
                  <label class="control-label" for="idSubcategoria">Programa</label>
                  <div class="controls">

                  <select id="idSubcategoria" name="idSubcategoria">
                      <?php
                      do {  
                      ?>
                      <option value="<?php echo $row_subcategorias['idSubcategoria']?>"<?php if (!(strcmp($row_subcategorias['idSubcategoria'], $row_resumenes['idSubcategoria']))) {echo "selected=\"selected\"";} ?>><?php echo $row_subcategorias['nombreSubcategoria']?></option>
                      <?php
                      } while ($row_subcategorias = mysql_fetch_assoc($subcategorias));
                        $rows = mysql_num_rows($subcategorias);
                        if($rows > 0) {
                            mysql_data_seek($subcategorias, 0);
                          $row_subcategorias = mysql_fetch_assoc($subcategorias);
                        }
                      ?>
                    </select>

                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="codigoResumen">Código</label>
                  <div class="controls">
                    <input type="text" class="input" name="codigoResumen" id="codigoResumen" placeholder="Código del Resumen" value="<?php echo $row_resumenes['codigoResumen']; ?>" readonly>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="anoResumen">Año</label>
                  <div class="controls">
                    <input type="text" class="input" name="anoResumen" id="anoResumen" placeholder="Año del Resumen" value="<?php echo $row_resumenes['anoResumen']; ?>">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="idUbicacion">Ubicación</label>
                  <div class="controls">
                    <select id="idUbicacion" name="idUbicacion">
                      <?php
                      do {  
                      ?>
                      <option value="<?php echo $row_ubicaciones['idUbicacion']?>"><?php echo $row_ubicaciones['nombreUbicacion']?></option>
                      <?php
                      } while ($row_ubicaciones = mysql_fetch_assoc($ubicaciones));
                        $rows = mysql_num_rows($ubicaciones);
                        if($rows > 0) {
                            mysql_data_seek($ubicaciones, 0);
                          $row_ubicaciones = mysql_fetch_assoc($ubicaciones);
                        }
                      ?>
                    </select>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="tituloResumen">Título del Resumen</label>
                  <div class="controls">
                    <input type="text" class="input" name="tituloResumen" id="tituloResumen" placeholder="Título del Resumen" value="<?php echo $row_resumenes['tituloResumen']; ?>">
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="textoResumen">Texto del Resumen</label>
                  <div class="controls">
                    <div>
                      <textarea name="textoResumen"><?php echo $row_resumenes['textoResumen']; ?></textarea>
                    </div>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="autoresResumen">Autores</label>
                  <div class="controls">
                    <input type="text" class="input" name="autoresResumen" id="autoresResumen" placeholder="Autores" value="<?php echo $row_resumenes['autoresResumen']; ?>">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="idTutor">Tutor</label>
                  <div class="controls">

                    <select id="idTutor" name="idTutor">
                      <?php
                      do {  
                      ?>
                      <option value="<?php echo $row_tutores['idTutor']?>"<?php if (!(strcmp($row_tutores['idTutor'], $row_resumenes['idTutor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_tutores['nombreTutor']?> <?php echo $row_tutores['apellidoTutor']?> - <?php echo $row_tutores['cedulaTutor']?></option>
                      <?php
                      } while ($row_tutores = mysql_fetch_assoc($tutores));
                        $rows = mysql_num_rows($tutores);
                        if($rows > 0) {
                            mysql_data_seek($tutores, 0);
                          $row_tutores = mysql_fetch_assoc($tutores);
                        }
                      ?>
                    </select>


                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="archivoResumen">Archivo</label>
                  <div class="controls">
                    <input type="file" name="archivoResumen" id="archivoResumen" >
                    &nbsp;&nbsp;&nbsp;=====>&nbsp;&nbsp;&nbsp;uploads/<?php echo $row_resumenes['archivoResumen']; ?>
                  </div>
                  <?php if (isset($errorf)) {
                    echo "<div class='span3'>".$errorf."</div>";
                  } ?>
                </div>


                <div class="control-group">
                </div>
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button class="btn" type="reset">Limpiar</button>
                      </div>

                    <input type="hidden" name="MM_update" value="form">
                    <input type="hidden" name="idResumen" value="<?php echo $row_resumenes['idResumen']; ?>">
                    <input type="hidden" name="archivoResumen2" value="<?php echo $row_resumenes['archivoResumen']; ?>">
                  </form>
              </div>
          </div>                    
        </div><!--/span-->
      </div>
</div>
		<script>
      		var frmMRES = new Validator("mres");
			
			frmMRES.addValidation("codigoResumen","req","Por favor ingrese un Código para el Resumen");
			
			frmMRES.addValidation("anoResumen","req","Por favor ingrese un Año para el Resumen");
			frmMRES.addValidation("anoResumen","num","Por favor ingrese sólo caracteres numéricos");
			frmMRES.addValidation("anoResumen","minlen=4","Por favor ingrese cuatro (4) números");
			frmMRES.addValidation("anoResumen","maxlen=4","Por favor ingrese cuatro (4) números");
			
			frmMRES.addValidation("tituloResumen","req","Por favor ingrese un Título para el Resumen");
			frmMRES.addValidation("textoResumen","req","Por favor ingrese un Texto para el Resumen");
			frmMRES.addValidation("autoresResumen","req","Por favor ingrese un Texto para el Resumen");
			/*frmMRES.addValidation("archivoResumen","req","Por favor seleccione un archivo para el Resumen");*/
						
      	</script>
