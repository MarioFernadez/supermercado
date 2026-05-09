<?php

if (!function_exists('format_pyg')) {
    /**
     * Format a number as Guarani currency (PYG).
     *
     * @param int|float $amount
     * @return string
     */
    function format_pyg($amount)
    {
        return number_format((int) $amount, 0, '', '.');
    }
}

if (!function_exists('parse_pyg')) {
    /**
     * Parse a PYG formatted string to integer.
     * 1.000 -> 1000
     *
     * @param  string  $value
     * @return int
     */
    function parse_pyg($value)
    {
        return (int) preg_replace('/[^0-9]/', '', (string) $value);
    }
}
