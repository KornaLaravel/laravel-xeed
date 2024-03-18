<?php

namespace Cable8mm\Xeed\Tests\Unit\Resolvers;

use Cable8mm\Xeed\Column;
use Cable8mm\Xeed\DB;
use Cable8mm\Xeed\Resolvers\TimestampResolver;
use Cable8mm\Xeed\Support\Picker;
use PHPUnit\Framework\TestCase;

final class TimestampResolverTest extends TestCase
{
    public Column $column;

    protected function setUp(): void
    {
        $db = DB::getInstance();

        $this->column = Picker::of($db->attach()
            ->getTable('xeeds')
            ->getColumns()
        )->driver($db->driver)->field('timestamp')->get();
    }

    public function test_column_can_not_null(): void
    {
        $this->assertNotNull($this->column);
    }

    public function test_resolver_can_be_created(): void
    {
        $resolver = new TimestampResolver($this->column);

        $this->assertNotNull($resolver);
    }

    public function test_fake_method_can_working_well(): void
    {
        $resolver = new TimestampResolver($this->column);

        $this->assertEquals('\''.$resolver->field.'\' => fake()->unixTime(),', $resolver->fake());
    }

    public function test_migration_method_can_working_well(): void
    {
        $resolver = new TimestampResolver($this->column);

        $this->assertEquals('$table->timestamp(\''.$resolver->field.'\', 0);', $resolver->migration());
    }
}