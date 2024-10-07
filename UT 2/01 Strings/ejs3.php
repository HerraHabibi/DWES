<HTML>
  <HEAD>
    <TITLE> EJ2-Direccion Red – Broadcast y Rango</TITLE>
  </HEAD>
  <BODY>
    <?php
      $ip="192.168.16.100/16";

      // Separar la IP y la máscara
      $ipMascara = explode("/", $ip);
      $soloIp = $ipMascara[0];
      $soloMascara = $ipMascara[1];

      // IP larga en decimal
      $ipLarga = ip2long($soloIp);

      // Máscara larga en decimal
      $mascara = (0xFFFFFFFF << (32 - $soloMascara)) & 0xFFFFFFFF;

      // AND lógico para obtener la dirección de red
      $red = $ipLarga & $mascara;

      // OR lógico para obtener la dirección de broadcast, bits de la máscara invertidos
      $broadcast = $red | (~$mascara & 0xFFFFFFFF);
      
      // Direcciones de la primera y última IP
      $primerIp = $red + 1;
      $ultimaIp = $broadcast - 1;

      echo "IP: " . $ip;
      echo "<br />";
      echo "Máscara: " . $soloMascara;
      echo "<br />";
      echo "Dirección de Red: " . long2ip($red);
      echo "<br />";
      echo "Dirección de Broadcast: " . long2ip($broadcast);
      echo "<br />";
      echo "Rango: " . long2ip($primerIp) . " a " . long2ip($ultimaIp);
    ?>
  </BODY>
</HTML>