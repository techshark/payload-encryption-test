<?php
declare(strict_types=1);

namespace Techshark\PayloadEncryption\Providers;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use phpseclib\Crypt\RSA;
use Techshark\PayloadEncryption\Console\Commands\ClearApplicationKeys;
use Techshark\PayloadEncryption\Console\Commands\GenerateEncryptionKeyPairs;
use Techshark\PayloadEncryption\Encryption\PayloadDecryption;
use Techshark\PayloadEncryption\Encryption\PayloadEncryption;

/**
 * Class PayloadEncryptionServiceProvider
 */
class PayloadEncryptionServiceProvider extends ServiceProvider
{

    /**
     *
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/payload-encryption.php' => config_path('payload-encryption.php'),
                __DIR__ . '/../config/payload-encryption-constants.php' => config_path('payload-encryption-constants.php')
            ],
            'payload-encryption'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                ClearApplicationKeys::class,
                GenerateEncryptionKeyPairs::class,
            ]);
        }

        $this->app->bind(
            PayloadDecryption::class,
            function (Application $application) {
                return new PayloadDecryption(
                    File::get(storage_path('id_rsa')),
                    new RSA(),
                    new Repository()
                );
            }
        );

        $this->app->bind(
            PayloadEncryption::class,
            function (Application $application, array $parameters) { // $this->app->make(PayloadEncryption::class, $publicKey)
                return new PayloadEncryption(
                    $parameters['publicKey'],
                    new RSA(),
                    new Repository()
                );
            }
        );
    }
}
