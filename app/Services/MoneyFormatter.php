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

    public function roundValue($number)
    {
        $this->value = str_replace(',', '.', $this->value);
        $this->value = round((float)$this->value, $number);
        $this->value = str_replace('.', ',', $this->value);
        if (!stristr($this->value, ',')) {
            $this->value = $this->value . ',00';
        }
    }


    public function convertToFloatWithComma()
    {
        $this->value = str_replace([' ', '_', '-'], '', $this->value);
        $this->roundValue(2);
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

    public function formattedStringToFloat()
    {
        $this->convertToFloatWithComma();
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
