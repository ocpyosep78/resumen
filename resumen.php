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
        <?php require_once('controlResumen.php');?>
        <?php require_once("footer.php"); ?>
        <?php require_once("btsjavascript.php"); ?>    
    </body>
    <script type="text/javascript">
    $(document).ready(function(){
        $("#idCategoria").change(function () {
            $("#idCategoria option:selected").each(function () {
                idCategoria=$(this).val();
                $.post("filscat.php", { idCategoria: idCategoria }, function(data){
                    $("#idSubcategoria").html("<option value=''>Seleccione un Programa</option>");
                    for (i=0; i<data.subcategoria.id.length; i++) {
                        if ((data.subcategoria.id[i])) {
                            if (i==0) {
                                $('#idSubcategoria').append("<option value='"+data.subcategoria.id[i]+"' selected>"+data.subcategoria.nombre[i]+"</option>");
                            } else {
                                $('#idSubcategoria').append("<option value='"+data.subcategoria.id[i]+"'>"+data.subcategoria.nombre[i]+"</option>");
                            }
                            //alert($('#codigoResumen').val());
                            //$codigo = $codsc."-".($row_r['idResumen']+1);
                        }
                    }
                    $('#codigoResumen').val(data.subcategoria.nextCode[0]);
                }, 'json');        
            });
        });

        
        $("#idSubcategoria").change(function () {
            $("#idSubcategoria option:selected").each(function () {
                idSubcategoria=$(this).val();
                $.post("filscat2.php", { idSubcategoria: idSubcategoria }, function(data){
                    $('#codigoResumen').val(data.subcategoria.nextCode[0]);
                }, 'json');        
            });
        });
        



    });
    </script>
</html>