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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tblpermisos SET modUsuario=%s, agregarUsuario=%s, modificarUsuario=%s, eliminarUsuario=%s, modTutores=%s, agregarTutores=%s, modificarTutores=%s, eliminarTutores=%s, modCategorias=%s, agregarCategorias=%s, modificarCategorias=%s, eliminarCategorias=%s, modSubcategorias=%s, agregarSubcategorias=%s, modificarSubcategorias=%s, eliminarSubcategorias=%s, modResumen=%s, agregarResumen=%s, modificarResumen=%s, eliminarResumen=%s, modUbicaciones=%s, agregarUbicaciones=%s, modificarUbicaciones=%s, eliminarUbicaciones=%s, modArea=%s, agregarArea=%s, modificarArea=%s, eliminarArea=%s WHERE idUsuario=%s",
                       GetSQLValueString(isset($_POST['modUsuario']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarUsuario']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarUsuario']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarUsuario']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modTutores']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarTutores']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarTutores']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarTutores']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modCategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarCategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarCategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarCategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modSubcategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarSubcategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarSubcategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarSubcategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modResumen']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarResumen']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarResumen']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarResumen']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modUbicaciones']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarUbicaciones']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarUbicaciones']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarUbicaciones']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modArea']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarArea']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarArea']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarArea']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['idUsuario'], "int"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($updateSQL, $bdresumen) or die(mysql_error());

  $updateGoTo = "usuarios.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tblpermisos (idPermisos, idUsuario, modUsuario, agregarUsuario, modificarUsuario, eliminarUsuario, modTutores, agregarTutores, modificarTutores, eliminarTutores, modCategorias, agregarCategorias, modificarCategorias, eliminarCategorias, modSubcategorias, agregarSubcategorias, modificarSubcategorias, eliminarSubcategorias, modResumen, agregarResumen, modificarResumen, eliminarResumen, modUbicaciones, agregarUbicaciones, modificarUbicaciones, eliminarUbicaciones, modArea, agregarArea, modificarArea, eliminarArea) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['idPermisos'], "int"),
                       GetSQLValueString($_POST['idUsuario'], "int"),
                       GetSQLValueString(isset($_POST['modUsuario']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarUsuario']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarUsuario']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarUsuario']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modTutores']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarTutores']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarTutores']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarTutores']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modCategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarCategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarCategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarCategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modSubcategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarSubcategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarSubcategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarSubcategorias']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modResumen']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarResumen']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarResumen']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarResumen']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modUbicaciones']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarUbicaciones']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarUbicaciones']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarUbicaciones']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modArea']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['agregarArea']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['modificarArea']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['eliminarArea']) ? "true" : "", "defined","'Y'","'N'"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($insertSQL, $bdresumen) or die(mysql_error());

  $insertGoTo = "usuarios.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_permisos = "-1";
if (isset($_GET['idUsuario'])) {
  $colname_permisos = $_GET['idUsuario'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_permisos = sprintf("SELECT * FROM tblpermisos WHERE idUsuario = %s", GetSQLValueString($colname_permisos, "int"));
$permisos = mysql_query($query_permisos, $bdresumen) or die(mysql_error());
$row_permisos = mysql_fetch_assoc($permisos);
$totalRows_permisos = mysql_num_rows($permisos);
if($totalRows_permisos == 0){
	$vartype = "MM_insert";
} else {
	$vartype = "MM_update";
}
?>
<?php require_once("cop.php") ?>


<div style="margin:20px;">
<div class="container-fluid" style="margin:auto">
	<div class="row-fluid">
        <div class="span12">
          <div class="well">
            <!--img src="img/1330457085_search_green.png" width="50" height="50"--><h2>Menú Principal</h2>
                <div class="row-fluid">
                	<?php require_once('menuBk2.php');?>
                </div>
          </div>                    
        </div><!--/span-->
        
        <div class="span12">
          <div class="well">
				<h2>Permisos del Usuario: </h2>
                <div class="atras"><button class="btn btn-success" onclick='window.location="usuarios.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
				<div class="row-fluid">
                
                <div class="controls">
                  <label class="checkbox">
                    <input id="checkAll" onclick="checkTodos(this.id,'form1');" name="checkAll" type="checkbox"/>                    Seleccionar Todos
                  </label>
                </div>
                
                
                  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
                    <table width="45%" style="display:inline-block;">
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Ver Tutores:</td>
                        <td><input type="checkbox" name="modTutores" <?php if (!(strcmp(htmlentities($row_permisos['modTutores'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Agregar Tutores:</td>
                        <td><input type="checkbox" name="agregarTutores" <?php if (!(strcmp(htmlentities($row_permisos['agregarTutores'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Modificar Tutores:</td>
                        <td><input type="checkbox" name="modificarTutores" <?php if (!(strcmp(htmlentities($row_permisos['modificarTutores'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Eliminar Tutores:</td>
                        <td><input type="checkbox" name="eliminarTutores" <?php if (!(strcmp(htmlentities($row_permisos['eliminarTutores'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Ver Postgrados:</td>
                        <td><input type="checkbox" name="modCategorias" <?php if (!(strcmp(htmlentities($row_permisos['modCategorias'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Agregar Postgrados:</td>
                        <td><input type="checkbox" name="agregarCategorias" <?php if (!(strcmp(htmlentities($row_permisos['agregarCategorias'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Modificar Postgrados:</td>
                        <td><input type="checkbox" name="modificarCategorias" <?php if (!(strcmp(htmlentities($row_permisos['modificarCategorias'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Eliminar Postgrados:</td>
                        <td><input type="checkbox" name="eliminarCategorias" <?php if (!(strcmp(htmlentities($row_permisos['eliminarCategorias'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Ver Programas:</td>
                        <td><input type="checkbox" name="modSubcategorias" <?php if (!(strcmp(htmlentities($row_permisos['modSubcategorias'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Agregar Programas:</td>
                        <td><input type="checkbox" name="agregarSubcategorias" <?php if (!(strcmp(htmlentities($row_permisos['agregarSubcategorias'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Modificar Programas:</td>
                        <td><input type="checkbox" name="modificarSubcategorias" <?php if (!(strcmp(htmlentities($row_permisos['modificarSubcategorias'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Eliminar Programas:</td>
                        <td><input type="checkbox" name="eliminarSubcategorias" <?php if (!(strcmp(htmlentities($row_permisos['eliminarSubcategorias'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      </table>
                      
                      <table width="45%" style="display:inline-block;">
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Ver Ubicaciones:</td>
                        <td><input type="checkbox" name="modUbicaciones" <?php if (!(strcmp(htmlentities($row_permisos['modUbicaciones'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Agregar Ubicaciones:</td>
                        <td><input type="checkbox" name="agregarUbicaciones" <?php if (!(strcmp(htmlentities($row_permisos['agregarUbicaciones'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Modificar Ubicaciones:</td>
                        <td><input type="checkbox" name="modificarUbicaciones" <?php if (!(strcmp(htmlentities($row_permisos['modificarUbicaciones'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Eliminar Ubicaciones:</td>
                        <td><input type="checkbox" name="eliminarUbicaciones" <?php if (!(strcmp(htmlentities($row_permisos['eliminarUbicaciones'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Ver Usuarios:</td>
                        <td><input type="checkbox" name="modUsuario" <?php if (!(strcmp(htmlentities($row_permisos['modUsuario'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Agregar Usuarios:</td>
                        <td><input type="checkbox" name="agregarUsuario" <?php if (!(strcmp(htmlentities($row_permisos['agregarUsuario'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Modificar Usuarios:</td>
                        <td><input type="checkbox" name="modificarUsuario" <?php if (!(strcmp(htmlentities($row_permisos['modificarUsuario'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Eliminar Usuarios:</td>
                        <td><input type="checkbox" name="eliminarUsuario" <?php if (!(strcmp(htmlentities($row_permisos['eliminarUsuario'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      
                      
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Ver Resúmenes:</td>
                        <td><input type="checkbox" name="modResumen" <?php if (!(strcmp(htmlentities($row_permisos['modResumen'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Agregar Resúmenes:</td>
                        <td><input type="checkbox" name="agregarResumen" <?php if (!(strcmp(htmlentities($row_permisos['agregarResumen'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Modificar Resúmenes:</td>
                        <td><input type="checkbox" name="modificarResumen" <?php if (!(strcmp(htmlentities($row_permisos['modificarResumen'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Eliminar Resúmenes:</td>
                        <td><input type="checkbox" name="eliminarResumen" <?php if (!(strcmp(htmlentities($row_permisos['eliminarResumen'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>

                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Ver Áreas:</td>
                        <td><input type="checkbox" name="modArea" <?php if (!(strcmp(htmlentities($row_permisos['modArea'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Agregar Áreas:</td>
                        <td><input type="checkbox" name="agregarArea" <?php if (!(strcmp(htmlentities($row_permisos['agregarArea'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Modificar Áreas:</td>
                        <td><input type="checkbox" name="modificarArea" <?php if (!(strcmp(htmlentities($row_permisos['modificarArea'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap="nowrap" align="right">Eliminar Áreas:</td>
                        <td><input type="checkbox" name="eliminarArea" <?php if (!(strcmp(htmlentities($row_permisos['eliminarArea'], ENT_COMPAT, ''),"Y"))) {echo "checked=\"checked\"";} ?> /></td>
                      </tr>

                    </table>
                    <div class="control-group"></div>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-primary">Guardar</button>
                      <button class="btn" type="reset">Limpiar</button>
                    </div>
                    <input type="hidden" name="<?php echo $vartype; ?>" value="form1" />
                    <input type="hidden" name="idUsuario" value="<?php echo $_GET['idUsuario']; ?>" />
                  </form>
                  <p>&nbsp;</p>
                </div>
                
          </div>                    
        </div><!--/span-->
      </div>
</div>
<?php
mysql_free_result($permisos);
?>
