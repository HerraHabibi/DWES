<?php
  // Función para mostrar el email del cliente
  function mostrarEmail() {
    echo datosCliente($_SESSION['usuario'])[0]['email'];
  }
  
  // Función para mostrar el nombre completo del cliente
  function mostrarNombreCompleto() {
    $cliente = datosCliente($_SESSION['usuario'])[0];
    echo $cliente['nombre'] . ' ' . $cliente['apellidos'];
  }

  // Función para mostrar la fecha actual
  function mostrarFecha() {
    date_default_timezone_set('Europe/Madrid');
    echo date('d/m/Y');
  }
?>