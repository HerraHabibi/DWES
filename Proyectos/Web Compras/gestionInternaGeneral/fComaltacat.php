<?php
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  // Función que devuelve el código de la última categoría creada
  function buscarUltimaCat() {
    // Definir la query y ejecutarla
    $sql = "SELECT id_categoria
              FROM categoria";
    $resultado = operarBd($sql);

    // Si no hay categorías, devuelve C-000
    if (empty($resultado))
      return 'C-000';

    // Sino devuelve el código de la última categoría
    foreach ($resultado as $categoria)
      $ultCat = $categoria['id_categoria'];

    return $ultCat;
  }

  // Función que devuelve el código del nuevo categoría
  function calcularCodNuevaCat($ultCat) {
    $ultCat = intval(substr($ultCat, 2));

    $nuevaCat = strval($ultCat + 1);
    $nuevaCat = str_pad($nuevaCat, 3, '0', STR_PAD_LEFT);
    $nuevaCat = 'C-' . $nuevaCat;

    return $nuevaCat;
  }

  // Función para insertar el nuevo categoría en la base de datos
  function insertarCat($codCat, $nomCat) {
    $sql = "INSERT INTO categoria (id_categoria, nombre)
              VALUES (:id_categoria, :nombre)";
    $params = [':id_categoria' => $codCat, ':nombre' => $nomCat];

    $valido = operarBd($sql, $params);

    if ($valido)
      echo "Se creó la categoría <b>$nomCat</b> correctamente <br>";
  }
?>