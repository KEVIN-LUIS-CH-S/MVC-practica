<?php //  Modelos/rutasM.php
class RutasM{
    public function procesaRutasM($ruta){
        if( $ruta == "ingresoAdmin" ||
            $ruta == "registroAdmin" || 
            $ruta == 'empleados' || 
            $ruta == 'registrar' || 
            $ruta == 'salir' ||
            $ruta == 'editar')
        {
            $pagina = "Vistas/modulos/".$ruta. ".php";
        }
        else if($ruta == 'index'){
            $pagina = "Vistas/modulos/ingresoAdmin.php";
        }
        else {
            $pagina = "Vistas/modulos/ingresoAdminphp";
        }
        return $pagina;
    }

}
?>