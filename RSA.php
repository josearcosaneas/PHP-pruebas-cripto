<?php

class myRSA
{

    public $pubkey = '';
    public $privkey = '';

    public function encrypt($data)
    {
			
        if (openssl_public_encrypt($data, $encrypted, $this->pubkey))
            $data = base64_encode($encrypted);
      
        return $data;
    }

    public function decrypt($data)
    {
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->privkey))
            $data = $decrypted;
        else
            $data = '';

        return $data;
    }
}


$data = "descripcion";




$rsa = new myRSA;
$fp = fopen("public.txt","r");
for ($i =0; $i<=5;$i++){
	$rsa->pubkey .= fgets($fp);
}
$encriptado = $rsa->encrypt($data);
fclose($fp);




$fp2 = fopen("private.txt","r");
for ($i =0; $i<=15; $i++){
	$rsa->privkey .= fgets($fp2);
}
$desencriptado = $rsa->decrypt($encriptado);
fclose($fp2);

?>