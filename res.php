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

$colname_resumen = "-1";
if (isset($_GET['idResumen'])) {
  $colname_resumen = $_GET['idResumen'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_resumen = sprintf("SELECT * FROM tblresumen WHERE idResumen = %s", GetSQLValueString($colname_resumen, "int"));
$resumen = mysql_query($query_resumen, $bdresumen) or die(mysql_error());
$row_resumen = mysql_fetch_assoc($resumen);
$totalRows_resumen = mysql_num_rows($resumen);

$colname_subcategoria = "-1";
if (isset($row_resumen['idSubcategoria'])) {
  $colname_subcategoria = $row_resumen['idSubcategoria'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_subcategoria = sprintf("SELECT * FROM tblsubcategorias WHERE idSubcategoria = %s", GetSQLValueString($colname_subcategoria, "int"));
$subcategoria = mysql_query($query_subcategoria, $bdresumen) or die(mysql_error());
$row_subcategoria = mysql_fetch_assoc($subcategoria);
$totalRows_subcategoria = mysql_num_rows($subcategoria);

$colname_categoria = "-1";
if (isset($row_subcategoria['idCategoria'])) {
  $colname_categoria = $row_subcategoria['idCategoria'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_categoria = sprintf("SELECT * FROM tblcategoria WHERE idCategoria = %s", GetSQLValueString($colname_categoria, "int"));
$categoria = mysql_query($query_categoria, $bdresumen) or die(mysql_error());
$row_categoria = mysql_fetch_assoc($categoria);
$totalRows_categoria = mysql_num_rows($categoria);

$colname_tutor = "-1";
if (isset($row_resumen['idTutor'])) {
  $colname_tutor = $row_resumen['idTutor'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_tutor = sprintf("SELECT * FROM tbltutores WHERE idTutor = %s", GetSQLValueString($colname_tutor, "int"));
$tutor = mysql_query($query_tutor, $bdresumen) or die(mysql_error());
$row_tutor = mysql_fetch_assoc($tutor);
$totalRows_tutor = mysql_num_rows($tutor);


?>
<style type="text/css">
#imagen {
	margin: 10px 15px 10px 0px;
	display: inline-block;
	float:left;
}
.well{
	-moz-box-shadow: 2px 2px 5px #000000;
	-webkit-box-shadow: 2px 2px 5px #000000;
	box-shadow: 2px 2px 5px #000000;
}
#imagen a:hover{
	padding:2px;	
}
</style>

<div style="margin:20px;">

    <div class="container-fluid" style="margin:auto">
          <ul class="nav nav-pills">
            <li class="active"><a href="index.php">Inicio</a></li>
            <li><a href="<?php echo 'index.php?'.$_SERVER['QUERY_STRING']."&p=responses"; ?>">Regresar a Los Resultados</a></li>
          </ul>
          
        <div class="row-fluid">
        	<div class="span12">
          		<h1><?php echo $row_resumen['tituloResumen'];?></h1>
                <small><?php echo $row_resumen['autoresResumen'];?></small>
              <small style="display:block; text-align:right">Tutor: <?php echo $row_tutor['nombreTutor'];?> <?php echo $row_tutor['apellidoTutor'];?></small>
                <hr class="soften">
              <small class="infor"><?php echo $row_categoria['nombreCategoria']; ?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo $row_subcategoria['nombreSubcategoria']; ?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo $row_resumen['anoResumen'];?></small>
                <div style="line-height:2em;">
          		<?php echo $row_resumen['textoResumen'];?>
                </div>
                
          	</div>
            
            
                         
             <?php
             	if (file_exists("uploads/".$row_resumen['archivoResumen']) && !empty($row_resumen['archivoResumen'])) {
			 ?>
            <div class="span12">
            	<div class="well">
                	<div id="imagen">
          			<a href="<?php echo "uploads/".$row_resumen['archivoResumen']; ?>" target="_blank"><img src="img/1334778922_ACP_PDF 2_file_document.png" alt="Descargar Archivo" title="Descargar Archivo"/></a>
                    </div>
                    <div id="texto">
                    	<h2>Descargar Archivo</h2>
                        <p>Para descargar éste archivo debe dar clic sobre el ícono</p>
                    </div>
                </div>
          	</div>
            <?php
				}
			?>
            
            
            
            
            
            
            
        </div>
            
        
        <div class="row-fluid">
        	<div class="span12">
        		<hr class="soften">
        	</div>
        </div>
        
  </div>
</div>
<?php
mysql_free_result($resumen);

mysql_free_result($subcategoria);

mysql_free_result($categoria);

mysql_free_result($tutor);
?>
