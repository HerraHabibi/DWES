<?php
  // Función para mostrar en el select los vehículos disponibles
  function selectVehiculosDisponibles() {
    $vehiculosAlquilados = obtenerVehiculosAlquiladosCliente($_SESSION['usuario']);

    echo "<option value='' disabled selected>-- SELECCIONA --</option>";

    foreach ($vehiculosAlquilados as $vehiculo)
      echo "<option value='" . $vehiculo['matricula'] . "'>" . $vehiculo['matricula'] . ' - ' . $vehiculo['marca'] . ' - ' . $vehiculo['modelo'] . '</option>';
  }

  // Función para comprobar si se ha seleccionado un vehículo
  function comprobarVehiculo($vehiculo) {
    if ($vehiculo == '')
      trigger_error('Debes seleccionar un vehículo', E_USER_WARNING);
  }

  // Función para calcular la hora de devolución
  function calcularFechaDevolucion() {
    date_default_timezone_set('Europe/Madrid');
    return date('Y-m-d H:i:s');
  }

  // Función para hacer que el precio del alquiler empiece desde el precio base y no desde 0
  function arreglarTiempoAlquiler($tiempoAlquiler) {
    if ($tiempoAlquiler < 1)
      $tiempoAlquiler = 1;

    return $tiempoAlquiler;
  }

  // Función para crear una cookie con la información de la devolución
  function almacenarDevolucion($vehiculo, $fechaDevolucion, $tiempoAlquiler) {
    $datos = array(
      'vehiculo' => $vehiculo,
      'fechaDevolucion' => $fechaDevolucion,
      'tiempoAlquiler' => $tiempoAlquiler
    );

    $datos = serialize($datos);

    setcookie('devolucion', $datos, time() + (30 * 60), '/');
  }

  // Función para calcular el precio total del alquiler
  function calcularPrecioAlquiler($precioBase, $tiempoAlquiler) {
    return $precioBase * $tiempoAlquiler;
  }

  // Pasarela de pago
  function pasarelaPago($precio) {
    // Datos de la transacción para Redsys
    $orderId = rand(1000000, 9999999); // Genera un ID único para el pedido
    $currency = '978'; // EUR (ISO 4217 code)
    $amount = intval($precio * 100); // Monto en céntimos
    
    // Datos de configuración de Redsys
    $dsSignatureVersion = 'HMAC_SHA256_V1';
    $merchantCode = '263100000';  // Código de comercio || $merchantCode = '999008881';
    $secretKey = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; // Clave secreta
    $url = 'https://sis-t.redsys.es:25443/sis/realizarPago'; // URL de pago de Redsys
    $urlOk = 'http://192.168.206.226/DWES/Proyectos/movilmad/ok'; // URL de confirmación (pago exitoso)
    $urlKo = 'http://192.168.206.226/DWES/Proyectos/movilmad/ko'; // URL de error
    
    $redsys = new RedsysAPI();

    $redsys->setParameter("DS_MERCHANT_AMOUNT",$amount);
    $redsys->setParameter("DS_MERCHANT_ORDER",$orderId);
    $redsys->setParameter("DS_MERCHANT_MERCHANTCODE",$merchantCode);
    $redsys->setParameter("DS_MERCHANT_CURRENCY",$currency);
    $redsys->setParameter("DS_MERCHANT_TRANSACTIONTYPE",'0');
    $redsys->setParameter("DS_MERCHANT_TERMINAL",'15');
    $redsys->setParameter("DS_MERCHANT_MERCHANTURL",$url);
    $redsys->setParameter("DS_MERCHANT_URLOK",$urlOk);
    $redsys->setParameter("DS_MERCHANT_URLKO",$urlKo);

    $params = $redsys->createMerchantParameters();
    $signature = $redsys->createMerchantSignature($secretKey);

    echo "<form name='frm' action='$url' method='POST' id='paymentForm'>";
    echo "<input type='hidden' name='Ds_SignatureVersion' value='$dsSignatureVersion'>";
    echo "<input type='hidden' name='Ds_MerchantParameters' value='$params'>";
    echo "<input type='hidden' name='Ds_Signature' value='$signature'>";
    echo "</form>";
    echo "<script type='text/javascript'>document.getElementById('paymentForm').submit();</script>";
  }
?>