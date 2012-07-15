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

$maxRows_usuarios = 20;
$pageNum_usuarios = 0;
if (isset($_GET['pageNum_usuarios'])) {
  $pageNum_usuarios = $_GET['pageNum_usuarios'];
}
$startRow_usuarios = $pageNum_usuarios * $maxRows_usuarios;

mysql_select_db($database_bdresumen, $bdresumen);
if (empty($_POST['texto'])) {
  $query_usuarios = "SELECT * FROM tblusuario ORDER BY nombreUsuario ASC";
} else {
  $query_usuarios = "SELECT * FROM tblusuario WHERE nombreUsuario LIKE '%".$_POST['texto']."%' OR apellidoUsuario LIKE '%".$_POST['texto']."%' OR loginUsuario LIKE '%".$_POST['texto']."%' OR cedulaUsuario LIKE '%".$_POST['texto']."%' ORDER BY nombreUsuario ASC";
}
$query_limit_usuarios = sprintf("%s LIMIT %d, %d", $query_usuarios, $startRow_usuarios, $maxRows_usuarios);
$usuarios = mysql_query($query_limit_usuarios, $bdresumen) or die(mysql_error());
$usu = mysql_query($query_limit_usuarios, $bdresumen) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);

if (isset($_GET['totalRows_usuarios'])) {
  $totalRows_usuarios = $_GET['totalRows_usuarios'];
} else {
  $all_usuarios = mysql_query($query_usuarios);
  $totalRows_usuarios = mysql_num_rows($all_usuarios);
}
$totalPages_usuarios = ceil($totalRows_usuarios/$maxRows_usuarios)-1;

$queryString_usuarios = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_usuarios") == false && 
        stristr($param, "totalRows_usuarios") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_usuarios = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_usuarios = sprintf("&totalRows_usuarios=%d%s", $totalRows_usuarios, $queryString_usuarios);
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
				<h2>Usuarios</h2>
                <?php if ($_SESSION['agregarUsuario']=="Y") {?><div class="row-fluid">
                	<a href="usuarios.php?p=nusu">Nuevo Usuario</a>
                  &nbsp;&nbsp;&nbsp;
                  <?php 
                    $datos = "[";
                    while ($row_usu = mysql_fetch_assoc($usu)) { 
                      $datos .= '"'.$row_usu['cedulaUsuario'].'",';
                      $datos .= '"'.$row_usu['nombreUsuario'].'",';
                      $datos .= '"'.$row_usu['apellidoUsuario'].'",';
                      $datos .= '"'.$row_usu['loginUsuario'].'",';
                    }
                    $datos = substr($datos, 0, -1);
                    $datos .= "]";                    
                  ?>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
                    <input type="text" class="input span4" placeholder="Escriba un dato a buscar (ejm. Cédula, Nombre, Apellido, Login)" name="texto" data-provide="typeahead" data-items="6" 
                    data-source='<?=$datos?>'>
                      <?php if (empty($_POST['texto'])) { ?><button type="submit" class="btn">Buscar</button><?php } else { ?><button type="submit" class="btn">Limpiar Búsqueda</button><?php } ?>
                  </form>
                </div><?php } ?>
				<div class="row-fluid">
				  <table class="table table-striped">
        <thead>
          <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Login</th>
            <th>Status</th>
            <?php if ($_SESSION['modificarUsuario']=="Y") {?><th>&nbsp;</th>
            <th>&nbsp;</th><?php } ?>
            <?php if ($_SESSION['eliminarUsuario']=="Y") {?><th>&nbsp;</th><?php } ?>
          </tr>
        </thead>
        <tbody>
        
        <?php do { ?>
          <tr>
          	<td><?php echo $row_usuarios['cedulaUsuario']; ?></td>
            <td><?php echo $row_usuarios['nombreUsuario']; ?></td>
            <td><?php echo $row_usuarios['apellidoUsuario']; ?></td>
            <td><?php echo $row_usuarios['loginUsuario']; ?></td>
            <?php if ($_SESSION['modificarUsuario']=="Y") {?><td><?php if ($row_usuarios['statusUsuario']=='A') { echo "Activo"; } else { echo "Inactivo";}?></td>
            <td><a href="usuarios.php?p=pusu&idUsuario=<?php echo $row_usuarios['idUsuario']; ?>"><i class="icon-lock"></i> Permisos</a></td>
            <td><a href="usuarios.php?p=musu&idUsuario=<?php echo $row_usuarios['idUsuario']; ?>"><i class="icon-edit"></i> Modificar</a></td><?php } ?>
            <?php if ($_SESSION['eliminarUsuario']=="Y") {?><td><a href="delusu.php?idUsuario=<?php echo $row_usuarios['idUsuario']; ?>" onclick="return confirme();"><i class="icon-remove"></i> Eliminar</a></a></td><?php } ?>
          </tr>
         <?php } while ($row_usuarios = mysql_fetch_assoc($usuarios)); ?>
        </tbody>
      </table>
             
                    
                  <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td><?php if ($pageNum_usuarios > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, 0, $queryString_usuarios); ?>"><img src="img/First.gif" /></a>
                      <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_usuarios > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, max(0, $pageNum_usuarios - 1), $queryString_usuarios); ?>"><img src="img/Previous.gif" /></a>
                      <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_usuarios < $totalPages_usuarios) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, min($totalPages_usuarios, $pageNum_usuarios + 1), $queryString_usuarios); ?>"><img src="img/Next.gif" /></a>
                      <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_usuarios < $totalPages_usuarios) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, $totalPages_usuarios, $queryString_usuarios); ?>"><img src="img/Last.gif" /></a>
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
mysql_free_result($usuarios);
?>
