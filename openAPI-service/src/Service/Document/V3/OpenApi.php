<?php

namespace App\Service\Document\V3;

use App\Service\Document\AbstractDocument;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;

class OpenApi extends AbstractDocument
{
    #[SerializedName('openapi')]
    private string $openApiVersion = '3.0.0';

    #[SerializedName('info')]
    private Info $info;

    /**
     * @var iterable<Tag>|null
     */
    #[SerializedName('tags')]
    private ?iterable $tags = null;

    /**
     * @var iterable<Path>
     */
    #[SerializedName('paths')]
    private iterable $paths = [];

    public function getOpenApiVersion(): string
    {
        return $this->openApiVersion;
    }

    public function getInfo(): Info
    {
        return $this->info;
    }

    public function setInfo(Info $info): OpenApi
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return iterable<Path>
     */
    public function getPaths(): iterable
    {
        return $this->paths;
    }

    public function addPath(Path $path): self
    {
        array_push($this->paths, $path);

        return $this;
    }

    #[Ignore]
    final function getNormalizerCallbacks(): array
    {
        $paths = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            $serializedFields = [];
            foreach ($innerObject as $path) {
                if ($path->getParameters()) {
                    $serializedFields[$path->getEndpoint()]['parameters'] = $path->getParameters();
                }
                foreach($path->getPathItems() as $pathItem) {
                    $serializedFields[$path->getEndpoint()][$pathItem->getHttpMethod()] = $pathItem;
                }
            }
            return $serializedFields;
        };

        $responses = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            $serializedFields = [];
            foreach ($innerObject as $response) {
                $serializedFields[$response->getHttpStatusCode()] = $response;
            }
            return $serializedFields;
        };


        return [
            'paths' => $paths,
            'responses' => $responses
        ];
    }

    public function getTags(): iterable|null
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if ($this->tags === null) {
            $this->tags = [];
        }

        array_push($this->tags, $tag);
        return $this;
    }

}