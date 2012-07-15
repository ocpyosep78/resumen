<?php require_once("cop.php") ?>
<div style="margin:20px;">
<div class="container-fluid" style="margin:auto">
	<div class="row-fluid">
        <div class="span12">
          <div class="well">
            <!--img src="img/1330457085_search_green.png" width="50" height="50"--><h2 style="margin:10px auto; max-width:40%">Selecione una Opción</h2>
                <div class="row-fluid" style="margin:auto; width:70%">
                	<div class="menu_iconos">
           	      		<?php if ($_SESSION['modTutores']=="Y") {?><div id="item"><a href="tutores.php"><img src="img/tutores.png" width="48" height="48" /><div id="text">Tutores</div></a></div><?php } ?>
                        <?php if ($_SESSION['modCategorias']=="Y") {?><div id="item"><a href="categorias.php"><img src="img/categoria1.png" width="48" height="48" /><div id="text">Postgrado</div></a></div><?php } ?>
                        <?php if ($_SESSION['modSubcategorias']=="Y") {?><div id="item"><a href="subcategorias.php"><img src="img/subcategorias.png" width="48" height="48" /><div id="text">Programas</div></a></div><?php } ?>
                        <?php if ($_SESSION['modArea']=="Y") {?><div id="item"><a href="areas.php"><img src="img/areas.png" width="48" height="48" /><div id="text">Áreas</div></a></div><?php } ?>
                    </div>
                </div>
                <div class="row-fluid" style="margin:auto; width:70%">
                    <div class="menu_iconos">
                    	<?php if ($_SESSION['modUbicaciones']=="Y") {?><div id="item"><a href="ubicaciones.php"><img src="img/ubicaciones.png" width="48" height="48" /><div id="text">Ubicaciones</div></a></div><?php } ?>
                        <?php if ($_SESSION['modUsuario']=="Y") {?><div id="item"><a href="usuarios.php"><img src="img/usuarios.png" width="48" height="48" /><div id="text">Usuarios</div></a></div><?php } ?>
                        <?php if ($_SESSION['modResumen']=="Y") {?><div id="item"><a href="resumen.php"><img src="img/resumenGay.png" width="48" height="48" /><div id="text">Resumen</div></a></div><?php } ?>
                        <?php if ($_SESSION['nombreUsuario']=="Administrador") {?><div id="item"><a href="configuracion.php"><img src="img/configuracion.png" width="48" height="48" /><div id="text">Configuraciones</div></a></div><?php } ?>
                    </div>
                </div>
          </div>                    
        </div><!--/span-->
      </div>
</div>
