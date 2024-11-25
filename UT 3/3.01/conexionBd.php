<?php
  // Función para operar con la base de datos (SELECT, INSERT, UPDATE y DELETE)
  function operarBd($sql, $params = array()) {
    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname = "empleadosnn";

    try {
      // Conectar a la base de datos
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Hacer la consulta
      $stmt = $conn->prepare($sql);
      
      // Si la consulta es de tipo SELECT, devolver los resultados
      if (stripos(trim($sql), 'SELECT') === 0) {
        $stmt->execute($params);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
      }

      $conn->beginTransaction();

      $stmt->execute($params);

      $conn->commit();

      // Si la consulta es de tipo INSERT, UPDATE o DELETE, devolver TRUE
      return true;

    } catch (PDOException $error) {
      // Hacer rollback en caso de que de fallo al operar con la BBDD
      if ($conn && $conn->inTransaction())
        $conn->rollBack();

      // Mostrar un mensaje de error si da un fallo al operar con la BBDD y devolver FALSE
      echo "Error al operar con la base de datos: " . $error->getMessage();
      return false;
    }
    
    // Cerrar la conexión
    $conn = null;
  }
?>