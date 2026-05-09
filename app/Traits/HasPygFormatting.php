<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasPygFormatting
{
    /**
     * Format a price value to PYG currency (thousands separator, no decimals).
     *
     * @param  int|float  $value
     * @return string
     */
    public function formatPyg($value): string
    {
        return number_format((int) $value, 0, '', '.');
    }

    /**
     * Parse a PYG formatted string to integer.
     *
     * @param  string|int  $value
     * @return int
     */
    public function parsePyg($value): int
    {
        // Remove dots and everything that is not a number
        return (int) preg_replace('/[^0-9]/', '', (string) $value);
    }
    
    /**
     * Convert the model instance to an array with formatted values.
     * 
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        
        foreach ($this->getCasts() as $key => $value) {
            if (str_contains($value, 'pyg') || in_array($key, $this->getPygFields())) {
                $attributes[$key . '_formatted'] = $this->formatPyg($this->{$key});
            }
        }
        
        return $attributes;
    }

    /**
     * Get the fields that should be formatted as PYG.
     * Override this in the model.
     * 
     * @return array
     */
    protected function getPygFields(): array
    {
        return [];
    }
}
