<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class TokenGenerateCommand extends Command
{
    protected $signature = 'token:generate';
    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info(Crypt::encryptString(config('app.key')));
    }
}
