                    <?php
                    	
						$current = explode('/',$_SERVER['PHP_SELF']);
						$active = explode('.',$current[2]);
					
					?>
                    <ul class="nav nav-pills">
                    	<li <?php if ($active[0]=='backend') { ?> class="active" <?php } ?>><a href="backend.php">Inicio</a></li>
                      	<?php if ($_SESSION['modTutores']=="Y") {?><li<?php if ($active[0]=='tutores') { ?> class="active" <?php } ?>><a href="tutores.php">Tutores</a></li><?php } ?>
                        <?php if ($_SESSION['modCategorias']=="Y") {?><li <?php if ($active[0]=='categorias') { ?> class="active" <?php } ?>><a href="categorias.php">Postgrados</a></li><?php } ?>
                        <?php if ($_SESSION['modSubcategorias']=="Y") {?><li <?php if ($active[0]=='subcategorias') { ?> class="active" <?php } ?>><a href="subcategorias.php">Programas</a></li><?php } ?>
                        <?php if ($_SESSION['modArea']=="Y") {?><li <?php if ($active[0]=='areas') { ?> class="active" <?php } ?>><a href="areas.php">Áreas</a></li><?php } ?>
                        <?php if ($_SESSION['modUbicaciones']=="Y") {?><li <?php if ($active[0]=='ubicaciones') { ?> class="active" <?php } ?>><a href="ubicaciones.php">Ubicaciones</a></li><?php } ?>
                        <?php if ($_SESSION['modUsuario']=="Y") {?><li <?php if ($active[0]=='usuarios') { ?> class="active" <?php } ?>><a href="usuarios.php">Usuarios</a></li><?php } ?>
                        <?php if ($_SESSION['modResumen']=="Y") {?><li <?php if ($active[0]=='resumen') { ?> class="active" <?php } ?>><a href="resumen.php">Resumen</a></li><?php } ?>
                        <?php if ($_SESSION['nombreUsuario']=="Administrador") {?><li <?php if ($active[0]=='configuracion') { ?> class="active" <?php } ?>><a href="configuracion.php">Configuraciones</a></li><?php } ?>
                    </ul>
