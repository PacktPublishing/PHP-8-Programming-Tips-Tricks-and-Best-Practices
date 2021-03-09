<?php
// /repo/src/Php7/Encrypt/Cipher.php
namespace Php7\Encrypt;
class OpenCipher extends Cipher
{
    public $algo = 'aes-256-gcm';
    public function encode(string $plain)
    {
        return $this->encrypt($plain);
    }
    private function encrypt(string $plain) : array
    {
        $tag    = '';
        $iv_len = openssl_cipher_iv_length($this->algo);
        $iv     = substr(md5((string) $this->salt), 0, $iv_len);
        $this->cipher = openssl_encrypt($plain, $this->algo, $this->key, 0, $iv, $tag);
        return [
            'tag' => base64_encode($tag),
            'cipher' => $this->cipher];
    }
}
