<?php
    //Controlador de la vista de administrador
    $RecOpcion=$_GET['opcion'];
        
    if($RecOpcion==1){
        include("../view/ListaProductos.php");
    }else if($RecOpcion==2){
        include("../view/ListarClientes.php");
    }else if($RecOpcion==3){
        include("../reportes/Reportes.php");
    }else if($RecOpcion==4){
        include("../view/viewAdquisiciones.php");
    }else if($RecOpcion==5){
        include("../model/ReporteDatos.php");
        
    }else{
        echo "ninguna opción";
    }

?>