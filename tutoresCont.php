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

$maxRows_tutores = 20;
$pageNum_tutores = 0;
if (isset($_GET['pageNum_tutores'])) {
  $pageNum_tutores = $_GET['pageNum_tutores'];
}
$startRow_tutores = $pageNum_tutores * $maxRows_tutores;

mysql_select_db($database_bdresumen, $bdresumen);
if (empty($_POST['texto'])) {
  $query_tutores = "SELECT * FROM tbltutores ORDER BY nombreTutor ASC";
} else {
  $query_tutores = "SELECT * FROM tbltutores WHERE nombreTutor LIKE '%".$_POST['texto']."%' OR cedulaTutor LIKE '%".$_POST['texto']."%' OR apellidoTutor LIKE '%".$_POST['texto']."%' OR profesionTutor LIKE '%".$_POST['texto']."%' OR postgradoTutor LIKE '%".$_POST['texto']."%'  OR emailTutor LIKE '%".$_POST['texto']."%' OR telfTutor LIKE '%".$_POST['texto']."%' ORDER BY nombreTutor ASC";
}
$query_limit_tutores = sprintf("%s LIMIT %d, %d", $query_tutores, $startRow_tutores, $maxRows_tutores);
$tutores = mysql_query($query_limit_tutores, $bdresumen) or die(mysql_error());
$tuto = mysql_query($query_limit_tutores, $bdresumen) or die(mysql_error());
$row_tutores = mysql_fetch_assoc($tutores);

if (isset($_GET['totalRows_tutores'])) {
  $totalRows_tutores = $_GET['totalRows_tutores'];
} else {
  $all_tutores = mysql_query($query_tutores);
  $totalRows_tutores = mysql_num_rows($all_tutores);
}
$totalPages_tutores = ceil($totalRows_tutores/$maxRows_tutores)-1;

$queryString_tutores = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_tutores") == false && 
        stristr($param, "totalRows_tutores") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_tutores = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_tutores = sprintf("&totalRows_tutores=%d%s", $totalRows_tutores, $queryString_tutores);
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
				<h2>Tutores</h2>
                <?php if ($_SESSION['agregarTutores']=="Y") {?><div class="row-fluid">
                	<a href="tutores.php?p=ntut">Nuevo Tutor</a>                  
                  &nbsp;&nbsp;&nbsp;
                  <?php 
                    $datos = "[";
                    while ($row_tuto = mysql_fetch_assoc($tuto)) { 
                      $datos .= '"'.$row_tuto['cedulaTutor'].'",';
                      $datos .= '"'.$row_tuto['nombreTutor'].'",';
                      $datos .= '"'.$row_tuto['apellidoTutor'].'",';
                      $datos .= '"'.$row_tuto['profesionTutor'].'",';
                      $datos .= '"'.$row_tuto['postgradoTutor'].'",';
                      $datos .= '"'.$row_tuto['telfTutor'].'",';
                      $datos .= '"'.$row_tuto['emailTutor'].'",';
                    }
                    $datos = substr($datos, 0, -1);
                    $datos .= "]";                    
                  ?>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
                    <input type="text" class="input span4" placeholder="Escriba un dato a buscar (ejm. Nombre, Apellido, Cédula, etc)" name="texto" data-provide="typeahead" data-items="6" 
                    data-source='<?=$datos?>'>
                      <?php if (empty($_POST['texto'])) { ?><button type="submit" class="btn">Buscar</button><?php } else { ?><button type="submit" class="btn">Limpiar Búsqueda</button><?php } ?>
                  </form>

                 <?php //require_once('buscar.php');?>
                </div><?php } ?>
        <div class="row-fluid">
                
                
        <table class="table table-striped">
        <thead>
          <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Profesión</th>
            <th>PostGrado</th>
            <th>Teléfono</th>
            <th>Email</th>
            <?php if ($_SESSION['modificarTutores']=="Y") {?><th>&nbsp;</th><?php } ?>
            <?php if ($_SESSION['eliminarTutores']=="Y") {?><th>&nbsp;</th><?php } ?>
          </tr>
        </thead>
        <tbody>
        
        <?php do { ?>
          <tr>
            <td><?php echo $row_tutores['cedulaTutor']; ?></td>
            <td><?php echo $row_tutores['nombreTutor']; ?></td>
            <td><?php echo $row_tutores['apellidoTutor']; ?></td>
            <td><?php echo $row_tutores['profesionTutor']; ?></td>
            <td><?php echo $row_tutores['postgradoTutor']; ?></td>
            <td><?php echo $row_tutores['telfTutor']; ?></td>
            <td><?php echo $row_tutores['emailTutor']; ?></td>
            <?php if ($_SESSION['modificarTutores']=="Y") {?><td><a href="tutores.php?p=mtut&idTutor=<?php echo $row_tutores['idTutor']; ?>"><i class="icon-edit"></i> Modificar</a></td><?php } ?>
            <?php 
              if ($_SESSION['eliminarTutores']=="Y") {
                $query_restut = "SELECT * FROM tblresumen WHERE idTutor = '".$row_tutores['idTutor']."'";
                $restut = mysql_query($query_restut, $bdresumen) or die(mysql_error());
                $rows_restut = mysql_num_rows($restut);
                if ($rows_restut == 0){ ?>
                  <td><a href="deltut.php?idTutor=<?php echo $row_tutores['idTutor']; ?>" onclick="return confirme();">
                  <i class="icon-remove"></i> Eliminar</a></td>
              <?php 
                } else {
                  echo '<td><i class="icon-remove"></i> Eliminar</td>';
                }
              } ?>

          </tr>
         <?php } while ($row_tutores = mysql_fetch_assoc($tutores)); ?>
        </tbody>
      </table>
                  <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td><?php if ($pageNum_tutores > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_tutores=%d%s", $currentPage, 0, $queryString_tutores); ?>"><img src="img/First.gif" /></a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_tutores > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_tutores=%d%s", $currentPage, max(0, $pageNum_tutores - 1), $queryString_tutores); ?>"><img src="img/Previous.gif" /></a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_tutores < $totalPages_tutores) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_tutores=%d%s", $currentPage, min($totalPages_tutores, $pageNum_tutores + 1), $queryString_tutores); ?>"><img src="img/Next.gif" /></a>
                          <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_tutores < $totalPages_tutores) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_tutores=%d%s", $currentPage, $totalPages_tutores, $queryString_tutores); ?>"><img src="img/Last.gif" /></a>
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
mysql_free_result($tutores);
?>
