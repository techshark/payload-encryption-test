<?php
declare(strict_types = 1);

return [
    /**
     * Payload encryption mode.
     *
     * @see http://phpseclib.sourceforge.net/rsa/2.0/examples.html
     */
    'phpseclib_encryption_mode' => env('PHPSECLIB_ENCRYPTION_MODE', \phpseclib\Crypt\RSA::ENCRYPTION_PKCS1),

    /**
     * Public key format
     *
     * @see http://phpseclib.sourceforge.net/rsa/2.0/examples.html
     */
    'phpseclib_public_key_format' => env('PHPSECLIB_PUBLIC_KEY_FORMAT', \phpseclib\Crypt\RSA::PUBLIC_FORMAT_PKCS1),

    /**
     * Private key format
     *
     * @see http://phpseclib.sourceforge.net/rsa/2.0/examples.html
     */
    'phpseclib_private_key_format' => env('PHPSECLIB_PRIVATE_KEY_FORMAT', \phpseclib\Crypt\RSA::PRIVATE_FORMAT_PKCS1),
];
