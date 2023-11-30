<?php

namespace unit;

use Lernfeld1011\Configuration\Configuration;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Lernfeld1011\infrastructure\Factory
 */
class FactoryTest extends TestCase
{
    public function testConfigWasFound(): void
    {
        $this->assertInstanceOf(Configuration::class, new Configuration());
    }
}