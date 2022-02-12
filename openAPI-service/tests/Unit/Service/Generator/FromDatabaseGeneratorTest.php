<?php

namespace App\Tests\Unit\Service\Generator;

use App\DTO\Document\AbstractDocument;
use App\Entity\OpenApiDocument;
use App\Repository\OpenApiDocumentRepository;
use App\Service\Builder\Factory\BuilderFactoryInterface;
use App\Service\Builder\BuilderInterface;
use App\Service\Generator\FromDatabaseGenerator;
use App\Service\Generator\GeneratorInterface;
use App\Service\Builder\BuilderObject\InfoBuilderObject;
use App\Service\Hydrator\Hydrator;
use App\Service\Hydrator\HydratorInterface;
use PHPUnit\Framework\TestCase;

class FromDatabaseGeneratorTest extends TestCase
{
    private GeneratorInterface $generator;

    public function setUp(): void
    {
        $openApiDocument = new OpenApiDocument();
        $openApiDocument->setTitle('Pet Store');

        $openApiDocumentRepository = $this->createMock(OpenApiDocumentRepository::class);
        $openApiDocumentRepository->method('findOneBy')
            ->willReturn($openApiDocument);
        $builder = $this->createMock(BuilderInterface::class);
//        $hydrator = $this->createMock(HydratorInterface::class);
        $this->generator = new FromDatabaseGenerator($openApiDocumentRepository, $builder, new Hydrator());
    }

    public function testGenerationFromDatabase(): void
    {
        $openApi = $this->generator->generate(1);
        $this->assertInstanceOf(AbstractDocument::class, $openApi);
    }

    public function tearDown(): void
    {
        unset($this->fromDatabaseGenerator);
    }
}