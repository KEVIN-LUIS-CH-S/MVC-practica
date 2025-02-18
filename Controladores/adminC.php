<?php  //Controladores/adminC.php
class AdminC{
    function __construct(){
        $this->adminM = new AdminM();
    }

    public function IngresoC(){
        if(isset($_SESSION['Ingreso']))
            header("location: index.php?ruta=empleados");
        if(isset($_POST["usuarioI"])){
            $datosC = array(    
                        "usuario"=>$_POST["usuarioI"], 
                        "clave"=>$_POST["claveI"]);
            $result = $this->adminM->IngresoM($datosC);
            if(isset($result)){
                session_start();
                $_SESSION['Ingreso']=true;
                header("location: index.php?ruta=empleados");
            }
            else
                echo "ERROR AL INGRESAR";
        }
    }

    public function registrarUsuarioC(){
        if(isset($_POST['usuarioR'])){
            $datosC=array('usuario'=>Sanitizar::limpiar($_POST['usuarioR']),
                          'correo'=>Sanitizar::limpiar($_POST['correoR']),
                          'password'=>Sanitizar::limpiar($_POST['passwordR']));
            $result=$this->adminM->verificarUsuarioM($datosC);
            if(isset($result['status']) && $result['status'] == 'error'){
                echo json_encode($result);
            }
            else{
                $result=$this->adminM->registrarUsuarioM($datosC);
                echo json_encode($result);
            }
            //header('location: index.php?ruta=ingreso'); manejar la redireccion en el frontend
        }
    }

    public function salirC(){
        session_destroy();
        header("location:index.php?=ingreso");
    }
}
?>