<?php require_once("cop.php") ?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once("cabeceras.php");?>
        <script src="js/gen_validatorv4.js" type="text/javascript"></script>
	</head>
    <body>
        <?php require_once("header.php");?>
        <?php require_once("datasesion.php");?>
        <?php require_once('controlSc.php');?>
        <?php require_once("footer.php"); ?>
        <?php require_once("btsjavascript.php"); ?>
    </body>
    <script type="text/javascript">
    $(document).ready(function(){        
        $('.mostrar').hide();
        $("#categoria").change(function () {
            $("#categoria option:selected").each(function () {
                idCategoria=$(this).val();
                $('.mostrar').show('slow');
                $.post("filscat.php", { idCategoria: idCategoria }, function(data){
                    $("#area").html("");
                    for (i=0; i<data.area.id.length; i++) {
                        if ((data.area.id[i])) {

                            $('#area').append("<option value='"+data.area.id[i]+"'>"+data.area.nombre[i]+"</option>");
                            
                        }
                    }

                }, 'json');        
            });
        });
        /*$("#idArea").change(function () {
            $("#idArea option:selected").each(function () {
                idArea=$(this).val();
                idCategoria=$("idCategoria").val();
                $.post("filscatba.php", { idArea: idArea, idCategoria: idCategoria }, function(data){
                    $("#idSubcategoria").html("<option value=''>Todos los Programas</option>");
                    for (i=0; i<data.subcategoria.id.length; i++) {
                        if ((data.subcategoria.id[i])) {
                            $('#idSubcategoria').append("<option value='"+data.subcategoria.id[i]+"'>"+data.subcategoria.nombre[i]+"</option>");
                        }
                    }
                }, 'json');        
            });
        });*/
    });
    </script>
</html>