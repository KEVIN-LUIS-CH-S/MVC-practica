<?php  // Controladores/empleadosC.php
class EmpleadosC {
    function __construct(){
        $this->empleadosM = new EmpleadosM();
    }

    public function registrarEmpleadosC(){
        if(isset($_POST['nombreR'])){
            $datosC =array();
            $datosC['nombre'] = Sanitizar::limpiar($_POST['nombreR']);
            $datosC['apellido'] = Sanitizar::limpiar($_POST['apellidoR']);
            $datosC['email'] = Sanitizar::limpiar($_POST['emailR']);
            $datosC['puesto'] = Sanitizar::limpiar($_POST['puestoR']);
            $datosC['salario'] = Sanitizar::limpiar($_POST['salarioR']);
            $result = $this->empleadosM->registrarEmpleadosM($datosC);
            if (isset($result['status']) && $result['status'] == 'success') {
                responderJSON($result);
            }else{
                responderJSON($result);
            }    
        }
    }

    //mostrar empleados
    public function mostrarEmpleadosC(){
        $result = $this->empleadosM->mostrarEmpleadosM();
        return $result;
    }

    //editar empleados
    public function editarEmpleadoC(){
        if(isset($_GET['id'])){
            $datosC = array('id'=>$_GET['id']);
            $result = $this->empleadosM->editarEmpleadoM($datosC);
            return $result;
        }
    }

    //actualizar empleados
    public function actualizarEmpleadoC(){
        if(isset($_POST['nombreE'])){
            $datosC = array(    'id'=>Sanitizar::limpiar($_POST['idE']),
                                'nombre'=>Sanitizar::limpiar($_POST['nombreE']),
                                'apellido'=>Sanitizar::limpiar($_POST['apellidoE']),
                                'email' =>Sanitizar::limpiar($_POST['emailE']),
                                'puesto' =>Sanitizar::limpiar($_POST['puestoE']),
                                'salario' =>Sanitizar::limpiar($_POST['salarioE'])
                            );
            $result = $this->empleadosM->actualizarEmpleadoM($datosC);
            responderJSON($result);
        }
    }

    public function buscarEmpleadoC($letras){
            $result = $this->empleadosM->buscarEmpleadoM($letras);
            responderJSON($result);
        }

    public function contarEmpleadosPorPuestoC(){
        $datos = $this->empleadosM->contarEmpleadosPorPuestoM(); 
        
        $labels = array_column($datos, 'puesto');
        $values = array_column($datos, 'cantidad');

        responderJSON(['labels' => $labels, 'values' => $values]);
    }
        
    
    //borrar empleado
    public function borrarEmpleadoC(){
        if(isset($_GET['id'])){
            $datosC = array('id' => $_GET['id']);
            $result=$this->empleadosM->borrarEmpleadoM($datosC);
            responderJSON($result);
        }
    }
}
?>