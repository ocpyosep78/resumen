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

$maxRows_responses = 15;
$pageNum_responses = 0;
if (isset($_GET['pageNum_responses'])) {
  $pageNum_responses = $_GET['pageNum_responses'];
}
$startRow_responses = $pageNum_responses * $maxRows_responses;

$colname_responses = "-1";
if (isset($_GET['letter'])) {
  $colname_responses = $_GET['letter'];
}
mysql_select_db($database_bdresumen, $bdresumen);
$query_responses = sprintf("SELECT r.* FROM tblresumen r WHERE UPPER(LEFT(r.tituloResumen, 1))=%s", 
							GetSQLValueString($colname_responses, "text"));
$query_limit_responses = sprintf("%s LIMIT %d, %d", $query_responses, $startRow_responses, $maxRows_responses);
$responses = mysql_query($query_limit_responses, $bdresumen) or die(mysql_error());
$row_responses = mysql_fetch_assoc($responses);

if (isset($_GET['totalRows_responses'])) {
  $totalRows_responses = $_GET['totalRows_responses'];
} else {
  $all_responses = mysql_query($query_responses);
  $totalRows_responses = mysql_num_rows($all_responses);
}
$totalPages_responses = ceil($totalRows_responses/$maxRows_responses)-1;

$queryString_responses = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_responses") == false && 
        stristr($param, "totalRows_responses") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_responses = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_responses = sprintf("&totalRows_responses=%d%s", $totalRows_responses, $queryString_responses);

?>
<div style="margin:20px;">
    <div class="container-fluid" style="margin:auto">
        <div class="row-fluid">
        	<div class="span12">
          		<h1>Resultados de la Búsqueda</h1>
          		<p>¿No encontraste lo que buscabas? <a href="index.php">Vuelve a Intentarlo</a></p>
                <div class="span5">
                    <ul class="pager">
                        <?php if ($pageNum_responses > 0) { // Show if not first page ?>
                        <li class="previous"><a href="<?php printf("%s?pageNum_responses=%d%s", $currentPage, 0, $queryString_responses); ?>">← Primero</a></li>
                        <?php } // Show if not first page ?>
                    
                        <?php if ($pageNum_responses > 0) { // Show if not first page ?>
                        <li class="previous"><a href="<?php printf("%s?pageNum_responses=%d%s", $currentPage, max(0, $pageNum_responses - 1), $queryString_responses); ?>">← Anterior</a></li>
                        <?php } // Show if not first page ?>
            
                        <?php if ($pageNum_responses < $totalPages_responses) { // Show if not last page ?>
                        <li class="next"><a href="<?php printf("%s?pageNum_responses=%d%s", $currentPage, $totalPages_responses, $queryString_responses); ?>">Último →</a></li>
                        <?php } // Show if not last page ?>
                        
                        <?php if ($pageNum_responses < $totalPages_responses) { // Show if not last page ?>
                        <li class="next"><a href="<?php printf("%s?pageNum_responses=%d%s", $currentPage, min($totalPages_responses, $pageNum_responses + 1), $queryString_responses); ?>">Siguiente →</a></li>
                        <?php } // Show if not last page ?>
                    </ul>
                </div>
          	</div>
        </div>
            <?php
				$rfluids = 1;
        		do {
			?>
            <?php
            	if ($rfluids == 1) {
			?>
        	<div class="row-fluid">
            <?php
				}
			?>
            	<div class="span4">
            		<h2><a href="index.php?p=res&idResumen=<?php echo $row_responses['idResumen'];?>"><?php echo $row_responses['tituloResumen'];?></a></h2>
            		<p><?php echo substr(strip_tags($row_responses['textoResumen']),0,300)."...";?></p>
            	</div>
            <?php
            	if ($rfluids == 3) {
			?>
        	</div><!--/row-fluid-->
            <?php
            $rfluids = 0;
				}
			?>
            <?php
				$rfluids++;
				} while($row_responses = mysql_fetch_assoc($responses));
			?>
        
        <div class="row-fluid">
        	<div class="span12">
            	<div class="span5">
                    <ul class="pager">
                        <?php if ($pageNum_responses > 0) { // Show if not first page ?>
                        <li class="previous"><a href="<?php printf("%s?pageNum_responses=%d%s", $currentPage, 0, $queryString_responses); ?>">← Primero</a></li>
                        <?php } // Show if not first page ?>
                    
                        <?php if ($pageNum_responses > 0) { // Show if not first page ?>
                        <li class="previous"><a href="<?php printf("%s?pageNum_responses=%d%s", $currentPage, max(0, $pageNum_responses - 1), $queryString_responses); ?>">← Anterior</a></li>
                        <?php } // Show if not first page ?>
            
                        <?php if ($pageNum_responses < $totalPages_responses) { // Show if not last page ?>
                        <li class="next"><a href="<?php printf("%s?pageNum_responses=%d%s", $currentPage, $totalPages_responses, $queryString_responses); ?>">Último →</a></li>
                        <?php } // Show if not last page ?>
                        
                        <?php if ($pageNum_responses < $totalPages_responses) { // Show if not last page ?>
                        <li class="next"><a href="<?php printf("%s?pageNum_responses=%d%s", $currentPage, min($totalPages_responses, $pageNum_responses + 1), $queryString_responses); ?>">Siguiente →</a></li>
                        <?php } // Show if not last page ?>
                    </ul>
                </div>
        	</div>
        </div>
        
        
        <div class="row-fluid">
        	<div class="span12">
        		<hr class="soften">
        	</div>
        </div>
        
  </div>
</div>
<?php
mysql_free_result($responses);
?>
