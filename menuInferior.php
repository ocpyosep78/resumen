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
$query_categorias = "SELECT * FROM tblcategoria";
$categorias = mysql_query($query_categorias, $bdresumen) or die(mysql_error());
$row_categorias = mysql_fetch_assoc($categorias);
$totalRows_categorias = mysql_num_rows($categorias);

mysql_select_db($database_bdresumen, $bdresumen);
$query_subcategorias = "SELECT * FROM tblsubcategorias";
$subcategorias = mysql_query($query_subcategorias, $bdresumen) or die(mysql_error());
$row_subcategorias = mysql_fetch_assoc($subcategorias);
$totalRows_subcategorias = mysql_num_rows($subcategorias);
?>
<!--<div class="row-fluid">
      	<div class="span12">
        	<div class="well">
            	<div class="row-fluid"-->
        			<div class="well">
                		<ul class="nav nav-list">
                    		<li class="nav-header">Categorias</li>
                            <?php do {?>
                        	<li><a href="index.php?p=responses&idCategoria=<?php echo $row_categorias['idCategoria']; ?>"> <?php echo $row_categorias['nombreCategoria']; ?></a></li>
							<?php } while($row_categorias = mysql_fetch_assoc($categorias));?>
                    	</ul>
					</div>
                	<div class="well">
                		<ul class="nav nav-list">
                    		<li class="nav-header">Programas</li>
                        	<?php do {?>
                        	<li><a href="index.php?p=responses&idSubcategoria=<?php echo $row_subcategorias['idSubcategoria']; ?>"> <?php echo $row_subcategorias['nombreSubcategoria']; ?></a></li>
							<?php } while($row_subcategorias = mysql_fetch_assoc($subcategorias));?>
                    	</ul>
					</div>
                <!--/div>
            </div> 
        <</div>
      
      </div-->
<?php
mysql_free_result($categorias);

mysql_free_result($subcategorias);
?>
