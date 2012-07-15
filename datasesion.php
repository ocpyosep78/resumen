<?php require_once("cop.php") ?>
<div id="datasesion" class="datasesion">
	<span>
    	<button alt="Cerrar Sesion" title="Cerrar Sesion" class="btn btn-small btn-inverse" onclick="window.location='cop.php?salir'" />
        <i class="icon-off icon-white"></i>&nbsp;Salir
        </button>    
    	<!--button class="btn btn-primary btn-short" onClick="window.location='cop.php?salir'">Cerrar Sesion</button-->
    </span>
    <span id="texto">
		<?php echo $_SESSION['nombreUsuario']." ".$_SESSION['apellidoUsuario']; ?>
	</span>
    
</div>