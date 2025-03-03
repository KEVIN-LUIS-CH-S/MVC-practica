<?php //  Modelos/rutasM.php
class RutasM{
    public function procesaRutasM($ruta){
        if( $ruta == "ingresoAdmin" ||
            $ruta == 'recuperarContra' ||
            $ruta == "registroAdmin" || 
            $ruta == 'dashboard' ||
            $ruta == 'empleados' ||
            $ruta == 'registrarEmple' ||
            $ruta == 'editarEmple' ||
            $ruta == 'salir')
        {
            $pagina = "Vistas/modulos/".$ruta. ".php";
        }
        else if($ruta == 'index'){
            $pagina = "Vistas/modulos/ingresoAdmin.php";
        }
        else {
            $pagina = "Vistas/modulos/ingresoAdmin.php";
        }
        return $pagina;
    }

}
?>