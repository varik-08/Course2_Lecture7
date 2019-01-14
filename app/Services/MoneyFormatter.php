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

    public function convert()
    {
        $this->value = str_replace([' ', '_', '-'], '', $this->value);
        $this->value = str_replace(',', '.', $this->value);
        $this->value = round((float)$this->value, 2);
        $this->value = str_replace('.', ',', $this->value);
        if (!stristr($this->value, ',')) {
            $this->value = $this->value . ',00';
        }
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

    public function homeworkFormatted()
    {
        $this->convert();
        $string = strval($this->value);
        $output = '';
        if ($pos = strripos($string, ',')) {
            $output = substr($string, $pos) . $output;
            $string = substr_replace($string, '',$pos);
        }
        $digits = strlen($string);

        for ($i = 0; $i < $digits; $i++) {
            if (($i % 3 == 0) && $i > 0) {
                if ($output[0] != ',') {
                    $output = ' ' . $output;
                }
            }
            $output = substr($string, ($digits - ($i + 1)), 1) . $output;
        }
        return $output;
    }

}