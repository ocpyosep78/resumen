<!-- El javascript
    ================================================== -->
    <!-- Colocado al final del documento para que la página cargue más rápido -->
    <script src="js/jquery-1.7.1.min.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    
    <script src="js/source.js" type="text/javascript"></script>
        
    <script  src="js/default.js"type="text/javascript"></script>

    <script type="text/javascript">
    /*$(document).ready(function(){
        $("#idCategoria").change(function () {
            $("#idCategoria option:selected").each(function () {
                idCategoria=$(this).val();
                $.post("filscat.php", { idCategoria: idCategoria }, function(data){
                    $("#idSubcategoria").html("<option value=''>Todas los Programas</option>");
                    for (i=0; i<data.subcategoria.id.length; i++) {
                        if ((data.subcategoria.id[i])) {
                            $('#idSubcategoria').append("<option value='"+data.subcategoria.id[i]+"'>"+data.subcategoria.nombre[i]+"</option>");
                        }
                    }
                }, 'json');        
            });
        });
    });*/
    </script>