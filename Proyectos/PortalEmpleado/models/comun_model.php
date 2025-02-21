<?php
  // Función para operar con la base de datos (SELECT, INSERT, UPDATE y DELETE)
  function operarBd($sql, $params = array()) {
    // Usar la conexión establecida en db.php
    global $conexion;

    try {
      // Hacer la consulta
      $stmt = $conexion->prepare($sql);
      
      // Si la consulta es de tipo SELECT, devolver los resultados
      if (stripos(trim($sql), 'SELECT') === 0) {
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
      }

      // Si la consulta es de tipo INSERT, UPDATE o DELETE
      $conexion->beginTransaction();
      $stmt->execute($params);
      $conexion->commit();

      // Devolver TRUE para operaciones como INSERT, UPDATE, DELETE
      return true;

    } catch (PDOException $error) {
      // Hacer rollback en caso de que falle la operación
      if ($conexion && $conexion->inTransaction())
        $conexion->rollBack();

      // Mostrar un mensaje de error si falla la operación con la base de datos
      echo 'Error al operar con la base de datos: ' . $error->getMessage();
      return false;
    }
  }

  function datosEmpleados() {
    $sql = "SELECT emp_no, first_name, last_name
              FROM employees";

    return operarBd($sql);
  }
  
  // Función para buscar un cliente en la base de datos por su EMAIL
  function datosEmpleado($usuario) {
    $sql = "SELECT *
              FROM employees
              WHERE emp_no = :emp_no";
    $args = [':emp_no' => $usuario];
    
    return operarBd($sql, $args);
  }
?>
