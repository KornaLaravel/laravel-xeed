<?php

namespace Cable8mm\Xeed\Tests\Unit\Resolvers;

use Cable8mm\Xeed\Column;
use Cable8mm\Xeed\Resolvers\MacaddressResolver;
use Cable8mm\Xeed\Support\Picker;
use Cable8mm\Xeed\Xeed;
use PHPUnit\Framework\TestCase;

final class MacaddressResolverTest extends TestCase
{
    public Column $column;

    protected function setUp(): void
    {
        $xeed = Xeed::getInstance();

        $this->column = Picker::of($xeed->attach()
            ->getTable('xeeds')
            ->getColumns()
        )->driver($xeed->driver)->field('mac_address')->get();
    }

    public function test_column_can_not_null(): void
    {
        $this->assertNotNull($this->column);
    }

    public function test_resolver_can_be_created(): void
    {
        $resolver = new MacaddressResolver($this->column);

        $this->assertNotNull($resolver);
    }

    public function test_fake_method_can_working_well(): void
    {
        $resolver = new MacaddressResolver($this->column);

        $this->assertEquals('\''.$resolver->field.'\' => fake()->macAddress(),', $resolver->fake());
    }

    public function test_migration_method_can_working_well(): void
    {
        $resolver = new MacaddressResolver($this->column);

        $this->assertEquals('$table->macAddress(\''.$resolver->field.'\');', $resolver->migration());
    }

    public function test_nova_method_can_working_well(): void
    {
        $this->column->field = 'macaddress_field';

        $resolver = new MacaddressResolver($this->column);

        $this->assertEquals('Text::make(\''.$this->column->title().'\'),', $resolver->nova());
    }
}
