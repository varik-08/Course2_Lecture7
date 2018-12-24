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
}
