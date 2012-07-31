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

mysql_select_db($database_bdresumen, $bdresumen);
$query_cates = "SELECT * FROM tblcategoria ORDER BY nombreCategoria ASC";
$cates = mysql_query($query_cates, $bdresumen) or die(mysql_error());
$row_cates = mysql_fetch_assoc($cates);
$totalRows_cates = mysql_num_rows($cates);

$colname_scates = "-1";
if (isset($row_cates['idCategoria'])) {
  $colname_scates = $row_cates['idCategoria'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_scates = sprintf("SELECT * FROM tblsubcategorias WHERE idCategoria = %s ORDER BY nombreSubcategoria ASC", GetSQLValueString($colname_scates, "int"));
$scates = mysql_query($query_scates, $bdresumen) or die(mysql_error());
$row_scates = mysql_fetch_assoc($scates);
$totalRows_scates = mysql_num_rows($scates);

mysql_select_db($database_bdresumen, $bdresumen);
$query_anios = "SELECT DISTINCT anoResumen FROM tblresumen ORDER BY anoResumen DESC";
$anios = mysql_query($query_anios, $bdresumen) or die(mysql_error());
$row_anios = mysql_fetch_assoc($anios);
$totalRows_anios = mysql_num_rows($anios);

mysql_select_db($database_bdresumen, $bdresumen);
$query_areas = "SELECT * FROM tblareas ORDER BY nombreArea ASC";
$areas = mysql_query($query_areas, $bdresumen) or die(mysql_error());
$row_areas = mysql_fetch_assoc($areas);
$totalRows_areas= mysql_num_rows($areas);


mysql_select_db($database_bdresumen, $bdresumen);
$query_subcat = "SELECT * FROM tblsubcategorias ORDER BY nombreSubcategoria ASC";
$subcat = mysql_query($query_subcat, $bdresumen) or die(mysql_error());
$row_subcat = mysql_fetch_assoc($subcat);
$totalRows_subcat = mysql_num_rows($subcat);

mysql_select_db($database_bdresumen, $bdresumen);
$query_letras = "SELECT DISTINCT LEFT(tituloResumen, 1) letra FROM tblresumen 
        		WHERE UPPER(LEFT(tituloResumen, 1)) BETWEEN 'A' AND 'Z'
        		OR LEFT(tituloResumen, 1) BETWEEN '0' AND '9' ORDER BY tituloResumen";
$letras = mysql_query($query_letras, $bdresumen) or die(mysql_error());
$row_letras = mysql_fetch_assoc($letras);
$totalRows_letras = mysql_num_rows($letras);
?>
<div style="margin:20px;">
<div class="container-fluid" style="margin:auto">
	<div class="row-fluid">
        <div class="span8">
         	<div class="well">
            <img src="img/1330457085_search_green.png" width="50" height="50"><h2>Buscar Resumen de Trabajo Especial de Grado</h2>
                <div class="row-fluid">
                    <form class="form-horizontal" action="index.php" method="GET" name="myform">
                    <fieldset>
                    <legend>Seleccione el tipo de búsqueda que desea realizar</legend>
                      <ul id="tab" class="nav nav-tabs">
                        <li class="active"><a href="#basica" data-toggle="tab">Básica</a></li>
                        <li class=""><a href="#avanzada" data-toggle="tab">Avanzada</a></li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="basica">
                          <p>
                           <div class="control-group">
                        <label class="control-label" for="input01">Palabra(s)</label>
                        <div class="controls">
                          <input name="textoResumen" type="text" class="input-xlarge" id="input01" placeholder="Nombre de la Tesis o Palabra Clave">
                          <p class="help-block">Usted puede escribir el nombre del autor, título, año, código y/o alguna palabra que identifique la tesis a buscar</p>
                        </div>
                      </div>
                          </p>
                        </div>
                        
                        <div class="tab-pane fade" id="avanzada">
                          <p>
                          <div class="control-group">
                        <label class="control-label" for="tutorResumen">Tutor</label>
                        <div class="controls">
                          <input type="text" name="tutorResumen" id="tutorResumen" placeholder="Escriba Primer Nombre, Primer Apellido" />
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label" for="tituloResumen">Título</label>
                        <div class="controls">
                          <input type="text" name="tituloResumen" id="tituloResumen" placeholder="Escriba el Título de la Tesis" />
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label" for="idCategoria">Postgrado</label>
                        <div class="controls">
                          <select name="idCategoria" id="idCategoria">
                          <option value="">Seleccione una opción</option>
                            <?php
                            do {  
                            ?>
                            <option value="<?php echo $row_cates['idCategoria']?>"><?php echo $row_cates['nombreCategoria']?></option>
                            <?php
              							} while ($row_cates = mysql_fetch_assoc($cates));
              							  $rows = mysql_num_rows($cates);
              							  if($rows > 0) {
              								  mysql_data_seek($cates, 0);
              								  $row_cates = mysql_fetch_assoc($cates);
              							  }
              							?>
                          </select>
                        </div>
                      </div>
                      <div class="control-group mostrar">
                        <label class="control-label" for="idCategoria">Área</label>
                        <div class="controls">
                          <select name="idArea" id="idArea">
                          <option value="">Seleccione una opción</option>
                            <?php 
                            do {  
                            ?>
                            <option value="<?php echo $row_areas['idArea']?>"><?php echo $row_areas['nombreArea']?></option>
                            <?php
                            } while ($row_areas = mysql_fetch_assoc($areas));
                              $rows = mysql_num_rows($areas);
                              if($rows > 0) {
                                mysql_data_seek($areas, 0);
                                $row_areas = mysql_fetch_assoc($areas);
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="control-group mostrar">
                        <label class="control-label" for="idSubcategoria">Programa</label>
                        <div class="controls">
                          <select name="idSubcategoria" id="idSubcategoria">
                          <option value="">Seleccione una opción</option>
                            <?php
do {  
?>
                            <option value="<?php echo $row_subcat['idSubcategoria']?>"><?php echo $row_subcat['nombreSubcategoria']?></option>
                            <?php
} while ($row_subcat = mysql_fetch_assoc($subcat));
  $rows = mysql_num_rows($subcat);
  if($rows > 0) {
      mysql_data_seek($subcat, 0);
	  $row_subcat = mysql_fetch_assoc($subcat);
  }
?>
                          </select>
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label" for="anoResumen">Año</label>
                        <div class="controls">
                          <select name="anoResumen" id="anoResumen" style="width: 70px;">
                          	<option value="">Seleccione una opción</option>
                            <?php
do {  
?>
                            <option value="<?php echo $row_anios['anoResumen']?>"><?php echo $row_anios['anoResumen']?></option>
                            <?php
							} while ($row_anios = mysql_fetch_assoc($anios));
							  $rows = mysql_num_rows($anios);
							  if($rows > 0) {
								  mysql_data_seek($anios, 0);
								  $row_anios = mysql_fetch_assoc($anios);
							  }
							?>
                          </select>
                        </div>
                      </div>
                          </p>
                        </div>
                      
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                        <button class="btn" type="reset">Cancelar</button>
                      </div>
                  	<input type="hidden" name="p" value="responses">
                    </fieldset>
                  </form>
              </div>
          </div>
                    <div class="well">
                        <?php do{ ?>
								<a href="index.php?p=lres&letter=<?php echo strtoupper($row_letras['letra']);?>" ><?php echo strtoupper($row_letras['letra']);?></a>
						<?php	}while($row_letras = mysql_fetch_assoc($letras));?>
                    </div>
                    <div class="well" style="overflow:hidden;">
                      <img src="img/gerencia1.jpg" alt="" style="display:inline-block; margin-right: 17px; height: 23%; width: 23%">
                      <img src="img/gerencia2.jpg" alt="" style="display:inline-block; margin-right: 17px; height: 23%; width: 23%">
                      <img src="img/educaciontomo1.jpg" alt="" style="display:inline-block; margin-right: 17px; height: 23%; width: 23%">
                      <img src="img/educaciontomo2.jpg" alt="" style="display:inline-block; margin-right: 17px; height: 23%; width: 23%">
                      <div  style="margin: 20px auto; width:400px;">
                      <a href="manual.pdf" target="_blank">
                        <img src="img/dm.png">
                      </a>
                      </div>
                     
                    </div>
        </div><!--/span-->
        
        <div class="span4">
          <div class="well">
          	<legend>Usuarios Autorizados</legend>
            <form class="form-horizontal" action="login.php" method="post">
            	<div class="control-group"><input type="text" class="input" placeholder="Login" name="login"></div>
				<?php 
				if(isset($_GET['eu'])){
				?>
                <div class="alert alert-error">
                	<a class="close" data-dismiss="alert">×</a>
                	<strong>¡OOOPS!</strong> Error de usuario, intente de nuevo
                </div>
                <?php } ?>
                <div class="control-group"><input type="password" class="input" placeholder="Clave" name="clave"></div>
                <?php 
				if(isset($_GET['ec'])){
				?>
                <div class="alert alert-error">
                	<a class="close" data-dismiss="alert">×</a>
                    <strong>¡OOOPS!</strong> Clave incorrecta o usuario inactivo 
                    <?php 
						if(isset($_GET['ni']) && $_GET['ni']==3){
							echo " Dirijase al Administrador del sitio";
						}
					?>
                </div>
                <?php } ?>
                <div class="control-group">
                	<input type="hidden" name="ni" value="<?php if (isset($_GET['ni'])) { echo $_GET['ni']; } else { echo "0"; }?>">
                	<button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>
          </div><!--/.well -->
          
        </div><!--/span-->
        
        
        <div class="span4">
        	<div class="nav" >
                        <ul class="nav nav-list">
                          <li class="nav-header">Enlaces de Interés</li>
                          <li>
                            <a href="http://www.uvm.edu.ve" target="_blank">
                              <img src="img/uvm-banner.png" alt="">
                            </a>
                          </li>
                          <li>
                            <a href="http://revistav.uvm.edu.ve" target="_blank">
                              <img src="img/revistaelectronica.jpg" alt="" height="90%" width="90%">
                            </a>
                          </li>
                          <li>
                            <a href="http://www.wdl.org/es/" target="_blank">
                              <img src="img/logo_bibliom1.jpg" alt="" height="89%" width="89%">
                            </a></li>
                          <li>
                            <a href="http://www.cervantesvirtual.com/" target="_blank">
                              <img src="img/bmc.jpg" alt="" height="89%" width="89%">
                            </a>
                          </li>
                          <li>
                            <a href="http://biblioteca.uvm.edu.ve/" target="_blank">
                              <img src="img/sb.jpg" alt="" height="89%" width="89%">
                            </a>
                          </li>

                        </ul>
        	</div>
        </div>            
      </div>
</div>
<script src="js/gen_validatorv4.js" type="text/javascript"></script>
<?php
mysql_free_result($cates);

mysql_free_result($scates);

mysql_free_result($anios);

mysql_free_result($subcat);
?>
