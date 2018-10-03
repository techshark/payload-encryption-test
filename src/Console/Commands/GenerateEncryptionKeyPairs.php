<?php

namespace Techshark\PayloadEncryption\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\File;
use phpseclib\Crypt\RSA;

/**
 * Class GenerateEncryptionKeyPairs
 */
class GenerateEncryptionKeyPairs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payload-encryption:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a key pair (public & private) for the payload-encryption package.';

    /**
     * @var RSA
     */
    private $rsa;

    /**
     * Create a new command instance.
     *
     * @param RSA $rsa
     * @param Repository $config
     */
    public function __construct(RSA $rsa, Repository $config)
    {
        parent::__construct();

        $this->rsa = $rsa;
        $this->rsa->setPrivateKeyFormat(
            $config->get('phpseclib_private_key_format')
        );
        $this->rsa->setPublicKeyFormat(
            $config->get('phpseclib_public_key_format')
        );
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $keys = $this->rsa->createKey(4096);
        $publicPath = public_path('id_rsa.pub');
        $privatePath = storage_path('id_rsa');

        if (!File::exists($publicPath) && !File::exists($privatePath)) {
            File::put($publicPath, $keys['publickey']);
            File::put($privatePath, $keys['privatekey']);

            $this->info(
                'Successfully written public key to: ' . $publicPath . ' and private key written to: ' . $privatePath
            );
        } else {
            $this->error(
                'Either the public key in: ' . $publicPath . ' or the private key in: '. $privatePath . ' already exists..'
            );
        }
    }
}
