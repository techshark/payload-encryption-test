<?php
declare(strict_types=1);

namespace Techshark\PayloadEncryption\Encryption;

use Illuminate\Contracts\Config\Repository;
use phpseclib\Crypt\RSA;

/**
 * Class PayloadDecryption
 */
class PayloadDecryption
{

    /**
     * @var RSA
     */
    private $rsa;

    /**
     * PayloadEncryption constructor.
     * @param string $privateKey
     * @param RSA $rsa
     * @param Repository $config
     */
    public function __construct(string $privateKey, RSA $rsa, Repository $config)
    {
        $this->rsa = $rsa;
        $this->rsa->loadKey($privateKey);
        $this->rsa->setEncryptionMode(
            $config->get('payload-encryption.phpseclib_encryption_mode')
        );
    }

    /**
     * Decrypt data.
     *
     * @param string $cipherText
     * @return string
     */
    public function decrypt(string $cipherText): string
    {
        return $this->rsa->decrypt($cipherText);
    }

    /**
     * Decrypt array.
     *
     * @param string $cipherText
     * @return array
     */
    public function decryptArray(string $cipherText): array
    {
        $decryptedJsonData = $this->rsa->decrypt($cipherText);

        return json_decode($decryptedJsonData, true);
    }
}
