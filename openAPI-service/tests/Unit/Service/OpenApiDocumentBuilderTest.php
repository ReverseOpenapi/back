<?php

namespace App\Tests\Service;

use App\DTO\Document\OpenApi;
use App\Service\Builder\BuilderInterface;
use App\Service\Builder\BuilderObject\ParameterBuilderObject;
use App\Service\Builder\BuilderObject\RequestBodyBuilderObject;
use App\Service\Builder\BuilderObject\ResponseBuilderObject;
use App\Service\Builder\OpenApiDocumentBuilder;
use App\Service\Builder\BuilderObject\InfoBuilderObject;
use App\Service\Builder\BuilderObject\PathBuilderObject;
use App\Service\Builder\BuilderObject\PathItemBuilderObject;
use App\Service\Hydrator\Hydrator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;

class OpenApiDocumentBuilderTest extends KernelTestCase
{
    private BuilderInterface $builder;

    private SerializerInterface $serializer;

    public function setUp(): void
    {
        // TODO: find a way to mock Hydrator
        $this->builder = new OpenApiDocumentBuilder(new Hydrator());
    }

    public function testGetDocument(): void
    {
        $this->assertInstanceOf(OpenApi::class, $this->builder->getDocument());
        $this->assertEquals('3.0.0', $this->builder->getDocument()->getOpenApiVersion());
    }

    public function testBuildInfo(): void
    {
        $infoBuilderObject = new InfoBuilderObject();
        $infoBuilderObject->setTitle('Pet Store')
            ->setDescription('This is a Pet Store')
            ->setVersion("1.0.0");
        $this->builder->buildInfo($infoBuilderObject);
        $this->assertEquals('Pet Store', $this->builder->getDocument()->getInfo()->getTitle());
        $this->assertEquals('This is a Pet Store', $this->builder->getDocument()->getInfo()->getDescription());
        $this->assertEquals('1.0.0', $this->builder->getDocument()->getInfo()->getVersion());


        $infoBuilderObject = new InfoBuilderObject();
        $infoBuilderObject->setTitle('Pet Store')
            ->setVersion("1.0.0");
        $this->builder->buildInfo($infoBuilderObject);
        $this->assertEquals('Pet Store', $this->builder->getDocument()->getInfo()->getTitle());
        $this->assertEquals('1.0.0', $this->builder->getDocument()->getInfo()->getVersion());
        $this->assertNull($this->builder->getDocument()->getInfo()->getDescription());
    }

    // TODO refactor this test
    public function testBuildPath(): void
    {
        $path = new PathBuilderObject();
        $path->setEndpoint('/pet');
        $pathItem = new PathItemBuilderObject();
        $pathItem->setHttpMethod('get')
            ->setSummary('Find a pet')
            ->setDescription('Find a pet in the Pet Store');

        $response = new ResponseBuilderObject();
        $response->setHttpStatusCode(200)
            ->setDescription('Success')
            ->setContent([
                'id' => 0,
                'name' => 'doggie'
            ]);

        $requestBody = new RequestBodyBuilderObject();
        $requestBody->setDescription('Pet object that needs to be added to the store')
            ->setRequired(true)
            ->setContent([
            'id' => 0,
            'name' => 'doggie'
        ]);
        $pathItem->setRequestBody($requestBody);

        $parameter = new ParameterBuilderObject();
        $parameter->setName('petId')
            ->setLocation('query')
            ->setDescription('ID of pet to return')
            ->setRequired(true);

        $pathItem->addResponse($response);
        $path->addParameter($parameter);
        $path->addPathItem($pathItem);

        $this->builder->buildPath($path);

        $this->assertEquals('/pet', $this->builder->getDocument()->getPaths()[0]->getEndpoint());
        $this->assertEquals('get', $this->builder->getDocument()->getPaths()[0]->getPathItems()[0]->getHttpMethod());
        $this->assertEquals('Find a pet', $this->builder->getDocument()->getPaths()[0]->getPathItems()[0]->getSummary());
        $this->assertEquals('Find a pet in the Pet Store', $this->builder->getDocument()->getPaths()[0]->getPathItems()[0]->getDescription());
        $this->assertEquals('Success', $this->builder->getDocument()->getPaths()[0]->getPathItems()[0]->getResponses()[0]->getDescription());
        $this->assertEquals(200, $this->builder->getDocument()->getPaths()[0]->getPathItems()[0]->getResponses()[0]->getHttpStatusCode());
        $this->assertEquals([
            'application/json' => [
                'schema' => [
                    'id' => 0,
                    'name' => 'doggie'
                ]
            ]
        ], $this->builder->getDocument()->getPaths()[0]->getPathItems()[0]->getResponses()[0]->getContent());

        $this->assertEquals('petId', $this->builder->getDocument()->getPaths()[0]->getParameters()[0]->getName());
        $this->assertEquals('query', $this->builder->getDocument()->getPaths()[0]->getParameters()[0]->getLocation());
        $this->assertEquals('ID of pet to return', $this->builder->getDocument()->getPaths()[0]->getParameters()[0]->getDescription());
        $this->assertEquals(true, $this->builder->getDocument()->getPaths()[0]->getParameters()[0]->isRequired());
        $this->assertEquals([
            'application/json' => [
                'schema' => [
                    'id' => 0,
                    'name' => 'doggie'
                ]
            ]
        ], $this->builder->getDocument()->getPaths()[0]->getPathItems()[0]->getRequestBody()->getContent());
        $this->assertEquals('Pet object that needs to be added to the store', $this->builder->getDocument()->getPaths()[0]->getPathItems()[0]->getRequestBody()->getDescription());
        $this->assertEquals(true, $this->builder->getDocument()->getPaths()[0]->getPathItems()[0]->getRequestBody()->getRequired());
    }

    public function tearDown(): void
    {
        unset($this->builder);
    }
}
