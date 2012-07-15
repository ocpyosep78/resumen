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
  $insertSQL = sprintf("INSERT INTO tblusuario (cedulaUsuario, nombreUsuario, apellidoUsuario, loginUsuario, claveUsuario, statusUsuario) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString(strtoupper($_POST['cedulaUsuario']), "text"),
                       GetSQLValueString($_POST['nombreUsuario'], "text"),
					   GetSQLValueString($_POST['apellidoUsuario'], "text"),
                       GetSQLValueString($_POST['loginUsuario'], "text"),
					   GetSQLValueString(md5($_POST['claveUsuario']), "text"),
                       GetSQLValueString($_POST['statusUsuario'], "text"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($insertSQL, $bdresumen) or die(mysql_error());

  $insertGoTo = "usuarios.php?correcto";
  header(sprintf("Location: %s", $insertGoTo));
}

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
          <h2>Nuevo Usuario</h2>
            	<div class="atras"><button class="btn btn-success" onclick='window.location="usuarios.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
          </div>
          <div class="row-fluid">
            <form name="nusu" id="nusu" class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST">
              <fieldset>
                <legend></legend>
                
                <div class="control-group">
                  <label class="control-label" for="cedulaUsuario">Cédula</label>
                  <div class="controls">
                    <input type="text" class="input" name="cedulaUsuario" id="cedulaUsuario" placeholder="Cédula del Usuario"><br/><span id="muestra">V-12345678</span>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="nombreUsuario">Nombre</label>
                  <div class="controls">
                    <input type="text" class="input" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre del Usuario">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="apellidoUsuario">Apellido</label>
                  <div class="controls">
                    <input type="text" class="input" name="apellidoUsuario" id="apellidoUsuario" placeholder="Apellido del Usuario">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="loginUsuario">Login</label>
                  <div class="controls">
                    <input type="text" class="input" name="loginUsuario" id="loginUsuario" placeholder="Login del Usuario">
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
                        <input type="radio" name="statusUsuario" id="statusUsuario" value="A" checked="checked" />&nbsp;Activo
                      </label>
                      <label class="radio">
                            <input type="radio" name="statusUsuario" id="statusUsuario" value="I" />&nbsp;Inactivo
                      </label>
                    </div>
                  </div>

                <div class="control-group"></div>
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
      		var frmNUSU = new Validator("nusu");
			
			frmNUSU.addValidation("cedulaUsuario","req","Por favor ingrese una Cédula para el Usuario");
			frmNUSU.addValidation("cedulaUsuario","regexp=^[VveE]-[0-9]{6,8}$","Por favor ingrese una Cédula válida para el Usuario");
			
			frmNUSU.addValidation("nombreUsuario","req","Por favor ingrese un Nombre para el Usuario");
			frmNUSU.addValidation("nombreUsuario","alpha_s","Por favor ingrese sólo caracteres alfabéticos");
			frmNUSU.addValidation("nombreUsuario","minlen=2","Por favor ingrese un nombre válido");
			
			frmNUSU.addValidation("apellidoUsuario","req","Por favor ingrese un Apellido para el usuario");
			frmNUSU.addValidation("apellidoUsuario","alpha_s","Por favor ingrese sólo caracteres alfabéticos");
			frmNUSU.addValidation("apellidoUsuario","minlen=2","Por favor ingrese un apellido válido");
			
			frmNUSU.addValidation("loginUsuario","req","Por favor ingrese un Login para el Usuario");
			frmNUSU.addValidation("loginUsuario","minlen=2","Por favor ingrese un login válido");
			
			frmNUSU.addValidation("claveUsuario","req","Por favor ingrese una Clave para el Usuario");
			
			frmNUSU.addValidation("confirmar","eqelmnt=claveUsuario","Las claves no coinciden");
			
      	</script>