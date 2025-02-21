<?php  //Modelos/empleadosM.php
require_once "conexionBD.php";

class EmpleadosM extends ConexionBD{
 
    public function registrarEmpleadosM($datosC, $tablaBD = 'empleados'){
        try{
            $cbd = ConexionBD::cBD('pdo');
            $nombre = $datosC['nombre'];
            $apellido = $datosC['apellido'];
            $email = $datosC['email'];
            $salario = $datosC['salario'];
            $puesto = $datosC['puesto'];

            $stmt = $cbd->prepare("INSERT INTO $tablaBD (nombre, apellido, email, puesto, salario) VALUES (:nombre, :apellido, :email, :puesto, :salario)");
            $stmt->execute([':nombre'=>$nombre,
                            ':apellido'=>$apellido,
                            ':email'=>$email,
                            ':puesto'=>$puesto,
                            ':salario'=>$salario]);
            return ['status' => 'success', 'message' => '¡Empleado registrado!'];
        }catch (Exception $e){
            return ['status' => 'error', 'message' => '¡Error al registrar empleado!'];
        }
        
    }

    public function mostrarEmpleadosM($tablaBD = 'empleados'){
        try{
            $cbd = ConexionBD::cBD('pdo');
            $stmt=$cbd->prepare("SELECT id, nombre, email, apellido, puesto, salario FROM $tablaBD");
            $stmt->execute();
            return $stmt;
        }
        catch (Exception $e){
            return ['status' => 'error', 'message' => 'Error al mostrar empleados'];
        }
        
    }

    public function editarEmpleadoM($datosC, $tablaBD = 'empleados'){
        try {
            $cbd = ConexionBD::cBD('pdo');
            $id = $datosC['id'];
            $stmt=$cbd->prepare("SELECT id, nombre, email, apellido, puesto, salario FROM $tablaBD WHERE id=:id");
            $stmt->execute([':id'=>$id]);
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error en selecion de empleado a editar'];
        }
        
    }

    public function actualizarEmpleadoM($datosC, $tablaBD = 'empleados'){
        try {
            $cbd = ConexionBD::cBD('pdo');
            extract($datosC);
            $stmt=$cbd->prepare("UPDATE $tablaBD
                SET nombre=:nombre, 
                apellido=:apellido, 
                email=:email, 
                puesto=:puesto, 
                salario=:salario
                WHERE id=:id");
            $stmt->execute([':nombre'=>$nombre,
                            ':apellido'=>$apellido,
                            ':email'=>$email,
                            ':puesto'=>$puesto,
                            ':salario'=>$salario,
                            ':id'=>$id]);

            return ['status' => 'success', 'message' => 'empleado actualizado correctamente'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error al actualizar empleado'];
        }
       
    }

    public function borrarEmpleadoM($datosC, $tablaBD = 'empleados'){
        $cbd = ConexionBD::cBD();
        extract($datosC);
        $query = "DELETE FROM $tablaBD WHERE id='$id'";
        $resultado = $cbd->query($query);
    }
} 
?>