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

    public function testConvertInt()
    {
        $value = '1000000';
        $valueExpected = '1000000,00';
        $formatter = new MoneyFormatter($value);
        $formatter2 = new MoneyFormatter($valueExpected);
        $formatter->convert();
        $this->assertEquals($formatter, $formatter2);
    }

    public function testConvertFloat()
    {
        $value = '1000000.567';
        $valueExpected = '1000000,57';
        $formatter = new MoneyFormatter($value);
        $formatter2 = new MoneyFormatter($valueExpected);
        $formatter->convert();
        $this->assertEquals($formatter, $formatter2);
    }

    public function testHomeworkFormatterFloat()
    {
        $value = '1000000.54';
        $valueExpected = '1 000 000,54';
        $formatter = new MoneyFormatter($value);
        $formatter->convert();
        $this->assertEquals($valueExpected, $formatter->homeworkFormatted());
    }

    public function testHomeworkFormatterFloatMoreTwoDigit()
    {
        $value = '1000000.5456565656565656565';
        $valueExpected = '1 000 000,55';
        $formatter = new MoneyFormatter($value);
        $formatter->convert();
        $this->assertEquals($valueExpected, $formatter->homeworkFormatted());
    }

    public function testHomeworkFormatterInt()
    {
        $value = '1000000';
        $valueExpected = '1 000 000,00';
        $formatter = new MoneyFormatter($value);
        $formatter->convert();
        $this->assertEquals($valueExpected, $formatter->homeworkFormatted());
    }
}
