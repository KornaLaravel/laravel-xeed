<?php

namespace Cable8mm\Xeed\Tests\Feature;

use Cable8mm\Xeed\Database\Seeder;
use Cable8mm\Xeed\DB;
use PHPUnit\Framework\TestCase;

final class RetrieveTest extends TestCase
{
    private Seeder $seeder;

    protected function setUp(): void
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(getcwd());
        $dotenv->safeLoad();

        $this->seeder = new Seeder();

        $this->seeder->run();
    }

    protected function tearDown(): void
    {
        $this->seeder->dropTables();
    }

    public function test_can_be_inspected_into_columns(): void
    {
        $columns = DB::getInstance()->attach()->getTable(Seeder::TABLE)->getColumns();

        $this->assertIsArray($columns);
    }

    public function test_can_be_inspected_into_tables(): void
    {
        $tables = DB::getInstance()->attach()->getTables();

        $this->assertIsArray($tables);
    }
}