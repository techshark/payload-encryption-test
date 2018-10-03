<?php

namespace Techshark\PayloadEncryption\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\File;
use phpseclib\Crypt\RSA;

/**
 * Class ClearApplicationKeys
 */
class ClearApplicationKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payload-encryption:clear-application-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the public keys for other applications that are registered within your application.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $applicationKeyDir = storage_path('application-keys');

        if (File::isDirectory($applicationKeyDir) && !empty(File::allFiles($applicationKeyDir))) {
            File::cleanDirectory($applicationKeyDir);

            $this->info('All application keys were successfully removed.');
        } else {
            $this->warn('Application key directory: "'.$applicationKeyDir.'" was either already empty or didn\'t exist...');
        }
    }
}
