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

$maxRows_categorias = 20;
$pageNum_categorias = 0;
if (isset($_GET['pageNum_categorias'])) {
  $pageNum_categorias = $_GET['pageNum_categorias'];
}
$startRow_categorias = $pageNum_categorias * $maxRows_categorias;

mysql_select_db($database_bdresumen, $bdresumen);
if (empty($_POST['texto'])) {
  $query_categorias = "SELECT * FROM tblcategoria ORDER BY nombreCategoria ASC";
} else {
  $query_categorias = "SELECT * FROM tblcategoria WHERE nombreCategoria LIKE '%".$_POST['texto']."%' OR codigoCategoria LIKE '%".$_POST['texto']."%' ORDER BY nombreCategoria ASC";
}
$query_limit_categorias = sprintf("%s LIMIT %d, %d", $query_categorias, $startRow_categorias, $maxRows_categorias);
$categorias = mysql_query($query_limit_categorias, $bdresumen) or die(mysql_error());
$cat = mysql_query($query_limit_categorias, $bdresumen) or die(mysql_error());
$row_categorias = mysql_fetch_assoc($categorias);

if (isset($_GET['totalRows_categorias'])) {
  $totalRows_categorias = $_GET['totalRows_categorias'];
} else {
  $all_categorias = mysql_query($query_categorias);
  $totalRows_categorias = mysql_num_rows($all_categorias);
}
$totalPages_categorias = ceil($totalRows_categorias/$maxRows_categorias)-1;

$queryString_categorias = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_categorias") == false && 
        stristr($param, "totalRows_categorias") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_categorias = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_categorias = sprintf("&totalRows_categorias=%d%s", $totalRows_categorias, $queryString_categorias);
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
            <!--img src="img/1330457085_search_green.png" width="50" height="50"--><h2>Postgrado</h2>
                <?php if ($_SESSION['agregarCategorias']=="Y") {?><div class="row-fluid">
                	<a href="categorias.php?p=ncat">Nuevo Postgrado</a>

                  &nbsp;&nbsp;&nbsp;
                  <?php 
                    $datos = "[";
                    while ($row_cat = mysql_fetch_assoc($cat)) { 
                      $datos .= '"'.$row_cat['codigoCategoria'].'",';
                      $datos .= '"'.$row_cat['nombreCategoria'].'",';
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
            <?php if ($_SESSION['modificarCategorias']=="Y") {?><th>&nbsp;</th><?php } ?>
            <?php if ($_SESSION['eliminarCategorias']=="Y") {?><th>&nbsp;</th><?php } ?>
          </tr>
        </thead>
        <tbody>
        
        <?php do { ?>
          <tr>
          	<td><?php echo $row_categorias['codigoCategoria']; ?></td>
            <td><?php echo $row_categorias['nombreCategoria']; ?></td>
            <?php if ($_SESSION['modificarCategorias']=="Y") {?><td><a href="categorias.php?p=mcat&idCategoria=<?php echo $row_categorias['idCategoria']; ?>"><i class="icon-edit"></i> Modificar</a></td><?php } ?>
            <?php if ($_SESSION['eliminarCategorias']=="Y") {?><td><a href="delcat.php?idCategoria=<?php echo $row_categorias['idCategoria']; ?>" onclick="return confirme();"><i class="icon-remove"></i> Eliminar</a></a></td><?php } ?>
          </tr>
         <?php } while ($row_categorias = mysql_fetch_assoc($categorias)); ?>
        </tbody>
      </table>
             
                    
                  <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td><?php if ($pageNum_categorias > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_categorias=%d%s", $currentPage, 0, $queryString_categorias); ?>"><img src="img/First.gif" /></a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_categorias > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_categorias=%d%s", $currentPage, max(0, $pageNum_categorias - 1), $queryString_categorias); ?>"><img src="img/Previous.gif" /></a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_categorias < $totalPages_categorias) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_categorias=%d%s", $currentPage, min($totalPages_categorias, $pageNum_categorias + 1), $queryString_categorias); ?>"><img src="img/Next.gif" /></a>
                          <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_categorias < $totalPages_categorias) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_categorias=%d%s", $currentPage, $totalPages_categorias, $queryString_categorias); ?>"><img src="img/Last.gif" /></a>
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
mysql_free_result($categorias);
?>
