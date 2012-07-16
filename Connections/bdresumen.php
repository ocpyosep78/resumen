<?php
	# FileName="Connection_php_mysql.htm"
	# Type="MYSQL"
	# HTTP="true"
	$hostname_bdresumen = "localhost";
	$database_bdresumen = "bdresumen";
	$username_bdresumen = "root";
	$password_bdresumen = "root";
	$bdresumen = mysql_pconnect($hostname_bdresumen, $username_bdresumen, $password_bdresumen) or trigger_error(mysql_error(),E_USER_ERROR);
	
	mysql_select_db($database_bdresumen, $bdresumen);
	$query_configuracion = "SELECT * FROM tblconfiguraciones";
	$configuracion = mysql_query($query_configuracion, $bdresumen) or die(mysql_error());
	$row_configuracion = mysql_fetch_assoc($configuracion);
	$totalRows_configuracion = mysql_num_rows($configuracion);

	define("DIAS_ACTIVIDAD",$row_configuracion['dias_actConfiguraciones']);

	function sdate_diff($start, $end="NOW")
	{
	        $sdate = strtotime($start);
	        $edate = strtotime($end);
	        
	        $time = $edate - $sdate;
	        if($time>=0 && $time<=59) {
	                // Seconds
	                $timeshift = $time.' seconds ';

	        } elseif($time>=60 && $time<=3599) {
	                // Minutes + Seconds
	                $pmin = ($edate - $sdate) / 60;
	                $premin = explode('.', $pmin);
	               
	                $presec = $pmin-$premin[0];
	                $sec = $presec*60;
	               
	                $timeshift = $premin[0].' min '.round($sec,0).' sec ';

	        } elseif($time>=3600 && $time<=86399) {
	                // Hours + Minutes
	                $phour = ($edate - $sdate) / 3600;
	                $prehour = explode('.',$phour);
	               
	                $premin = $phour-$prehour[0];
	                $min = explode('.',$premin*60);
	               
	                $presec = '0.'.$min[1];
	                $sec = $presec*60;

	                $timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

	        } elseif($time>=86400) {
	                // Days + Hours + Minutes
	                $pday = ($edate - $sdate) / 86400;
	                $preday = explode('.',$pday);

	                $phour = $pday-$preday[0];
	                $prehour = explode('.',$phour*24);

	                $premin = ($phour*24)-$prehour[0];
	                $min = explode('.',$premin*60);
	               
	                $presec = '0.'.$min[1];
	                $sec = $presec*60;
	               
	                $timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

	        }
	        // return $timeshift;
	        return $preday[0];
	}

?>
