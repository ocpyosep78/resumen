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
  $updateSQL = sprintf("UPDATE tbltutores SET cedulaTutor=%s, nombreTutor=%s, apellidoTutor=%s, profesionTutor=%s, postgradoTutor=%s, telfTutor=%s, emailTutor=%s, statusTutor=%s WHERE idTutor=%s",
                       GetSQLValueString(strtoupper($_POST['cedulaTutor']), "text"),
                       GetSQLValueString($_POST['nombreTutor'], "text"),
                       GetSQLValueString($_POST['apellidoTutor'], "text"),
                       GetSQLValueString($_POST['profesionTutor'], "text"),
                       GetSQLValueString($_POST['postgradoTutor'], "text"),
                       GetSQLValueString($_POST['telfTutor'], "text"),
                       GetSQLValueString($_POST['emailTutor'], "text"),
                       GetSQLValueString($_POST['statusTutor'], "text"),
                       GetSQLValueString($_POST['idTutor'], "int"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($updateSQL, $bdresumen) or die(mysql_error());

  $updateGoTo = "tutores.php";
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_constutor = "-1";
if (isset($_GET['idTutor'])) {
  $colname_constutor = $_GET['idTutor'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_constutor = sprintf("SELECT * FROM tbltutores WHERE idTutor = %s", GetSQLValueString($colname_constutor, "int"));
$constutor = mysql_query($query_constutor, $bdresumen) or die(mysql_error());
$row_constutor = mysql_fetch_assoc($constutor);
$totalRows_constutor = mysql_num_rows($constutor);
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
          	<img src="img/tutores.png" width="50" height="50"><h2>Modificar Tutor</h2>
           	<div class="atras"><button class="btn btn-success" onclick='window.location="tutores.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
          </div>
          <div class="row-fluid">
            <form name="mtut" id="mtut" class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST">
              <fieldset>
                <legend></legend>
                
                <div class="control-group">
                  <label class="control-label" for="cedulaTutor">Cédula</label>
                  <div class="controls">
                    <input name="cedulaTutor" type="text" class="input" id="cedulaTutor" value="<?php echo $row_constutor['cedulaTutor']; ?>" placeholder="Cédula del Tutor"><br/><span id="muestra">V-12345678</span>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="nombreTutor">Nombre</label>
                  <div class="controls">
                    <input name="nombreTutor" type="text" class="input" id="nombreTutor" value="<?php echo $row_constutor['nombreTutor']; ?>" placeholder="Nombre del Tutor">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="apellidoTutor">Apellido</label>
                  <div class="controls">
                    <input name="apellidoTutor" type="text" class="input" id="apellidoTutor" value="<?php echo $row_constutor['apellidoTutor']; ?>" placeholder="Apellido del Tutor">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="profesionTutor">Profesión</label>
                  <div class="controls">
                    <input name="profesionTutor" type="text" class="input" id="profesionTutor" value="<?php echo $row_constutor['profesionTutor']; ?>" placeholder="Profesión del Tutor">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="postgradoTutor">Postgrado</label>
                  <div class="controls">
                    <input name="postgradoTutor" type="text" class="input" id="postgradoTutor" value="<?php echo $row_constutor['postgradoTutor']; ?>" placeholder="Postgrado del Tutor">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="telfTutor">Teléfono</label>
                  <div class="controls">
                    <input name="telfTutor" type="text" class="input" id="telfTutor" value="<?php echo $row_constutor['telfTutor']; ?>" placeholder="Teléfono del Tutor"><br/><span id="muestra">(1234)5678901</span>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="emailTutor">Email</label>
                  <div class="controls">
                    <input name="emailTutor" type="text" class="input" id="emailTutor" value="<?php echo $row_constutor['emailTutor']; ?>" placeholder="Email del Tutor">
                  </div>
                </div>

                
                <div class="control-group">
                </div>
               
                <div class="control-group">
                  <label class="control-label">Status</label>
                  <div class="controls">
                    <label class="radio">
                      <input <?php if (!(strcmp($row_constutor['statusTutor'],"A"))) {echo "checked=\"checked\"";} ?> type="radio" name="statusTutor" id="statusTutor" value="A" />&nbsp;Activo
                      </label>
                    <label class="radio">
                      <input <?php if (!(strcmp($row_constutor['statusTutor'],"I"))) {echo "checked=\"checked\"";} ?> type="radio" name="statusTutor" id="statusTutor" value="I" />&nbsp;Inactivo
                    </label>
                  </div>
                </div>
              </fieldset>
                
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <button class="btn" type="reset">Limpiar</button>
                </div>
              <input type="hidden" name="idTutor" value="<?php echo $_GET['idTutor']; ?>" />
              <input type="hidden" name="MM_update" value="form" />
            </form>
            </div>
        </div>                    
        </div><!--/span-->
      </div>
    </div>
</div>

<script>
		
		
		
		/*

^[VE]-[0-9]{6,8}$ Cédula

^\([0-9]{4}\)[0-9]{7}$ Teléf
                    
                    
                    
                    */
      		var frmMTUT = new Validator("mtut");
			
			frmMTUT.addValidation("cedulaTutor","req","Por favor ingrese una Cédula para el Tutor");
			frmMTUT.addValidation("cedulaTutor","regexp=^[VveE]-[0-9]{6,8}$","Por favor ingrese una Cédula válida para el Tutor");
			
			frmMTUT.addValidation("nombreTutor","req","Por favor ingrese un Nombre para el Tutor");
			frmMTUT.addValidation("nombreTutor","alpha_s","Por favor ingrese sólo caracteres alfabéticos");
			frmMTUT.addValidation("nombreTutor","minlen=2","Por favor ingrese un nombre válido");
			
			frmMTUT.addValidation("apellidoTutor","req","Por favor ingrese un Apellido para el Tutor");
			frmMTUT.addValidation("apellidoTutor","alpha_s","Por favor ingrese sólo caracteres alfabéticos");
			frmMTUT.addValidation("apellidoTutor","minlen=2","Por favor ingrese un apellido válido");
			
			frmMTUT.addValidation("profesionTutor","req","Por favor ingrese una Profesión para el Tutor");
			frmMTUT.addValidation("profesionTutor","minlen=2","Por favor ingrese una profesión válida");
			
			frmMTUT.addValidation("telfTutor","req","Por favor ingrese un Número de Teléfono para el Tutor");
			frmMTUT.addValidation("telfTutor","regexp=^\([0-9]{4}\)[0-9]{7}$","Por favor ingrese un número de teléfono válido");
			
			frmMTUT.addValidation("emailTutor","req","Por favor ingrese un Correo Electrónico para el Tutor");
			frmMTUT.addValidation("emailTutor","email","Por favor ingrese un email válido");
			

      	</script>


<?php
mysql_free_result($constutor);
?>
