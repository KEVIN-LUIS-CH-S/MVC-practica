<?php  // Modelos/empleadosM.php
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
            return ['status' => 'error', 'message' => '¡El correo ya existe, intente con otro correo por favor!'];
        }
        
    }

    public function mostrarEmpleadosM($tablaBD = 'empleados'){
        try{
            $cbd = ConexionBD::cBD('pdo');
            $stmt=$cbd->prepare("SELECT id, nombre, email, apellido, puesto, salario FROM $tablaBD WHERE estado=1");
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

    public function buscarEmpleadoM($query, $tablaBD = 'empleados') {
        try {
            $cbd = ConexionBD::cBD('pdo');
            $stmt = $cbd->prepare("SELECT id, nombre, email, apellido, puesto, salario FROM $tablaBD 
                                  WHERE estado=1 AND (nombre LIKE :query OR apellido LIKE :query OR email LIKE :query)");
            $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function contarEmpleadosPorPuestoM($tablaBD = 'empleados'){
        try {
            $cbd = ConexionBD::cBD('pdo');
            $stmt = $cbd->prepare("SELECT puesto, COUNT(*) as cantidad FROM $tablaBD WHERE estado=1 GROUP BY puesto");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error al contar empleados'];
        }
    }
    

    public function borrarEmpleadoM($datosC, $tablaBD = 'empleados'){
        try {
            $cbd = ConexionBD::cBD('pdo');
            extract($datosC);
            $stmt=$cbd->prepare("UPDATE $tablaBD SET estado = 0 WHERE id=:id");
            $stmt->execute([':id'=>$id]);
            return ['status' => 'success', 'message' => 'Empleado eliminado'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'No se pudo eliminar'];
        }
        
    }
}
?>