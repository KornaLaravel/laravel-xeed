<?php

namespace Cable8mm\Xeed\Resolvers;

use Cable8mm\Xeed\Support\Inflector;

/**
 * LONGTEXT
 *
 * Holds a string with a maximum length of 4,294,967,295 characters
 */
class LongtextResolver extends Resolver
{
    public function fake(): string
    {
        return '\''.$this->column->field.'\' => fake()->paragraph(),';
    }

    public function migration(): string
    {
        $migration = '$table->longText(\''.$this->column->field.'\')';

        return $this->last($migration);
    }

    public function nova(): ?string
    {
        return 'Textarea::make(\''.Inflector::title($this->column->field).'\'),';
    }
}
