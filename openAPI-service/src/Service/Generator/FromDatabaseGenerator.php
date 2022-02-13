<?php

namespace App\Service\Generator;

use App\DTO\Document\AbstractDocument;
use App\Repository\OpenApiDocumentRepository;
use App\Service\Builder\BuilderInterface;
use App\Service\Builder\BuilderObject\InfoBuilderObject;
use App\Service\Builder\BuilderObject\ParameterBuilderObject;
use App\Service\Builder\BuilderObject\PathBuilderObject;
use App\Service\Builder\BuilderObject\PathItemBuilderObject;
use App\Service\Builder\BuilderObject\RequestBodyBuilderObject;
use App\Service\Builder\BuilderObject\ResponseBuilderObject;
use App\Service\Builder\BuilderObject\TagBuilderObject;
use App\Service\Hydrator\HydratorInterface;

class FromDatabaseGenerator implements GeneratorInterface
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

    public function generate(string $openApiDocumentId): AbstractDocument
    {
        $openApiDocumentEntity = $this->openApiDocumentRepository->findOneBy(['id' => $openApiDocumentId]);

        $infoBuilderObject = $this->hydrator->hydrateFromObject($openApiDocumentEntity, new InfoBuilderObject());
        $this->builder->buildInfo($infoBuilderObject);


        foreach ($openApiDocumentEntity->getTags() as $tag) {
            $tagBuilderObject = $this->hydrator->hydrateFromObject($tag, new TagBuilderObject());
            $this->builder->buildTag($tagBuilderObject);
        }

        foreach ($openApiDocumentEntity->getPaths() as $path) {
            $pathBuilderObject = new PathBuilderObject();
            $pathBuilderObject->setEndpoint($path->getEndpoint());

            foreach ($path->getItems() as $pathItem) {
                $pathItemBuilder = $this->hydrator->hydrateFromObject($pathItem, new PathItemBuilderObject());
                $pathItemBuilder->setHttpMethod(strtolower($pathItem->getHttpMethod()->getMethod()));

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

                $pathBuilderObject->addPathItem($pathItemBuilder);
            }

            foreach ($path->getParameters() as $parameter) {
                $parameterBuildObject = $this->hydrator->hydrateFromObject($parameter, new ParameterBuilderObject());
                $parameterBuildObject->setLocation($parameter->getLocation()->getLocation())
                    ->setSchema($parameter->getParameterSchema());
                $pathBuilderObject->addParameter($parameterBuildObject);
            }
            $this->builder->buildPath($pathBuilderObject);
        }

        return $this->builder->getDocument();
    }
}