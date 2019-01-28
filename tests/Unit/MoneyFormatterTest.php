<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\MoneyFormatter;

class MoneyFormatterTest extends TestCase
{
    public function testFormatted()
    {
        $value = 9999999;
        $valueExpected = '9 999 999';
        $formatter = new MoneyFormatter($value);
        $this->assertEquals($valueExpected, $formatter->formatted());
    }

    public function testFormattedLittleNumber()
    {
        $value = 99;
        $valueExpected = '99';
        $formatter = new MoneyFormatter($value);
        $this->assertEquals($valueExpected, $formatter->formatted());
    }

    public function testFormatted0()
    {
        $value = 0;
        $valueExpected = '0';
        $formatter = new MoneyFormatter($value);
        $this->assertEquals($valueExpected, $formatter->formatted());
    }

    public function testFormattedThousand()
    {
        $value = 1000;
        $valueExpected = '1 000';
        $formatter = new MoneyFormatter($value);
        $this->assertEquals($valueExpected, $formatter->formatted());
    }

    public function testFormattedString()
    {
        $value = '1000';
        $valueExpected = '1 000';
        $formatter = new MoneyFormatter($value);
        $this->assertEquals($valueExpected, $formatter->formatted());
    }

    public function testFormattedStringSpaced()
    {
        $value = '1 000';
        $valueExpected = '1 000';
        $formatter = new MoneyFormatter($value);
        $this->assertEquals($valueExpected, $formatter->formatted());
    }

    public function testEraseString()
    {
        $value = '1.000-000';
        $valueExpected = '1000000';
        $formatter = new MoneyFormatter($value);
        $formatter2 = new MoneyFormatter($valueExpected);
        $formatter->eraseString();
        $this->assertEquals($formatter, $formatter2);
    }

    public function testConvertToFloatWithCommaOfInt()
    {
        $value = '1000000';
        $valueExpected = '1000000,00';
        $formatter = new MoneyFormatter($value);
        $formatter2 = new MoneyFormatter($valueExpected);
        $formatter->convertToFloatWithComma();
        $this->assertEquals($formatter, $formatter2);
    }

    public function testConvertToFloatWithCommaOfFloat()
    {
        $value = '1000000.567';
        $valueExpected = '1000000,57';
        $formatter = new MoneyFormatter($value);
        $formatter2 = new MoneyFormatter($valueExpected);
        $formatter->convertToFloatWithComma();
        $this->assertEquals($formatter, $formatter2);
    }

    public function testFormattedStringToFloatOfFloat()
    {
        $value = '1000000.54';
        $valueExpected = '1 000 000,54';
        $formatter = new MoneyFormatter($value);
        $formatter->convertToFloatWithComma();
        $this->assertEquals($valueExpected, $formatter->formattedStringToFloat());
    }

    public function testFormattedStringToFloatOfFloatWithMoreTwoDigitAfterComma()
    {
        $value = '1000000.5456565656565656565';
        $valueExpected = '1 000 000,55';
        $formatter = new MoneyFormatter($value);
        $formatter->convertToFloatWithComma();
        $this->assertEquals($valueExpected, $formatter->formattedStringToFloat());
    }

    public function testFormattedStringToFloatOfInt()
    {
        $value = '1000000';
        $valueExpected = '1 000 000,00';
        $formatter = new MoneyFormatter($value);
        $formatter->convertToFloatWithComma();
        $this->assertEquals($valueExpected, $formatter->formattedStringToFloat());
    }
}
