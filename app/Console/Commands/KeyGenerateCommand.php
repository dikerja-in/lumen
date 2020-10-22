<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;

class KeyGenerateCommand extends Command
{
    protected $signature = 'key:generate';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (config('app.key')) {
            if (!$this->confirm('Application key exists. Do you wish to continue?')) {
                return;
            }
        }

        $key = 'base64:' . base64_encode(
            Encrypter::generateKey(config('app.cipher'))
        );

        file_put_contents(base_path('.env'), preg_replace(
            $this->keyReplacementPattern(),
            'APP_KEY=' . $key,
            file_get_contents(base_path('.env'))
        ));

        $this->info("Application key has been set successfully.");
    }

    protected function keyReplacementPattern()
    {
        $escaped = preg_quote('=' . config('app.key'), '/');

        return "/^APP_KEY{$escaped}/m";
    }
}
