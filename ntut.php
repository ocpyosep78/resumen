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
  $insertSQL = sprintf("INSERT INTO tbltutores (cedulaTutor, nombreTutor, apellidoTutor, profesionTutor, postgradoTutor, telfTutor, emailTutor) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString(strtoupper($_POST['cedulaTutor']), "text"),
                       GetSQLValueString($_POST['nombreTutor'], "text"),
					   GetSQLValueString($_POST['apellidoTutor'], "text"),
                       GetSQLValueString($_POST['profesionTutor'], "text"),
					   GetSQLValueString($_POST['postgradoTutor'], "text"),
                       GetSQLValueString($_POST['telfTutor'], "text"),
                       GetSQLValueString($_POST['emailTutor'], "text"));

  mysql_select_db($database_bdresumen, $bdresumen);
  $Result1 = mysql_query($insertSQL, $bdresumen) or die(mysql_error());

  $insertGoTo = "tutores.php?";
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
          	<img src="img/tutores.png" width="50" height="50"><h2>Nuevo Tutor</h2>
          	<div class="atras"><button class="btn btn-success" onclick='window.location="tutores.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
         </div>
          <div class="row-fluid">
            <form name="ntut" id="ntut" class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST">
              <fieldset>
                 <div class="control-group">
                  <label class="control-label" for="cedulaTutor">Cédula</label>
                  <div class="controls">
                    <input type="text" class="input" name="cedulaTutor" id="cedulaTutor" placeholder="Cédula del Tutor"><br/><span id="muestra">V-12345678</span>
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="nombreTutor">Nombre</label>
                  <div class="controls">
                    <input type="text" class="input" name="nombreTutor" id="nombreTutor" placeholder="Nombre del Tutor">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="apellidoTutor">Apellido</label>
                  <div class="controls">
                    <input type="text" class="input" name="apellidoTutor" id="apellidoTutor" placeholder="Apellido del Tutor">
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="profesionTutor">Profesión</label>
                  <div class="controls">
                    <input type="text" class="input" name="profesionTutor" id="profesionTutor" placeholder="Profesión del Tutor">
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="postgradoTutor">Postgrado</label>
                  <div class="controls">
                    <input type="text" class="input" name="postgradoTutor" id="postgradoTutor" placeholder="Postgrado del Tutor">
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="telfTutor">Teléfono</label>
                  <div class="controls">
                    <input type="text" class="input" name="telfTutor" id="telfTutor" placeholder="Teléfono del Tutor"><br/><span id="muestra">(1234)5678901</span>
                  </div>
                </div>
                
                <div class="control-group">
                  <label class="control-label" for="emailTutor">Email</label>
                  <div class="controls">
                    <input type="text" class="input" name="emailTutor" id="emailTutor" placeholder="Email del Tutor">
                  </div>
                </div>


              </fieldset>
                
              <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button class="btn" type="reset">Limpiar</button>
              </div>
              <input type="hidden" name="MM_insert" value="form" />
            </form>
            </div>
        </div>                    
        </div><!--/span-->
      </div>
    </div>
</div>

		<script>
		
      		var frmNTUT = new Validator("ntut");
			
			frmNTUT.addValidation("cedulaTutor","req","Por favor ingrese una Cédula para el Tutor");
			frmNTUT.addValidation("cedulaTutor","regexp=^[VveE]-[0-9]{6,8}$","Por favor ingrese una Cédula válida para el Tutor");
			
			frmNTUT.addValidation("nombreTutor","req","Por favor ingrese un Nombre para el Tutor");
			frmNTUT.addValidation("nombreTutor","alpha_s","Por favor ingrese sólo caracteres alfabéticos");
			frmNTUT.addValidation("nombreTutor","minlen=2","Por favor ingrese un nombre válido");
			
			frmNTUT.addValidation("apellidoTutor","req","Por favor ingrese un Apellido para el Tutor");
			frmNTUT.addValidation("apellidoTutor","alpha_s","Por favor ingrese sólo caracteres alfabéticos");
			frmNTUT.addValidation("apellidoTutor","minlen=2","Por favor ingrese un apellido válido");
			
			frmNTUT.addValidation("profesionTutor","req","Por favor ingrese una Profesión para el Tutor");
			frmNTUT.addValidation("profesionTutor","minlen=2","Por favor ingrese una profesión válida");
			
			frmNTUT.addValidation("telfTutor","req","Por favor ingrese un Número de Teléfono para el Tutor");
			frmNTUT.addValidation("telfTutor","regexp=^\([0-9]{4}\)[0-9]{7}$","Por favor ingrese un número de teléfono válido");
			
			frmNTUT.addValidation("emailTutor","req","Por favor ingrese un Correo Electrónico para el Tutor");
			frmNTUT.addValidation("emailTutor","email","Por favor ingrese un email válido");
			

      	</script>
      