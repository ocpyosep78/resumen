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

$maxRows_subcategorias = 20;
$pageNum_subcategorias = 0;
if (isset($_GET['pageNum_subcategorias'])) {
  $pageNum_subcategorias = $_GET['pageNum_subcategorias'];
}
$startRow_subcategorias = $pageNum_subcategorias * $maxRows_subcategorias;

mysql_select_db($database_bdresumen, $bdresumen);

if (empty($_POST['texto'])) {
  $query_subcategorias = "SELECT s.*, c.nombreCategoria, a.nombreArea FROM tblsubcategorias s, tblcategoria c, tblareas a WHERE s.idCategoria = c.idCategoria AND s.idArea = a.idArea ORDER BY nombreSubcategoria ASC";
} else {
  $query_subcategorias = "SELECT s.*, c.nombreCategoria, a.nombreArea FROM tblsubcategorias s, tblcategoria c, tblareas a WHERE s.idCategoria = c.idCategoria AND s.idArea = a.idArea AND (s.nombreSubcategoria LIKE '%".$_POST['texto']."%' OR codigoSubcategoria LIKE '%".$_POST['texto']."%') ORDER BY nombreSubcategoria ASC";
}

$query_limit_subcategorias = sprintf("%s LIMIT %d, %d", $query_subcategorias, $startRow_subcategorias, $maxRows_subcategorias);
$subcategorias = mysql_query($query_limit_subcategorias, $bdresumen) or die(mysql_error());
$sub = mysql_query($query_limit_subcategorias, $bdresumen) or die(mysql_error());
$row_subcategorias = mysql_fetch_assoc($subcategorias);

if (isset($_GET['totalRows_subcategorias'])) {
  $totalRows_subcategorias = $_GET['totalRows_subcategorias'];
} else {
  $all_subcategorias = mysql_query($query_subcategorias);
  $totalRows_subcategorias = mysql_num_rows($all_subcategorias);
}
$totalPages_subcategorias = ceil($totalRows_subcategorias/$maxRows_subcategorias)-1;

$queryString_subcategorias = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_subcategorias") == false && 
        stristr($param, "totalRows_subcategorias") == false) {
      	array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_subcategorias = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_subcategorias = sprintf("&totalRows_subcategorias=%d%s", $totalRows_subcategorias, $queryString_subcategorias);
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
            <!--img src="img/1330457085_search_green.png" width="50" height="50"--><h2>Programas</h2>
            <?php if ($_SESSION['agregarSubcategorias']=="Y") {?><div class="row-fluid">
              <a href="subcategorias.php?p=nscat">Nuevo Programa</a>
              &nbsp;&nbsp;&nbsp;
                  <?php 
                    $datos = "[";
                    while ($row_sub = mysql_fetch_assoc($sub)) { 
                      $datos .= '"'.$row_sub['codigoSubcategoria'].'",';
                      $datos .= '"'.$row_sub['nombreSubcategoria'].'",';
                      $datos .= '"'.$row_sub['nombreCategoria'].'",';
                    }
                    $datos = substr($datos, 0, -1);
                    $datos .= "]";                    
                  ?>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
                    <input type="text" class="input span4" placeholder="Escriba un dato a buscar (ejm. Código o Nombre)" name="texto" data-provide="typeahead" data-items="6" 
                    data-source='<?=$datos?>'>
                      <?php if (empty($_POST['texto'])) { ?><button type="submit" class="btn">Buscar</button><?php } else { ?><button type="submit" class="btn">Limpiar Búsqueda</button><?php } ?>
                  </form>

            </div><?php } ?>
            
				<div class="row-fluid">
                
        <table class="table table-striped">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Postgrado</th>
            <th>Área</th>
            <?php if ($_SESSION['modificarSubcategorias']=="Y") {?><th>&nbsp;</th><?php } ?>
            <?php if ($_SESSION['eliminarSubcategorias']=="Y") {?><th>&nbsp;</th><?php } ?>
          </tr>
        </thead>
        <tbody>
        
        <?php do { ?>
          <tr>
          	<td><?php echo $row_subcategorias['codigoSubcategoria']; ?></td>
            <td><?php echo $row_subcategorias['nombreSubcategoria']; ?></td>
            <td><?php echo $row_subcategorias['nombreCategoria']; ?></td>
            <td><?php echo $row_subcategorias['nombreArea']; ?></td>
            <?php if ($_SESSION['modificarSubcategorias']=="Y") {?><td><a href="subcategorias.php?p=mscat&idSubcategoria=<?php echo $row_subcategorias['idSubcategoria']; ?>"><i class="icon-edit"></i> Modificar</a></td><?php } ?>
            <?php if ($_SESSION['eliminarSubcategorias']=="Y") {?><td><a href="delscat.php?idSubcategoria=<?php echo $row_subcategorias['idSubcategoria']; ?>" onclick="return confirme();"><i class="icon-remove"></i> Eliminar</a></a></td><?php } ?>
          </tr>
         <?php } while ($row_subcategorias = mysql_fetch_assoc($subcategorias)); ?>
        </tbody>
      </table>
                  <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td><?php if ($pageNum_subcategorias > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_subcategorias=%d%s", $currentPage, 0, $queryString_subcategorias); ?>"><img src="img/First.gif" /></a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_subcategorias > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_subcategorias=%d%s", $currentPage, max(0, $pageNum_subcategorias - 1), $queryString_subcategorias); ?>"><img src="img/Previous.gif" /></a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_subcategorias < $totalPages_subcategorias) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_subcategorias=%d%s", $currentPage, min($totalPages_subcategorias, $pageNum_subcategorias + 1), $queryString_subcategorias); ?>"><img src="img/Next.gif" /></a>
                          <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_subcategorias < $totalPages_subcategorias) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_subcategorias=%d%s", $currentPage, $totalPages_subcategorias, $queryString_subcategorias); ?>"><img src="img/Last.gif" /></a>
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
mysql_free_result($subcategorias);
?>
