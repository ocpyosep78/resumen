<!DOCTYPE html>
<html>
	<head>
		<?php require_once("cabeceras.php");?>
	</head>
    <body class="no-js">
        <?php require_once("header.php");?>
        <?php require_once("controlIndex.php");?>
        <?php //require_once("menuInferior.php"); ?>
        <?php require_once("footer.php"); ?>
        <?php require_once("btsjavascript.php"); ?>
    </body>
    <script type="text/javascript">
    $(document).ready(function(){        
        $('.mostrar').hide();
        $("#idCategoria").change(function () {
            $("#idCategoria option:selected").each(function () {
                idCategoria=$(this).val();
                $('.mostrar').show('slow');
                $.post("filscat.php", { idCategoria: idCategoria }, function(data){
                    $("#idSubcategoria").html("<option value=''>Todos los Programas</option>");
                    for (i=0; i<data.subcategoria.id.length; i++) {
                        if ((data.subcategoria.id[i])) {
                            $('#idSubcategoria').append("<option value='"+data.subcategoria.id[i]+"'>"+data.subcategoria.nombre[i]+"</option>");
                        }
                    }
                }, 'json');        
            });
        });
    });
    </script>
</html>