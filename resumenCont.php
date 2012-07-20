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

$maxRows_resumenes = 20;
$pageNum_resumenes = 0;
if (isset($_GET['pageNum_resumenes'])) {
  $pageNum_resumenes = $_GET['pageNum_resumenes'];
}
$startRow_resumenes = $pageNum_resumenes * $maxRows_resumenes;

mysql_select_db($database_bdresumen, $bdresumen);

if ($_SESSION['nombreUsuario']=='Administrador') {
  if (empty($_POST['texto'])) {
  $query_resumenes = "SELECT r.*, c.nombreCategoria, s.nombreSubcategoria, u.nombreUbicacion, t.nombreTutor, t.apellidoTutor FROM tblresumen r, tblcategoria c, tblsubcategorias s, tblubicaciones u, tbltutores t WHERE r.idUbicacion = u.idUbicacion AND s.idCategoria = c.idCategoria AND r.idSubcategoria = s.idSubcategoria AND r.idTutor = t.idTutor ORDER BY idResumen DESC";
  } else {
  $query_resumenes = "SELECT r.*, c.nombreCategoria, s.nombreSubcategoria, u.nombreUbicacion, t.nombreTutor, t.apellidoTutor FROM tblresumen r, tblcategoria c, tblsubcategorias s, tblubicaciones u, tbltutores t WHERE r.idUbicacion = u.idUbicacion AND s.idCategoria = c.idCategoria AND r.idSubcategoria = s.idSubcategoria AND r.idTutor = t.idTutor AND (r.tituloResumen LIKE '%".$_POST['texto']."%' OR r.textoResumen LIKE '%".$_POST['texto']."%' OR r.anoResumen LIKE '%".$_POST['texto']."%' OR r.autoresResumen LIKE '%".$_POST['texto']."%') ORDER BY idResumen DESC";
  }
} else {
  if (empty($_POST['texto'])) {
  $query_resumenes = "SELECT r.*, c.nombreCategoria, s.nombreSubcategoria, u.nombreUbicacion, t.nombreTutor, t.apellidoTutor FROM tblresumen r, tblcategoria c, tblsubcategorias s, tblubicaciones u, tbltutores t WHERE r.idUbicacion = u.idUbicacion AND s.idCategoria = c.idCategoria AND r.idSubcategoria = s.idSubcategoria AND r.idTutor = t.idTutor AND r.idUsuario = '".$_SESSION['idUsuario']."' ORDER BY idResumen DESC";
  } else {
  $query_resumenes = "SELECT r.*, c.nombreCategoria, s.nombreSubcategoria, u.nombreUbicacion, t.nombreTutor, 
                      t.apellidoTutor FROM tblresumen r, tblcategoria c, tblsubcategorias s, tblubicaciones u,
                      tbltutores t WHERE r.idUbicacion = u.idUbicacion AND s.idCategoria = c.idCategoria
  					AND r.idSubcategoria = s.idSubcategoria AND r.idTutor = t.idTutor AND r.idUsuario = '".$_SESSION['idUsuario']."' AND (r.tituloResumen LIKE '%".$_POST['texto']."%' OR r.textoResumen LIKE '%".$_POST['texto']."%' OR r.anoResumen LIKE '%".$_POST['texto']."%' OR r.autoresResumen LIKE '%".$_POST['texto']."%')
  					ORDER BY idResumen DESC";
  }
}



$query_limit_resumenes = sprintf("%s LIMIT %d, %d", $query_resumenes, $startRow_resumenes, $maxRows_resumenes);
$resumenes = mysql_query($query_limit_resumenes, $bdresumen) or die(mysql_error());
$res = mysql_query($query_limit_resumenes, $bdresumen) or die(mysql_error());
$row_resumenes = mysql_fetch_assoc($resumenes);

if (isset($_GET['totalRows_resumenes'])) {
  $totalRows_resumenes = $_GET['totalRows_resumenes'];
} else {
  $all_resumenes = mysql_query($query_resumenes);
  $totalRows_resumenes = mysql_num_rows($all_resumenes);
}
$totalPages_resumenes = ceil($totalRows_resumenes/$maxRows_resumenes)-1;

$queryString_resumenes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_resumenes") == false && 
        stristr($param, "totalRows_resumenes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_resumenes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_resumenes = sprintf("&totalRows_resumenes=%d%s", $totalRows_resumenes, $queryString_resumenes);
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
            <!--img src="img/1330457085_search_green.png" width="50" height="50"--><h2>Resúmenes</h2>
                <?php if ($_SESSION['agregarResumen']=="Y") {?><div class="row-fluid">
                	<a href="resumen.php?p=nres">Nuevo Resumen</a>
                  &nbsp;&nbsp;&nbsp;
                  <?php 
                    $datos = "[";
                    while ($row_res = mysql_fetch_assoc($res)) { 
                      $datos .= '"'.$row_resumenes['codigoResumen'].'",';
                      $datos .= '"'.$row_resumenes['nombreTutor'].' '.$row_resumenes['apellidoTutor'].'",';
                      $datos .= '"'.$row_resumenes['nombreUbicacion'].'",';
                      $datos .= '"'.$row_resumenes['autoresResumen'].'",';
                      $datos .= '"'.$row_resumenes['nombreCategoria'].'",';
                      $datos .= '"'.$row_resumenes['nombreSubcategoria'].'",';
                      $datos .= '"'.$row_resumenes['anoResumen'].'",';
                    }
                    $datos = substr($datos, 0, -1);
                    $datos .= "]";                    
                  ?>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
                    <input type="text" class="input span4" placeholder="Escriba un dato a buscar (ejm. Código, Año, Título, etc)" name="texto" data-provide="typeahead" data-items="6" 
                    data-source='<?=$datos?>'>
                      <?php if (empty($_POST['texto'])) { ?><button type="submit" class="btn">Buscar</button><?php } else { ?><button type="submit" class="btn">Limpiar Búsqueda</button><?php } ?>
                  </form>
                </div><?php } ?>
				<div class="row-fluid">
                
        <table class="table table-striped">
        <thead>
          <tr>
            <th>Código</th>
            <th>Año</th>
            <th>Título</th>
            <th>Tutor</th>
            <th>Ubicación</th>
            <th>Autores</th>
            <th>Postgrado</th>
            <th>SubPostgrado</th>
            <?php if ($_SESSION['modificarResumen']=="Y") {?><th>&nbsp;</th><?php } ?>
            <?php /*if ($_SESSION['eliminarResumen']=="Y") {?><th>&nbsp;</th><?php } */ ?>
          </tr>
        </thead>
        <tbody>
        
        <?php do { ?>
          <tr>
          	<td><?php echo $row_resumenes['codigoResumen']; ?></td>
            <td><?php echo $row_resumenes['anoResumen']; ?></td>
            <td><?php echo $row_resumenes['tituloResumen']; ?></td>
            <td><?php echo $row_resumenes['nombreTutor']; ?> <?php echo $row_resumenes['apellidoTutor']; ?></td>
            <td><?php echo $row_resumenes['nombreUbicacion']; ?></td>
            <td><?php echo $row_resumenes['autoresResumen']; ?></td>
            <td><?php echo $row_resumenes['nombreCategoria']; ?></td>
            <td><?php echo $row_resumenes['nombreSubcategoria']; ?></td>
            <?php if (sdate_diff($row_resumenes['fechaResumen']) <= DIAS_ACTIVIDAD) { if ($_SESSION['modificarResumen']=="Y") {?><td><a href="resumen.php?p=mres&idResumen=<?php echo $row_resumenes['idResumen']; ?>"><i class="icon-edit"></i> Modificar</a></td><?php } } else { ?><td><i class="icon-edit"></i> Modificar</td> <?php } ?>
            <?php /* if ($_SESSION['eliminarResumen']=="Y") {?><td><a href="delres.php?idResumen=<?php echo $row_resumenes['idResumen']; ?>" onclick="return confirme();"><i class="icon-remove"></i> Eliminar</a></a></td><?php } */ ?>
          </tr>
         <?php } while ($row_resumenes = mysql_fetch_assoc($resumenes)); ?>
        </tbody>
      </table>
             
                  <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td><?php if ($pageNum_resumenes > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_resumenes=%d%s", $currentPage, 0, $queryString_resumenes); ?>"><img src="img/First.gif" /></a>
                      <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_resumenes > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_resumenes=%d%s", $currentPage, max(0, $pageNum_resumenes - 1), $queryString_resumenes); ?>"><img src="img/Previous.gif" /></a>
                      <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_resumenes < $totalPages_resumenes) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_resumenes=%d%s", $currentPage, min($totalPages_resumenes, $pageNum_resumenes + 1), $queryString_resumenes); ?>"><img src="img/Next.gif" /></a>
                      <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_resumenes < $totalPages_resumenes) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_resumenes=%d%s", $currentPage, $totalPages_resumenes, $queryString_resumenes); ?>"><img src="img/Last.gif" /></a>
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
mysql_free_result($resumenes);
?>
