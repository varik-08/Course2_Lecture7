<?php

namespace App\Services;

class MoneyFormatter
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function eraseString()
    {
        $this->value = str_replace([' ', ',', '.', '_', '-'], '', $this->value);
    }

    public function formatted()
    {
        $this->eraseString();
        $string = strval($this->value);
        $digits = strlen($string);
        $output = '';
        for ($i = 0; $i < $digits; $i++) {
            if (($i % 3 == 0) && $i > 0) {
                $output = ' ' . $output;
            }
            $output = substr($string, ($digits - ($i + 1)), 1) . $output;
        }
        return $output;
    }
}