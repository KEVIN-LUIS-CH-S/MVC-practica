<?php  //Controladores/adminC.php
class AdminC{
    function __construct(){
        $this->adminM = new AdminM();
    }

    public function ingresoC(){
        if(isset($_SESSION['Ingreso']))
            header("location: index.php?ruta=empleados");

        if(isset($_POST["usuarioI"])){
            $datosC = array(    
                        "usuario"=>Sanitizar::limpiar($_POST["usuarioI"]), 
                        "clave"=>Sanitizar::limpiar($_POST["claveI"]));
            $result = $this->adminM->ingresoM($datosC);
            
            if ($result && password_verify($datosC['clave'], $result['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start(); // Iniciar sesión solo si no está activa
                }
                $_SESSION['Ingreso'] = true;
                $_SESSION['usuario_id'] = $result['id'];
                $_SESSION['usuario_nombre'] = $result['usuario'];

                responderJSON(["status" => "success", "message" => "¡Bienvenido {$result['usuario']}!"]);
            } else {
                responderJSON(["status" => "error", "message" => "Usuario o contraseña incorrectos."]);
            }
        }
    }

    public function registrarUsuarioC(){
        if (isset($_POST['usuarioR'])) {
            $datosC = array(
                        'usuario' => Sanitizar::limpiar($_POST['usuarioR']),
                        'email' => Sanitizar::limpiar($_POST['emailR']),
                        'password' => Sanitizar::limpiar($_POST['passwordR'])
                    );
            //Verificar si el usuario ya existe
            $result = $this->adminM->verificarUsuarioM($datosC);
            if (isset($result['status']) && $result['status'] == 'error') {
                responderJSON($result);
            }
            //Registrar nuevo usuario
            $result = $this->adminM->registrarUsuarioM($datosC);
            responderJSON($result);
        }
    }

    public function salirC(){
        session_destroy();
        header("location:index.php?=ingreso");
    }
}
?>