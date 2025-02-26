<?php //  Controladores/rutasC.php
class RutasC {
    public function procesaRutasC(){
        /*Verifica si en la URL existe ?ruta=algo.
        Si existe, asigna su valor a $ruta, si no, usa 'index' por defecto.*/
        if (isset($_GET['ruta'])){
            $ruta = $_GET['ruta'];
        }
        else
        {
            $ruta = 'index';
        }
        $rutasM = new RutasM();
        $pagina = $rutasM->procesaRutasM($ruta);

        return $pagina;
    }
    
    public function redirigirSesionC($ruta){
        /*Verifica si $_SESSION["Ingreso"] está vacío.
        Si es así, redirige al usuario a la ruta especificada.*/
        if(!$_SESSION["Ingreso"]){
            header("location:index.php?=$ruta");
            exit();
        }
    }

    public function sesionIniciadaC(){
        /*Verifica si $_SESSION["Ingreso"] está definida.
        Si no existe, devuelve True (indicando que no hay sesión iniciada).*/
        if(!isset($_SESSION['Ingreso']))
            return True; 
    }
}
?>