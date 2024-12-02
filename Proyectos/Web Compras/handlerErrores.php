<?php
  // Error handler
  set_error_handler('errores', E_USER_WARNING);

  // Indicar por pantalla los posibles errores que ocurran
  function errores($errno, $errstr) {
    echo "<strong>ERROR:</strong> $errstr <br>";
    die();
  }
?>