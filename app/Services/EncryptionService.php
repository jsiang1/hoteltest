<?php

namespace App\Services;

class EncryptionService
{
    private $key;

    public function __construct()
    {
        // Replace 'my_secret_key_32bit' with a strong, randomly generated key
        $this->key = 'my_secret_key_32bit';
    }

    public function encrypt($plaintext)
    {
        // Generate a random initialization vector (IV)
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        // Encrypt the plaintext using AES-256-CBC encryption with PKCS7 padding
        $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv);

        // Combine the IV and ciphertext and encode the result in base64 format
        $encrypted = base64_encode($iv . $ciphertext);

        return $encrypted;
    }

    public function decrypt($encrypted)
    {
        // Decode the base64-encoded input
        $encrypted = base64_decode($encrypted);

        // Extract the IV and ciphertext from the input
        $iv = substr($encrypted, 0, openssl_cipher_iv_length('aes-256-cbc'));
        $ciphertext = substr($encrypted, openssl_cipher_iv_length('aes-256-cbc'));

        // Decrypt the ciphertext using AES-256-CBC decryption with PKCS7 padding
        $plaintext = openssl_decrypt($ciphertext, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv);

        return $plaintext;
    }
}