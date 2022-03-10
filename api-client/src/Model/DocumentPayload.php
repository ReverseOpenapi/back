<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;
use App\Constraints\{Tags, Paths};
use App\Entity\{
    Tag,
    Path,
    PathItem,
    OpenApiDocument,
    Parameter,
    HttpResponse,
    RequestBody
};

class DocumentPayload {

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $title;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $description;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    private $version;

    #[Tags]
    private $tags;

    #[Paths]
    private $paths;

    private OpenApiDocument $document;


    public function __construct(array $data = []) {

        if (count($data)) {

            $this->title        = $data['title'] ?? null;
            $this->description  = $data['description'] ?? null;
            $this->version      = $data['version'] ?? null;
            $this->tags         = $data['tags'] ?? null;
            $this->paths        = $data['paths'] ?? null;
        }
    }


    public function getDocument() : OpenApiDocument
    {

        $this->document = new OpenApiDocument([
            'title'         => $this->title,
            'description'   => $this->description,
            'version'       => $this->version,
            'tags'          => $this->tags,
            'paths'         => $this->paths,
        ]);

        if ($this->paths && count($this->paths)) $this->setPaths();

        if ($this->tags && count($this->tags)) $this->setTags();

        return $this->document;
    }

    public function setPaths() : void
    {

        foreach ($this->paths as $key => $path) {
            $pathEntity = new Path($path);

            if (isset($path['pathItems']) && count($path['pathItems'])) {

                $pathItems = $this->getPathItems($path['pathItems']);

                $pathEntity->addPathItems($pathItems);

            }

            $this->document->addPath($pathEntity);
        }
    }

    /**
     * @return PathItem[]
     */
    public function getPathItems(array $pathItems) : array
    {
        $pathItemEntities = [];

        foreach ($pathItems as $key => $pathItem) {

            $pathItemEntity = new PathItem($pathItem);

            if (isset($pathItem['parameters']) && count($pathItem['parameters'])) {

                $parameters = $this->getParameters($pathItem['parameters']);
                $pathItemEntity->addParameters($parameters);
            }

            if (isset($pathItem['responses']) && count($pathItem['responses'])) {

                $responses = $this->getResponses($pathItem['responses']);
                $pathItemEntity->addResponses($responses);
            }

            if (isset($pathItem['requestBody'])) {

                $requestBody = new RequestBody($pathItem['requestBody']);
                $pathItemEntity->setRequestBody($requestBody);
            }

            $pathItemEntities[] = $pathItemEntity;
        }


        return $pathItemEntities;
    }

    /**
     * @return Parameter[]
     */
    public function getParameters(array $parameters) : array
    {

        return array_map(
            function ($parameter) : Parameter {
                return new Parameter($parameter);
            },
            $parameters
        );
    }

    /**
     * @return HttpResponse[]
     */
    public function getResponses(array $responses) : array
    {

        return array_map(
            function ($response) : HttpResponse {
                return new HttpResponse($response);
            },
            $responses
        );
    }

    public function setTags() : void
    {

        foreach ($this->tags as $key => $tag) {

            $tag = new Tag($tag);
            $this->document->addTag($tag);

        }
    }


}