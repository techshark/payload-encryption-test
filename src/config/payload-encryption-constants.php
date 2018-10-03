<?php
declare(strict_types = 1);

// as per suggestion by PHPSECLIB: http://phpseclib.sourceforge.net/rsa/2.0/examples.html
if (defined('CRYPT_RSA_EXPONENT')) {
    define('CRYPT_RSA_EXPONENT', 65537);
}

if (defined('CRYPT_RSA_SMALLEST_PRIME')) {
    define('CRYPT_RSA_SMALLEST_PRIME', 64);
}
