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

  // Función para obtener los datos de un cliente por su email
  function datosCliente($correo) {
    $sql = "SELECT *
              FROM clientes
              WHERE email = :email";
    $args = [':email' => $correo];

    return operarBd($sql, $args);
  }

  // Función para obtener el dni de un cliente por su email
  function buscarDni($cliente) {
    $sql = "SELECT dni
              FROM clientes
              WHERE email = :email";
    $args = [':email' => $cliente];

    return operarBd($sql, $args)[0]['dni'];
  }
?>