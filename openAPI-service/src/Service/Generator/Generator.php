<?php

namespace App\Service\Generator;

use App\Entity\OpenApiDocument;
use App\Service\Document\AbstractDocument;
use App\Entity\Path;
use App\Entity\PathItem;
use App\Repository\OpenApiDocumentRepository;
use App\Service\Builder\BuilderInterface;
use App\Service\Builder\BuilderObject\InfoBuilderObject;
use App\Service\Builder\BuilderObject\OpenApiBuilderObject;
use App\Service\Builder\BuilderObject\ParameterBuilderObject;
use App\Service\Builder\BuilderObject\PathBuilderObject;
use App\Service\Builder\BuilderObject\PathItemBuilderObject;
use App\Service\Builder\BuilderObject\RequestBodyBuilderObject;
use App\Service\Builder\BuilderObject\ResponseBuilderObject;
use App\Service\Builder\BuilderObject\TagBuilderObject;
use App\Service\Hydrator\HydratorInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class Generator implements GeneratorInterface
{
    private OpenApiDocumentRepository $openApiDocumentRepository;

    private BuilderInterface $builder;

    private HydratorInterface $hydrator;

    public function __construct(
        OpenApiDocumentRepository $openApiDocumentRepository,
        BuilderInterface $builder,
        HydratorInterface $hydrator
    ) {
        $this->openApiDocumentRepository = $openApiDocumentRepository;
        $this->builder = $builder;
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     */
    public function generate(string $openApiDocumentId): AbstractDocument
    {
        $openApiDocumentEntity = $this->openApiDocumentRepository->findOneBy(['id' => $openApiDocumentId]);

        if (null === $openApiDocumentEntity) {
            throw new UnrecoverableMessageHandlingException("Document not found in database");
        }

        return $this->buildDocument($openApiDocumentEntity);
    }

    /**
     * Initialize an OpenApiBuilderObject from an OpenApiDocument entity and build the document
     */
    public function buildDocument(OpenApiDocument $openApiDocumentEntity): AbstractDocument
    {
        $openApiObjectBuilder = new OpenApiBuilderObject();
        $infoBuilderObject = $this->hydrator->hydrateFromObject($openApiDocumentEntity, new InfoBuilderObject());
        $openApiObjectBuilder->setInfo($infoBuilderObject);

        foreach ($openApiDocumentEntity->getTags() as $tag) {
            $tagBuilderObject = $this->hydrator->hydrateFromObject($tag, new TagBuilderObject());
            $openApiObjectBuilder->addTag($tagBuilderObject);
        }

        foreach ($openApiDocumentEntity->getPaths() as $path) {
            $pathBuilderObject = $this->getPathBuilderObject($path);
            $openApiObjectBuilder->addPath($pathBuilderObject);
        }

        $document = $this->builder->buildDocument($openApiObjectBuilder);
        $document->setId($openApiDocumentEntity->getId());
        return $document;
    }

    private function getPathBuilderObject(Path $path): PathBuilderObject
    {
        $pathBuilderObject = new PathBuilderObject();
        $pathBuilderObject->setEndpoint($path->getEndpoint());

        foreach ($path->getPathItems() as $pathItem) {
            $pathItemBuilder = $this->getPathItemBuilderObject($pathItem);
            $pathBuilderObject->addPathItem($pathItemBuilder);
        }

        foreach ($path->getParameters() as $parameter) {
            $parameterBuildObject = $this->hydrator->hydrateFromObject($parameter, new ParameterBuilderObject());
            $parameterBuildObject->setLocation($parameter->getLocation())
                ->setSchema($parameter->getParameterSchema());
            $pathBuilderObject->addParameter($parameterBuildObject);
        }

        return $pathBuilderObject;
    }

    private function getPathItemBuilderObject(PathItem $pathItem): PathItemBuilderObject
    {
        $pathItemBuilder = $this->hydrator->hydrateFromObject($pathItem, new PathItemBuilderObject());
        $pathItemBuilder->setHttpMethod(strtolower($pathItem->getHttpMethod()));

        if ($pathItem->getRequestBody()) {
            $requestBodyBuilderObject = $this->hydrator->hydrateFromObject($pathItem->getRequestBody(), new RequestBodyBuilderObject());
            $pathItemBuilder->setRequestBody($requestBodyBuilderObject);
        }

        foreach ($pathItem->getResponses() as $response) {
            $responseBuilderObject = $this->hydrator->hydrateFromObject($response, new ResponseBuilderObject());
            $pathItemBuilder->addResponse($responseBuilderObject);
        }

        foreach ($pathItem->getTags() as $tag) {
            $pathItemBuilder->addTag($tag->getName());
        }

        foreach ($pathItem->getParameters() as $parameter) {
            $parameterBuildObject = $this->hydrator->hydrateFromObject($parameter, new ParameterBuilderObject());
            $parameterBuildObject->setLocation($parameter->getLocation())
                ->setSchema($parameter->getParameterSchema());
            $pathItemBuilder->addParameter($parameterBuildObject);
        }

        return $pathItemBuilder;
    }
}
