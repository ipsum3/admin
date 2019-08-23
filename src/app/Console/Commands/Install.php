<?php

namespace Ipsum\Admin\app\Console\Commands;

use Ipsum\Admin\app\Models\Admin;
use Ipsum\Core\app\Console\Commands\Command;

class Install extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ipsum:admin:install
                                {--timeout=300} : How many seconds to allow each process to run.
                                {--debug} : Show process output or not. Useful for debugging.';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Require dev packages and publish files for Ipsum\Admin to work';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->progressBar = $this->output->createProgressBar(4);
        $this->progressBar->start();
        $this->info(" Ipsum\Admin installation started. Please wait...");
        $this->progressBar->advance();

        $this->line(' Publishing configs, langs, views and Ipsum Assets files');
        $this->executeProcess('php artisan vendor:publish --provider="Ipsum\Admin\AdminServiceProvider" --tag=install');

        $this->line(" Generating users table (using Laravel's default migrations)");
        $this->executeProcess('php artisan migrate');

        $this->line(" Seeding users table");
        if (!Admin::count()) {
            $this->executeProcess('php artisan db:seed --class="Ipsum\Admin\database\seeds\DatabaseSeeder"');
        } else {
            $this->info(" Seed already done");
        }

        $this->progressBar->finish();
        $this->info(" Ipsum\Admin installation finished.");
    }
}
