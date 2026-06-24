<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Audit;

class EncryptAudits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encrypt:audits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encrypt all existing audit records using EncryptedModel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting encryption of all audit records...');

        $audits = Audit::all();
        $bar = $this->output->createProgressBar($audits->count());

        // Will process 100 records at a time, preventing memory overload on large tables.
        Audit::chunk(100, function ($audits) use ($bar) {
            foreach ($audits as $audit) {
                $audit->save(); // triggers EncryptedModel encryption
                $bar->advance();
            }
        });

        $bar->finish();
        $this->info("\nAll audit records have been encrypted successfully!");
    }
}

// run this command using: php artisan encrypt:audits