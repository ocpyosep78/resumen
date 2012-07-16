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

$maxRows_areas = 20;
$pageNum_areas = 0;
if (isset($_GET['pageNum_areas'])) {
  $pageNum_areas = $_GET['pageNum_areas'];
}
$startRow_areas = $pageNum_areas * $maxRows_areas;

mysql_select_db($database_bdresumen, $bdresumen);
if (empty($_POST['texto'])) {
  $query_areas = "SELECT * FROM tblareas ORDER BY nombreArea ASC";
} else {
  $query_areas = "SELECT * FROM tblareas WHERE nombreArea LIKE '%".$_POST['texto']."%' ORDER BY nombreArea ASC";
}

$query_limit_areas = sprintf("%s LIMIT %d, %d", $query_areas, $startRow_areas, $maxRows_areas);
$areas = mysql_query($query_limit_areas, $bdresumen) or die(mysql_error());
$are = mysql_query($query_limit_areas, $bdresumen) or die(mysql_error());
$row_areas = mysql_fetch_assoc($areas);

if (isset($_GET['totalRows_areas'])) {
  $totalRows_areas = $_GET['totalRows_areas'];
} else {
  $all_areas = mysql_query($query_areas);
  $totalRows_areas = mysql_num_rows($all_areas);
}
$totalPages_areas = ceil($totalRows_areas/$maxRows_areas)-1;

$queryString_areas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_areas") == false && 
        stristr($param, "totalRows_areas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_areas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_areas = sprintf("&totalRows_areas=%d%s", $totalRows_areas, $queryString_areas);
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
				<h2>Áreas</h2>
                <?php if ($_SESSION['agregarArea']=="Y") {?><div class="row-fluid">
                	<a href="areas.php?p=nare">Nueva Área</a>
                  &nbsp;&nbsp;&nbsp;
                  <?php 
                    $datos = "[";
                    while ($row_are = mysql_fetch_assoc($are)) {
                      $datos .= '"'.$row_are['nombreArea'].'",';
                    }
                    $datos = substr($datos, 0, -1);
                    $datos .= "]";                    
                  ?>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
                    <input type="text" class="input span4" placeholder="Escriba un Área a buscar" name="texto" data-provide="typeahead" data-items="6" 
                    data-source='<?=$datos?>'>
                      <?php if (empty($_POST['texto'])) { ?><button type="submit" class="btn">Buscar</button><?php } else { ?><button type="submit" class="btn">Limpiar Búsqueda</button><?php } ?>
                  </form>
                </div><?php } ?>
				<div class="row-fluid">
                
                
        <table class="table table-striped">
        <thead>
          <tr>
            <th>Nombre</th>
            <?php if ($_SESSION['modificarArea']=="Y") {?><th>&nbsp;</th><?php } ?>
            <?php if ($_SESSION['eliminarArea']=="Y") {?><th>&nbsp;</th><?php } ?>
          </tr>
        </thead>
        <tbody>
        
        <?php do { ?>
          <tr>
          	<td><?php echo $row_areas['nombreArea']; ?></td>
            <?php if ($_SESSION['modificarArea']=="Y") {?><td><a href="areas.php?p=mare&idArea=<?php echo $row_areas['idArea']; ?>"><i class="icon-edit"></i> Modificar</a></td><?php } ?>
            <?php if ($_SESSION['eliminarArea']=="Y") {?><td><a href="delare.php?idArea=<?php echo $row_areas['idArea']; ?>" onclick="return confirme();"><i class="icon-remove"></i> Eliminar</a></a></td><?php } ?>
          </tr>
         <?php } while ($row_areas = mysql_fetch_assoc($areas)); ?>
        </tbody>
      </table>  
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <td><?php if ($pageNum_areas > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_areas=%d%s", $currentPage, 0, $queryString_areas); ?>"><img src="img/First.gif" /></a>
                            <?php } // Show if not first page ?></td>
                        <td><?php if ($pageNum_areas > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_areas=%d%s", $currentPage, max(0, $pageNum_areas - 1), $queryString_areas); ?>"><img src="img/Previous.gif" /></a>
                            <?php } // Show if not first page ?></td>
                        <td><?php if ($pageNum_areas < $totalPages_areas) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_areas=%d%s", $currentPage, min($totalPages_areas, $pageNum_areas + 1), $queryString_areas); ?>"><img src="img/Next.gif" /></a>
                            <?php } // Show if not last page ?></td>
                        <td><?php if ($pageNum_areas < $totalPages_areas) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_areas=%d%s", $currentPage, $totalPages_areas, $queryString_areas); ?>"><img src="img/Last.gif" /></a>
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
mysql_free_result($areas);
?>
