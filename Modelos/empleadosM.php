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
            $idAdmin = $datosC['idAdmin'];

            $stmt = $cbd->prepare("INSERT INTO $tablaBD (nombre, apellido, email, puesto, salario, id_admin) VALUES (:nombre, :apellido, :email, :puesto, :salario, :id_admin)");
            $stmt->execute([':nombre'=>$nombre,
                            ':apellido'=>$apellido,
                            ':email'=>$email,
                            ':puesto'=>$puesto,
                            ':salario'=>$salario,
                            ':id_admin'=>$idAdmin]);
            return ['status' => 'success', 'message' => '¡Empleado registrado!'];
        }catch (Exception $e){
            return ['status' => 'error', 'message' => '¡El correo ya existe, intente con otro correo por favor!'];
        }
        
    }

    public function obtenerPuestosM($tabla = 'puestos') {
        try {
            $cbd = ConexionBD::cBD('pdo');
            $stmt = $cbd->prepare("SELECT * FROM $tabla");
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error en la consulta obtener puestos'];
        }
    }

    public function mostrarEmpleadosM($tablaBD = 'empleados',$idAdmin){
        try{
            $cbd = ConexionBD::cBD('pdo');
            $stmt = $cbd->prepare("
            SELECT e.id, e.nombre, e.apellido, e.email, p.nombre AS puesto, e.salario 
            FROM $tablaBD e
            INNER JOIN puestos p ON e.puesto = p.id
            INNER JOIN administradores a ON e.id_admin = a.id
            WHERE e.estado = 1 AND e.id_admin = :idAdmin
            ");
            $stmt->execute(['idAdmin'=>$idAdmin]);
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (Exception $e){
            return ['status' => 'error', 'message' => 'Error al mostrar empleados'];
        }
        
    }

    public function editarEmpleadoM($datosC, $tablaBD = 'empleados'){
        try {
            $cbd = ConexionBD::cBD('pdo');
            $id = $datosC['id'];
            $stmt = $cbd->prepare("SELECT e.id, e.nombre, e.email, e.apellido, e.puesto AS id_puesto, 
                                    p.nombre AS puesto, e.salario, e.id_admin 
                                    FROM $tablaBD e
                                    INNER JOIN puestos p ON e.puesto = p.id
                                    WHERE e.id = :id");
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
                WHERE id=:id AND id_admin=:id_admin");
            $stmt->execute([':nombre'=>$nombre,
                            ':apellido'=>$apellido,
                            ':email'=>$email,
                            ':puesto'=>$puesto,
                            ':salario'=>$salario,
                            ':id'=>$id,
                            ':id_admin'=>$idAdmin]);

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
            $stmt = $cbd->prepare("
                    SELECT p.nombre AS puesto, COUNT(e.id) AS cantidad
                    FROM $tablaBD e
                    INNER JOIN puestos p ON e.puesto = p.id
                    WHERE e.estado = 1
                    GROUP BY p.nombre            
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error al contar empleados'];
        }
    }

    public function registrosRecientesM() {
        try {
            $cbd = ConexionBD::cBD('pdo')->prepare("
            SELECT nombre, apellido, fecha_ingreso 
                                           FROM empleados 
                                           WHERE fecha_ingreso >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) 
                                           AND estado = 1
        ");
        
        $cbd->execute();
        return $cbd->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return(["status" => "error", "message" => "Error en la consulta preparada"]);
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