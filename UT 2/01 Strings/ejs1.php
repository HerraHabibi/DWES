<HTML>
	<HEAD>
		<TITLE> EJ1-Conversion IP Decimal a Binario </TITLE>
	</HEAD>
	<BODY>
		<?php
			$ip="192.18.16.204";
			
			echo "IP " . $ip . " en binario es  ";
			$ipSeparada = explode(".", $ip);
			for ($i = 0; $i < 4; $i++) {
				printf("%08b", $ipSeparada[$i]);
				if ($i < 3)
					echo ".";
			}
		?>
	</BODY>
</HTML>