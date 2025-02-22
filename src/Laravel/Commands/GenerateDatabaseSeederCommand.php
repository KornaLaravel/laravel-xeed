<?php

namespace Cable8mm\Xeed\Laravel\Commands;

use Cable8mm\Xeed\Generators\DatabaseSeederGenerator;
use Cable8mm\Xeed\Xeed;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateDatabaseSeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xeed:database {--f|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate database seeder from your own database tables';

    /**
     * Execute the console command.
     */
    public function handle(Xeed $xeed)
    {
        $force = $this->option('force') ?? false;

        $tables = $xeed->addPdo(
            DB::connection()->getPDO()
        )->attach()->getTables();

        $tables = array_filter($tables, function ($table) {
            return ! in_array($table, Xeed::LARAVEL_DEFAULT_TABLES);
        });

        try {
            DatabaseSeederGenerator::make(
                $tables,
                destination: database_path('seeders')
            )->run(force: $force);

            $this->info(database_path('seeders').DIRECTORY_SEPARATOR.'DatabaseSeeder.php seeder have been generated.');
        } catch (\Exception $e) {
            $this->error(database_path('seeders').DIRECTORY_SEPARATOR.'DatabaseSeeder.php seeder file already exists.');
        }

        return Command::SUCCESS;
    }
}
