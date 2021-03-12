<?php
// /repo/src/Php7/Encrypt/Cipher.php
namespace Php7\Encrypt;
class Cipher
{
    public $key  = '';
    public $salt = 0;
    public function __construct()
    {
        $this->salt  = rand(1,255);    // keep salt value to 8 bits
        $this->key   = bin2hex(random_bytes(8));
    }
    public function encode(string $plain)
    {
        return $this->encrypt($plain);
    }
    final private function encrypt(string $plain) : string
    {
        return base64_encode(str_rot13($plain));
    }
}
