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
	if (empty($_POST['claveUsuario'])) {
//		echo 'Diferente';
		$pass = $_POST['hash'];
	} else {
//		echo 'Diferente';
		$pass = md5($_POST['claveUsuario']);
	}
	//echo $_POST['claveUsuario'];
  $updateSQL = sprintf("UPDATE tblusuario SET nombreUsuario=%s, apellidoUsuario=%s, loginUsuario=%s, claveUsuario=%s, cedulaUsuario=%s, statusUsuario=%s WHERE idUsuario=%s",
                       GetSQLValueString($_POST['nombreUsuario'], "text"),
                       GetSQLValueString($_POST['apellidoUsuario'], "text"),
                       GetSQLValueString($_POST['loginUsuario'], "text"),
                       GetSQLValueString($pass, "text"),
                       GetSQLValueString(strtoupper($_POST['cedulaUsuario']), "text"),
                       GetSQLValueString($_POST['statusUsuario'], "text"),
                       GetSQLValueString($_POST['idUsuario'], "int"));

  mysql_select_db($database_bdresumen, $bdresumen);
  
  
  $Result1 = mysql_query($updateSQL, $bdresumen) or die(mysql_error());
  
  $updateGoTo = "usuarios.php?correcto";
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_usuario = "-1";
if (isset($_GET['idUsuario'])) {
  $colname_usuario = $_GET['idUsuario'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_usuario = sprintf("SELECT * FROM tblusuario WHERE idUsuario = %s", GetSQLValueString($colname_usuario, "int"));
$usuario = mysql_query($query_usuario, $bdresumen) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
?>
<style>
.control-group {
	float:left;
	margin:20px;
}
.control-group:nth-of-type(8) {
	float:none;
}

</style>
<div style="margin:20px;">
  <div class="container-fluid" style="margin:auto">
    <div class="row-fluid">
      <div class="span12">
        <div class="well">
          <div class="row-fluid">
          	<img src="img/usuarios.png" width="50" height="50">
          <h2>Modificar Usuario</h2>
            	<div class="atras"><button class="btn btn-success" onclick='window.location="usuarios.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
          </div>
          <div class="row-fluid">
            <form name="musu" id="musu" class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST">
              <fieldset>
                <legend></legend>
                
                <div class="control-group">
                  <label class="control-label" for="cedulaUsuario">Cédula</label>
                  <div class="controls">
                    <input name="cedulaUsuario" type="text" class="input" id="cedulaUsuario" value="<?php echo $row_usuario['cedulaUsuario']; ?>" placeholder="Cédula del Usuario">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="nombreUsuario">Nombre</label>
                  <div class="controls">
                    <input name="nombreUsuario" type="text" class="input" id="nombreUsuario" value="<?php echo $row_usuario['nombreUsuario']; ?>" placeholder="Nombre del Usuario">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="apellidoUsuario">Apellido</label>
                  <div class="controls">
                    <input name="apellidoUsuario" type="text" class="input" id="apellidoUsuario" value="<?php echo $row_usuario['apellidoUsuario']; ?>" placeholder="Apellido del Usuario">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="loginUsuario">Login</label>
                  <div class="controls">
                    <input name="loginUsuario" type="text" class="input" id="loginUsuario" value="<?php echo $row_usuario['loginUsuario']; ?>" placeholder="Login del Usuario">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="claveUsuario">Clave</label>
                  <div class="controls">
                    <input type="password" class="input" name="claveUsuario" id="claveUsuario" placeholder="Clave del Usuario">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="confirmar">Confirmar Clave</label>
                  <div class="controls">
                    <input type="password" class="input" name="confirmar" id="confirmar" placeholder="Confirme la Clave del Usuario">
                  </div>
                </div>
                  <div class="control-group">
                    <label class="control-label">Status</label>
                    <div class="controls">
                      <label class="radio">
                        <input <?php if (!(strcmp($row_usuario['statusUsuario'],"A"))) {echo "checked=\"checked\"";} ?> type="radio" name="statusUsuario" id="statusUsuario" value="A" />&nbsp;Activo
                      </label>
                      <label class="radio">
                        <input <?php if (!(strcmp($row_usuario['statusUsuario'],"I"))) {echo "checked=\"checked\"";} ?> type="radio" name="statusUsuario" id="statusUsuario" value="I" />&nbsp;Inactivo
                      </label>
                    </div>
                  </div>
                <div class="control-group"></div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <button class="btn" type="reset">Limpiar</button>
                </div>
              </fieldset>
              <input type="hidden" name="idUsuario" value="<?php echo $row_usuario['idUsuario']; ?>" />
              <input type="hidden" name="MM_update" value="form" />
              <input type="hidden" name="hash" value="<?php echo $row_usuario['claveUsuario']; ?>">
            </form>
            </div>
        </div>                    
        </div><!--/span-->
      </div>
    </div>
</div>
		<script>
      var frmMUSU = new Validator("musu");
			
			frmMUSU.addValidation("cedulaUsuario","req","Por favor ingrese una Cédula para el Usuario");
			frmMUSU.addValidation("cedulaUsuario","regexp=^[VveE]-[0-9]{6,8}$","Por favor ingrese una Cédula válida para el Usuario");
			
			frmMUSU.addValidation("nombreUsuario","req","Por favor ingrese un Nombre para el Usuario");
			frmMUSU.addValidation("nombreUsuario","alpha_s","Por favor ingrese sólo caracteres alfabéticos");
			frmMUSU.addValidation("nombreUsuario","minlen=2","Por favor ingrese un nombre válido");
			
			frmMUSU.addValidation("apellidoUsuario","req","Por favor ingrese un Apellido para el usuario");
			frmMUSU.addValidation("apellidoUsuario","alpha_s","Por favor ingrese sólo caracteres alfabéticos");
			frmMUSU.addValidation("apellidoUsuario","minlen=2","Por favor ingrese un apellido válido");
			
			frmMUSU.addValidation("loginUsuario","req","Por favor ingrese un Login para el Usuario");
			frmMUSU.addValidation("loginUsuario","minlen=2","Por favor ingrese un login válido");
			
			//frmMUSU.addValidation("claveUsuario","req","Por favor ingrese una Clave para el Usuario");
			
			//frmMUSU.addValidation("confirmar","eqelmnt=claveUsuario","Las claves no coinciden");
			
      	</script>
        
<?php
mysql_free_result($usuario);
?>
