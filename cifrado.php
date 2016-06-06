
/*
 Pruebas de encriptado y desencriptado de datos 
 Creacion de dos funciones para realizar el cifrado de datos y el descrifrado

*/
<?php

    $key = pack('H*', "bcb0fb2a00a3");
    $plaintext = "Datos que vamos a cifrar";


	function cifrar($llave, $texto){
		 $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		 $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		 $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $llave,
                                 $texto, MCRYPT_MODE_CBC, $iv);

		# anteponer la IV para que esté disponible para el descifrado
		$ciphertext = $iv . $ciphertext;
		# codificar el texto cifrado resultante para que pueda ser representado por un string
		$ciphertext_base64 = base64_encode($ciphertext);
		return $ciphertext_base64;
	}
	$textCipher =cifrar($key, $plaintext);
	echo $textCipher;
	echo "\n";
	
	
	function descrifrar($llave, $ciphertext_base64){
		
		 $ciphertext_dec = base64_decode($ciphertext_base64);
		 # recupera la IV, iv_size debería crearse usando mcrypt_get_iv_size()
		 
		 $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		 $iv_dec = substr($ciphertext_dec, 0, $iv_size);
		 # recupera el texto cifrado (todo excepto el $iv_size en el frente)
		$ciphertext_dec = substr($ciphertext_dec, $iv_size);
		# podrían eliminarse los caracteres con valor 00h del final del texto puro
		$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $llave,
                                    $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
		return $plaintext_dec;
	}
	
	$textDescipher = descrifrar($key,$textCipher);
	echo $textDescipher;
	
?>