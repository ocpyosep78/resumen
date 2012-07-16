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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_ubicaciones = 20;
$pageNum_ubicaciones = 0;
if (isset($_GET['pageNum_ubicaciones'])) {
  $pageNum_ubicaciones = $_GET['pageNum_ubicaciones'];
}
$startRow_ubicaciones = $pageNum_ubicaciones * $maxRows_ubicaciones;

mysql_select_db($database_bdresumen, $bdresumen);
if (empty($_POST['texto'])) {
  $query_ubicaciones = "SELECT * FROM tblubicaciones ORDER BY nombreUbicacion ASC";
} else {
  $query_ubicaciones = "SELECT * FROM tblubicaciones WHERE nombreUbicacion LIKE '%".$_POST['texto']."%' ORDER BY nombreUbicacion ASC";
}

$query_limit_ubicaciones = sprintf("%s LIMIT %d, %d", $query_ubicaciones, $startRow_ubicaciones, $maxRows_ubicaciones);
$ubicaciones = mysql_query($query_limit_ubicaciones, $bdresumen) or die(mysql_error());
$ubica = mysql_query($query_limit_ubicaciones, $bdresumen) or die(mysql_error());
$row_ubicaciones = mysql_fetch_assoc($ubicaciones);

if (isset($_GET['totalRows_ubicaciones'])) {
  $totalRows_ubicaciones = $_GET['totalRows_ubicaciones'];
} else {
  $all_ubicaciones = mysql_query($query_ubicaciones);
  $totalRows_ubicaciones = mysql_num_rows($all_ubicaciones);
}
$totalPages_ubicaciones = ceil($totalRows_ubicaciones/$maxRows_ubicaciones)-1;

$queryString_ubicaciones = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ubicaciones") == false && 
        stristr($param, "totalRows_ubicaciones") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ubicaciones = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ubicaciones = sprintf("&totalRows_ubicaciones=%d%s", $totalRows_ubicaciones, $queryString_ubicaciones);
?>
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
				<h2>Ubicaciones</h2>
                <?php if ($_SESSION['agregarUbicaciones']=="Y") {?><div class="row-fluid">
                	<a href="ubicaciones.php?p=nubi">Nueva Ubicación</a>
                  &nbsp;&nbsp;&nbsp;
                  <?php 
                    $datos = "[";
                    while ($row_ubica = mysql_fetch_assoc($ubica)) {
                      $datos .= '"'.$row_ubica['nombreUbicacion'].'",';
                    }
                    $datos = substr($datos, 0, -1);
                    $datos .= "]";                    
                  ?>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
                    <input type="text" class="input span4" placeholder="Escriba una Ubicación a buscar" name="texto" data-provide="typeahead" data-items="6" 
                    data-source='<?=$datos?>'>
                      <?php if (empty($_POST['texto'])) { ?><button type="submit" class="btn">Buscar</button><?php } else { ?><button type="submit" class="btn">Limpiar Búsqueda</button><?php } ?>
                  </form>
                </div><?php } ?>
				<div class="row-fluid">
                
                
        <table class="table table-striped">
        <thead>
          <tr>
            <th>Nombre</th>
            <?php if ($_SESSION['modificarUbicaciones']=="Y") {?><th>&nbsp;</th><?php } ?>
            <?php if ($_SESSION['eliminarUbicaciones']=="Y") {?><th>&nbsp;</th><?php } ?>
          </tr>
        </thead>
        <tbody>
        
        <?php do { ?>
          <tr>
          	<td><?php echo $row_ubicaciones['nombreUbicacion']; ?></td>
            <?php if ($_SESSION['modificarUbicaciones']=="Y") {?><td><a href="ubicaciones.php?p=mubi&idUbicacion=<?php echo $row_ubicaciones['idUbicacion']; ?>"><i class="icon-edit"></i> Modificar</a></td><?php } ?>
            <?php if ($_SESSION['eliminarUbicaciones']=="Y") {?><td><a href="delubi.php?idUbicacion=<?php echo $row_ubicaciones['idUbicacion']; ?>" onclick="return confirme();"><i class="icon-remove"></i> Eliminar</a></a></td><?php } ?>
          </tr>
         <?php } while ($row_ubicaciones = mysql_fetch_assoc($ubicaciones)); ?>
        </tbody>
      </table>
             
                    
                  <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td><?php if ($pageNum_ubicaciones > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_ubicaciones=%d%s", $currentPage, 0, $queryString_ubicaciones); ?>"><img src="img/First.gif" /></a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_ubicaciones > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_ubicaciones=%d%s", $currentPage, max(0, $pageNum_ubicaciones - 1), $queryString_ubicaciones); ?>"><img src="img/Previous.gif" /></a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_ubicaciones < $totalPages_ubicaciones) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_ubicaciones=%d%s", $currentPage, min($totalPages_ubicaciones, $pageNum_ubicaciones + 1), $queryString_ubicaciones); ?>"><img src="img/Next.gif" /></a>
                          <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_ubicaciones < $totalPages_ubicaciones) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_ubicaciones=%d%s", $currentPage, $totalPages_ubicaciones, $queryString_ubicaciones); ?>"><img src="img/Last.gif" /></a>
                          <?php } // Show if not last page ?></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                
          </div>                    
        </div><!--/span-->
      </div>
</div>
<?php
mysql_free_result($ubicaciones);
?>
