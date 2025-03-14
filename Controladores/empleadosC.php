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
            $datosC['idAdmin'] = $_POST['idAdmin'];
            $result = $this->empleadosM->registrarEmpleadosM($datosC);
            if (isset($result['status']) && $result['status'] == 'success') {
                responderJSON($result);
            }else{
                responderJSON($result);
            }    
        }
    }

    public function obtenerPuestosC(){
        $result=$this->empleadosM->obtenerPuestosM();
        return $result;
    }

    //mostrar empleados
    public function mostrarEmpleadosC($idAdmin){
        $idAdministrador=$idAdmin;
        $result = $this->empleadosM->mostrarEmpleadosM($tabla='empleados',$idAdministrador);
        return $result;
    }

    //editar empleados
    public function editarEmpleadoC(){
        if(isset($_GET['id'])){
            $datosC = array('id'=>$_GET['id']);
            $result = $this->empleadosM->editarEmpleadoM($datosC);
            return $result;
        }
        return null;
    }

    //actualizar empleados
    public function actualizarEmpleadoC(){
        if(isset($_POST['nombreE'])){
            $datosC = array(    'id'=>Sanitizar::limpiar($_POST['idE']),
                                'nombre'=>Sanitizar::limpiar($_POST['nombreE']),
                                'apellido'=>Sanitizar::limpiar($_POST['apellidoE']),
                                'email' =>Sanitizar::limpiar($_POST['emailE']),
                                'puesto' =>Sanitizar::limpiar($_POST['puestoE']),
                                'salario' =>Sanitizar::limpiar($_POST['salarioE']),
                                'idAdmin'=>$_POST['idAdmin']
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
        $result = $this->empleadosM->contarEmpleadosPorPuestoM(); 
        
        $labels = array_column($result, 'puesto');
        $values = array_column($result, 'cantidad');
        responderJSON(['labels' => $labels, 'values' => $values]);
    }

    public function registrosRecientesC() {
        $result = $this->empleadosM->registrosRecientesM();
        
        if ($result) {
            responderJSON(["status" => "success", "data" => $result]);
        } else {
            responderJSON(["status" => "error", "message" => "No hay registros recientes"]);
        }
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