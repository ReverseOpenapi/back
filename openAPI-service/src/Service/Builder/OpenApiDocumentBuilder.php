<?php

namespace App\Service\Builder;

use App\DTO\Document\AbstractDocument;
use App\DTO\Document\Info;
use App\DTO\Document\Parameter;
use App\DTO\Document\Path;
use App\DTO\Document\PathItem;
use App\DTO\Document\RequestBody;
use App\DTO\Document\Response;
use App\Service\Builder\BuilderObject\InfoBuilderObject;
use App\Service\Builder\BuilderObject\InfoBuilderObjectInterface;
use App\Service\Builder\BuilderObject\PathBuilderObject;
use App\Service\Builder\BuilderObject\PathBuilderObjectInterface;
use App\DTO\Document\OpenApi;
use App\Service\Hydrator\HydratorInterface;
use App\Tests\Fixtures\PathObject;

class OpenApiDocumentBuilder implements BuilderInterface
{
    private AbstractDocument $document;

    private HydratorInterface $hydrator;

    public function __construct(HydratorInterface $hydrator)
    {
        $this->document = new OpenApi();
        $this->hydrator = $hydrator;
    }

    public function getDocument(): OpenApi
    {
        return $this->document;
    }

    public function buildInfo(InfoBuilderObject $infoBuilderObject): void
    {
        $info = $this->hydrator->hydrateFromObject($infoBuilderObject, new Info());
        $this->document->setInfo($info);
    }

    // TODO refactor
    public function buildPath(PathBuilderObject $pathBuilderObject): void
    {
        $path = $this->hydrator->hydrateFromObject($pathBuilderObject, new Path());

        foreach ($pathBuilderObject->getPathItems() as $pathItemBuilderObject) {
            $pathItem = $this->hydrator->hydrateFromObject($pathItemBuilderObject, new PathItem());
            if ($pathItemBuilderObject->getRequestBody()) {
                $requestBody = $this->hydrator->hydrateFromObject($pathItemBuilderObject->getRequestBody(), new RequestBody());
                $pathItem->setRequestBody($requestBody);
            }

            foreach ($pathItemBuilderObject->getResponses() as $responseBuilderObject) {
                $response = $this->hydrator->hydrateFromObject($responseBuilderObject, new Response());
                $pathItem->addResponse($response);
            }
            $path->addPathItem($pathItem);
        }

        foreach ($pathBuilderObject->getParameters() as $parameterBuilderObject) {
            $parameter = $this->hydrator->hydrateFromObject($parameterBuilderObject, new Parameter());
            $path->addParameter($parameter);
        }

        $this->document->addPath($path);
    }
}