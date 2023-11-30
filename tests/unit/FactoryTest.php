<?php

namespace unit;

use Lernfeld1011\Configuration\Configuration;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testConfigWasFound(): void
    {
        $this->assertInstanceOf(Configuration::class, new Configuration());
    }
}