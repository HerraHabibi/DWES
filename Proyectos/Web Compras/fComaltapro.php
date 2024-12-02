<?php
  // Función para limpiar los datos de entrada
  function limpiar(&$value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  function selectCats() {
    $sql = "SELECT id_categoria, nombre
              FROM categoria";
    $resultado = operarBd($sql);
    
    echo "<select name='id_categoria'>";
    echo "<option value='' disabled selected>-- Seleccionar --</option>";
    foreach ($resultado as $categoria) {
      echo "<option value='" . $categoria['id_categoria'] . "'>" . $categoria['nombre'] . "</option>";
    }
    echo "</select>";
  }

  function validarNombre($nomProd) {
    if ($nomProd == '')
      trigger_error('Debes introducir un nombre', E_USER_WARNING);
  }

  function validarPrecio(&$precioProd) {
    if ($precioProd == '')
      trigger_error('Debes introducir un precio', E_USER_WARNING);

    if (!is_numeric($precioProd))
      trigger_error('El valor debe ser un número', E_USER_WARNING);

    if ($precioProd < 0)
      trigger_error('El precio no puede ser negativo', E_USER_WARNING);
    
    if (is_int($precioProd) || intval($precioProd) == $precioProd)
      $precioProd = floatval($precioProd);
  }

  function validarCat($codCat) {
    if ($codCat == '')
      trigger_error('Debes seleccionar una categoría', E_USER_WARNING);
  }

  // Función que devuelve el código de la última categoría creada
  function buscarUltimoProd() {
    // Definir la query y ejecutarla
    $sql = "SELECT id_producto
              FROM producto";
    $resultado = operarBd($sql);

    // Si no hay productos, devuelve P0000
    if (empty($resultado))
      return 'P0000';

    // Sino devuelve el código de el último producto
    foreach ($resultado as $categoria)
      $ultProd = $categoria['id_producto'];

    return $ultProd;
  }

  // Función que devuelve el código del nuevo categoría
  function calcularCodNuevoProd($ultCat) {
    $ultCat = intval(substr($ultCat, 1));

    $nuevaCat = strval($ultCat + 1);
    $nuevaCat = str_pad($nuevaCat, 4, '0', STR_PAD_LEFT);
    $nuevaCat = 'P' . $nuevaCat;

    return $nuevaCat;
  }

  function insertarProd($codProd, $nomProd, $precioProd, $codCat) {
    $sql = "INSERT INTO producto (id_producto, nombre, precio, id_categoria)
              VALUES (:id_producto, :nombre, :precio, :id_categoria)";
    $params = [':id_producto' => $codProd, ':nombre' => $nomProd, ':precio' => $precioProd, ':id_categoria' => $codCat];

    $valido = operarBd($sql, $params);

    if ($valido)
      echo "Se agregó el producto $nomProd correctamente <br>";
  }
?>