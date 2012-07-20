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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $colname_s = "-1";
  
  if (isset($_POST['idCategoria'])) {
    $colname_s = $_POST['idCategoria'];
  }
  if (isset($_POST['idArea'])) {
    $colname_s2 = $_POST['idArea'];
  }

  mysql_select_db($database_bdresumen, $bdresumen);
  $query_s = sprintf("SELECT * FROM tblcat_area WHERE idCategoria = %s AND idArea = %s", GetSQLValueString($colname_s, "int"), GetSQLValueString($colname_s2, "int"));
  $s = mysql_query($query_s, $bdresumen) or die(mysql_error());
  $row_s = mysql_fetch_assoc($s);
  $totalRows_s = mysql_num_rows($s);

  if ($totalRows_s==0) {
      $insertSQL = sprintf("INSERT INTO tblcat_area (idCategoria,idArea) VALUES (%s,%s)",
                           GetSQLValueString($_POST['idCategoria'], "int"),
                           GetSQLValueString($_POST['idArea'], "int"));

      mysql_select_db($database_bdresumen, $bdresumen);
      $Result1 = mysql_query($insertSQL, $bdresumen) or die(mysql_error());

      // $updateGoTo = "categorias.php?p=mcar";
      // header(sprintf("Location: %s", $insertGoTo));
  } else {
    $error = "El Registro ya ha sido asignado";
  }

}

mysql_select_db($database_bdresumen, $bdresumen);
$query_areas = "SELECT t1.* FROM (SELECT idArea, nombreArea FROM tblareas UNION ALL SELECT idArea, idCategoria FROM tblcat_area WHERE idCategoria = '".$_GET['idCategoria']."') t1 GROUP BY t1.idArea HAVING COUNT(*) = 1";
$areas = mysql_query($query_areas, $bdresumen) or die(mysql_error());
$row_areas = mysql_fetch_assoc($areas);
$totalRows_areas = mysql_num_rows($areas);

$colname_categorias = "-1";
if (isset($_GET['idCategoria'])) {
  $colname_categorias = $_GET['idCategoria'];
}

mysql_select_db($database_bdresumen, $bdresumen);
$query_categorias = sprintf("SELECT * FROM tblcategoria WHERE idCategoria = %s", GetSQLValueString($colname_categorias, "int"));
$categorias = mysql_query($query_categorias, $bdresumen) or die(mysql_error());
$row_categorias = mysql_fetch_assoc($categorias);
$totalRows_categorias = mysql_num_rows($categorias);

$colname_car = "-1";
if (isset($_GET['idCategoria'])) {
  $colname_car = $_GET['idCategoria'];
}

mysql_select_db($database_bdresumen, $bdresumen);
$query_car = sprintf("SELECT ca.*, a.nombreArea FROM tblcat_area ca, tblareas a WHERE ca.idCategoria = %s AND ca.idArea = a.idArea", GetSQLValueString($colname_car, "int"));
$car = mysql_query($query_car, $bdresumen) or die(mysql_error());
$row_car = mysql_fetch_assoc($car);
$totalRows_car = mysql_num_rows($car);

?>
<div style="margin:20px;">
  <div class="container-fluid" style="margin:auto">
  	<div class="row-fluid">
        <div class="span12">
          <div class="well">
            <h2>Menú Principal</h2>
            <div class="row-fluid">
            	<?php require_once('menuBk2.php');?>
            </div>
          </div>                    
        </div><!--/span-->
        <div class="span12">
          <div class="well">
            <h2>Asignar Áreas al Postgrado: <?php echo $row_categorias['nombreCategoria'];?></h2>
            <div class="atras"><button class="btn btn-success" onclick='window.location="categorias.php"'><i class="icon-chevron-left icon-white"></i>&nbsp;Atrás</button></div>
            &nbsp;&nbsp;&nbsp;
            <form action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>" method="post" class="form-inline">
              <label class="control-label" for="idArea">Áreas</label>
              <select id="idArea" name="idArea">
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
              <button type="submit" class="btn btn-primary">Asignar</button>
              <input type="hidden" name="MM_insert" value="form">
              <input type="hidden" name="idCategoria" value="<?php echo $_GET['idCategoria'];?>" >
              <?php 
              if(!empty($error)){
              ?>
              <div class="alert alert-error">
                <a class="close" data-dismiss="alert">×</a>
                <strong>¡OOOPS!</strong> <?php echo $error;?>
              </div>
              <?php } ?>
            </form>
            <div class="row-fluid">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Área</th>
                      <?php if ($_SESSION['modificarCategorias']=="Y") {?><th>&nbsp;</th><?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                  
                  <?php do { ?>
                    <tr>
                      <td><?php echo $row_car['nombreArea']; ?></td>
                      <?php if ($_SESSION['modificarCategorias']=="Y") {?><td><a href="delcar.php?idCat_area=<?php echo $row_car['idCat_area']; ?>&idCategoria=<?php echo $row_categorias['idCategoria'];?>" onclick="return confirme();"><i class="icon-remove"></i> Quitar</a></a></td><?php } ?>
                    </tr>
                   <?php } while ($row_car = mysql_fetch_assoc($car)); ?>
                  </tbody>
              </table>
            </div>
          </div>
        </div>                    
    </div><!--/span-->
  </div>
</div>
