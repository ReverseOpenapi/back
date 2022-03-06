<?php

namespace App\Tests\Integration\Service\Generator;

use App\Service\Generator\Generator;
use App\Service\Generator\GeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GeneratorTest extends KernelTestCase
{
    private GeneratorInterface $generator;

    public function setUp(): void
    {
        self::bootKernel();
        $this->generator = static::getContainer()->get(Generator::class);
    }

    public function testException(): void
    {
        $this->expectExceptionMessage('Document not found');
        $this->generator->generate(0);
    }

    public function tearDown(): void
    {
        unset($this->generator);
    }
}
