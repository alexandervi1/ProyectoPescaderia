<?php
    //Controlador de la vista de administrador
    $RecOpcion=$_GET['opcion'];
        
    if($RecOpcion==1){
        include("../view/ListaProductos.php");
    }else if($RecOpcion==2){
        include("../view/viewIngreso.php");
    }else if($RecOpcion==3){
        include("../view/viewRegistroVentas.php");
    }else if($RecOpcion==4){
        include("../view/viewAdquisiciones.php");
    }else if($RecOpcion==5){
        include("../model/ReporteDatos.php");
    }else{
        echo "ninguna opción";
    }

?>