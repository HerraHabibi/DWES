<?php
  $decimal = $_REQUEST['decimal'];
  $conversion = $_REQUEST['conversion'];
  
  switch ($conversion) {
    case 'binario':
      $binario = decbin($decimal);
      $tabla = "<tr><td>Binario</td><td>$binario</td></tr>";
      break;

    case 'octal':
      $octal = decoct($decimal);
      $tabla = "<tr><td>Octal</td><td>$octal</td></tr>";
      break;

    case 'hexadecimal':
      $hexadecimal = strtoupper(dechex($decimal));
      $tabla = "<tr><td>Hexadecimal</td><td>$hexadecimal</td></tr>";
      break;
      
    case 'todos':
      $binario = decbin($decimal);
      $octal = decoct($decimal);
      $hexadecimal = strtoupper(dechex($decimal));
      $tabla = "
                <tr><td>Binario</td><td>$binario</td></tr>
                <tr><td>Octal</td><td>$octal</td></tr>
                <tr><td>Hexadecimal</td><td>$hexadecimal</td></tr>
                ";
      break;
  }



  
?>