<?php

namespace App\Tests\Unit\Service\Generator;

use App\Service\Document\AbstractDocument;
use App\Entity\OpenApiDocument;
use App\Repository\OpenApiDocumentRepository;
use App\Service\Builder\Factory\BuilderFactoryInterface;
use App\Service\Builder\BuilderInterface;
use App\Service\Generator\Generator;
use App\Service\Generator\GeneratorInterface;
use App\Service\Builder\BuilderObject\InfoBuilderObject;
use App\Service\Hydrator\Hydrator;
use App\Service\Hydrator\HydratorInterface;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    private GeneratorInterface $generator;

    public function setUp(): void
    {
        $openApiDocument = new OpenApiDocument();
        $openApiDocument->setId('b842cac0-cbe1-401e-b4bc-97b39c97cc1d');
        $openApiDocument->setTitle('Pet Store');

        $openApiDocumentRepository = $this->createMock(OpenApiDocumentRepository::class);
        $openApiDocumentRepository->method('findOneBy')
            ->willReturn($openApiDocument);
        $builder = $this->createMock(BuilderInterface::class);
        $this->generator = new Generator($openApiDocumentRepository, $builder, new Hydrator());
    }

    public function testGenerationFromDatabase(): void
    {
        $openApi = $this->generator->generate('b842cac0-cbe1-401e-b4bc-97b39c97cc1d');
        $this->assertInstanceOf(AbstractDocument::class, $openApi);
    }

    public function tearDown(): void
    {
        unset($this->fromDatabaseGenerator);
    }
}