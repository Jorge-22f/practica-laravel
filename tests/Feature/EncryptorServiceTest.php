<?php

use App\Business\services\EncryptorService;

test('Prueba de encriptador y que sea distinto', function () {
    $key = 'unaclavesecreta';

    $encryptor = new EncryptorService($key);

    $originalString = 'Una cadena de texto';

    $encryptedstring = $encryptor->encrypt($originalString);

    expect($encryptedstring)->not->ToBe($originalString);

    $decryptSting = $encryptor->decrypt($encryptedstring);

    expect($decryptSting)->ToBe($originalString);
});

test('Exepcion cuando la key es distinta', function(){
    $key = 'unaclavesecreta';
    $key2 = 'otraclave';

    $encryptor1 = new EncryptorService($key);
    $encryptor2 = new EncryptorService($key2);

    $encryptedstring = $encryptor1->encrypt('prueba de esto');

    $this->expectException(Exception::class);
    $encryptor2->decrypt($encryptedstring);    
});