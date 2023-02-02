<?php

use VVF\Tools\StrClass;
use PHPUnit\Framework\TestCase;

class StrClassTest extends TestCase
{
    /**
     * @dataProvider addressProvider
     * @return void
     */
    public function testBasic($generate)
    {
        $text = StrClass::handleRandomStringInArray($generate);
        $this->assertNotEmpty($text);
    }

    public function addressProvider(): array
    {
        return [
            [
                ['|randString|']
            ],
            [
                ['|randString|@mail.ru']
            ]
        ];
    }
}
