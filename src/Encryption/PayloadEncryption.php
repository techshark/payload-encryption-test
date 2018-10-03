<?php
declare(strict_types=1);

namespace Techshark\PayloadEncryption\Encryption;

use Illuminate\Contracts\Config\Repository;
use phpseclib\Crypt\RSA;

/**
 * Class PayloadEncryption
 */
class PayloadEncryption
{
    /**
     * @var RSA
     */
    private $rsa;

    /**
     * PayloadEncryption constructor.
     * @param string $publicKey
     * @param RSA $rsa
     */
    public function __construct(string $publicKey, RSA $rsa, Repository $config)
    {
        $this->rsa = $rsa;
        $this->rsa->loadKey($publicKey);
        $this->rsa->setEncryptionMode(
            $config->get('payload-encryption.phpseclib_encryption_mode')
        );
    }

    /**
     * Encrypt data.
     *
     * @param string $data
     * @return string
     */
    public function encrypt(string $data): string
    {
        return $this->rsa->encrypt($data);
    }

    /**
     * Encrypt array.
     *
     * @param array $data
     * @return string
     */
    public function encryptArray(array $data): string
    {
        $serializedData = json_encode($data); // this is faster than serialize(), hence the choice to use json_encode.

        return $this->rsa->encrypt($serializedData);
    }
}
