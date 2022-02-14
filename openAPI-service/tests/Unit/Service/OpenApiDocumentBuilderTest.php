<?php

namespace App\Tests\Unit\Service;

use App\Service\Document\V3\OpenApi;
use App\Service\Builder\BuilderInterface;
use App\Service\Builder\BuilderObject\OpenApiBuilderObject;
use App\Service\Builder\BuilderObject\ParameterBuilderObject;
use App\Service\Builder\BuilderObject\RequestBodyBuilderObject;
use App\Service\Builder\BuilderObject\ResponseBuilderObject;
use App\Service\Builder\BuilderObject\TagBuilderObject;
use App\Service\Builder\DocumentV3Builder;
use App\Service\Builder\BuilderObject\InfoBuilderObject;
use App\Service\Builder\BuilderObject\PathBuilderObject;
use App\Service\Builder\BuilderObject\PathItemBuilderObject;
use App\Service\Hydrator\Hydrator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OpenApiDocumentBuilderTest extends KernelTestCase
{
    private BuilderInterface $builder;

    private OpenApi $document;

    public function testBuildDocument(): void
    {
        $this->builder = new DocumentV3Builder(new Hydrator());
        $openApiBuilderObject = $this->createOpenApiBuilderObject();
        $this->document = $this->builder->buildDocument($openApiBuilderObject);

        $this->assertBuildInfo();
        $this->assertBuildPath();
        $this->assertBuildPathItem();
        $this->assertBuildRequestBody();
        $this->assertBuildResponse();
        $this->assertBuildParameter();
        $this->assertBuildTag();
    }

    public function assertBuildInfo(): void
    {
        $this->assertEquals('Pet Store', $this->document->getInfo()->getTitle());
        $this->assertEquals('This is a Pet Store', $this->document->getInfo()->getDescription());
        $this->assertEquals('1.0.0', $this->document->getInfo()->getVersion());
    }

    public function assertBuildPath(): void
    {
        $this->assertEquals('/pet', $this->document->getPaths()[0]->getEndpoint());
    }

    public function assertBuildPathItem(): void
    {
        $this->assertEquals('get', $this->document->getPaths()[0]->getPathItems()[0]->getHttpMethod());
        $this->assertEquals('Find a pet', $this->document->getPaths()[0]->getPathItems()[0]->getSummary());
        $this->assertEquals('Find a pet in the Pet Store', $this->document->getPaths()[0]->getPathItems()[0]->getDescription());
        $this->assertEquals('pet', $this->document->getPaths()[0]->getPathItems()[0]->getTags()[0]);
    }

    public function assertBuildRequestBody(): void
    {
        $this->assertEquals('Pet object that needs to be added to the store', $this->document->getPaths()[0]->getPathItems()[0]->getRequestBody()->getDescription());
        $this->assertEquals(true, $this->document->getPaths()[0]->getPathItems()[0]->getRequestBody()->getRequired());
    }

    public function assertBuildResponse(): void
    {
        $this->assertEquals('Success', $this->document->getPaths()[0]->getPathItems()[0]->getResponses()[0]->getDescription());
        $this->assertEquals(200, $this->document->getPaths()[0]->getPathItems()[0]->getResponses()[0]->getHttpStatusCode());
        $this->assertEquals([
            'application/json' => [
                'schema' => [
                    'id' => 0,
                    'name' => 'doggie'
                ]
            ]
        ], $this->document->getPaths()[0]->getPathItems()[0]->getResponses()[0]->getContent());
    }

    public function assertBuildParameter(): void
    {
        $this->assertEquals('petId', $this->document->getPaths()[0]->getParameters()[0]->getName());
        $this->assertEquals('query', $this->document->getPaths()[0]->getParameters()[0]->getLocation());
        $this->assertEquals('ID of pet to return', $this->document->getPaths()[0]->getParameters()[0]->getDescription());
        $this->assertEquals(true, $this->document->getPaths()[0]->getParameters()[0]->getRequired());
        $this->assertEquals([
            'application/json' => [
                'schema' => [
                    'id' => 0,
                    'name' => 'doggie'
                ]
            ]
        ], $this->document->getPaths()[0]->getPathItems()[0]->getRequestBody()->getContent());
    }

    public function assertBuildTag(): void
    {
        $this->assertEquals('Everything about your Pets', $this->document->getTags()[0]->getDescription());
        $this->assertEquals('Pet', $this->document->getTags()[0]->getName());

    }

    protected function createOpenApiBuilderObject(): OpenApiBuilderObject
    {
        $openApiBuilderObject = new OpenApiBuilderObject();

        $infoBuilderObject = new InfoBuilderObject();
        $infoBuilderObject->setTitle('Pet Store')
            ->setDescription('This is a Pet Store')
            ->setVersion("1.0.0");

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
        $pathItem->setRequestBody($requestBody)
            ->addTag('pet');

        $parameter = new ParameterBuilderObject();
        $parameter->setName('petId')
            ->setLocation('query')
            ->setDescription('ID of pet to return')
            ->setRequired(true);

        $tag = new TagBuilderObject();
        $tag->setName('Pet')
            ->setDescription('Everything about your Pets');

        $pathItem->addResponse($response);
        $path->addParameter($parameter);
        $path->addPathItem($pathItem);
        $openApiBuilderObject->setInfo($infoBuilderObject);
        $openApiBuilderObject->addTag($tag);
        $openApiBuilderObject->addPath($path);

        return $openApiBuilderObject;
    }

    public function tearDown(): void
    {
        unset($this->builder, $this->document);
    }
}
