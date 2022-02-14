<?php

namespace App\Tests\Integration\Service\Generator;

use App\Service\Generator\Generator;
use App\Service\Generator\GeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\ORMDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GeneratorTest extends KernelTestCase
{
    private GeneratorInterface $generator;

    public function setUp(): void
    {
        self::bootKernel();
        $this->generator = static::getContainer()->get(Generator::class);
    }

    public function testGenerationFromDatabase(): void
    {
        //TODO: load fixtures directly from test
        $openApi = $this->generator->generate(21);

//        dd($openApi->toYaml());

        $this->assertJsonStringEqualsJsonFile('/var/www/html/tests/Fixtures/OpenApi.json', $openApi->toJson());
    }

    public function tearDown(): void
    {
        unset($this->generator);
    }
}
