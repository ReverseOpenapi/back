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


    /**
     * Create an Open Api Document Entity and set all his connection
     *
     * @return OpenApiDocument
     */
    public function getDocument() : OpenApiDocument
    {

        $this->document = new OpenApiDocument([
            'title'         => $this->title,
            'description'   => $this->description,
            'version'       => $this->version,
            'tags'          => $this->tags,
            'paths'         => $this->paths,
        ]);

        if ($this->tags && count($this->tags)) $this->setTags();

        if ($this->paths && count($this->paths)) $this->setPaths();


        return $this->document;
    }

    /**
     * Create Paths with his path items (if any) and add them to an Open Api Document
     *
     * @return void
     */
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
     * Generate an array of Path Items with his parameters, responses and request body (if any)
     *
     * @param  array $pathItems
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

            if(isset($pathItem['tags'])) {

                $tags = $this->getPathItemTags($pathItem['tags']);
                $pathItemEntity->addTags($tags);
            }

            $pathItemEntities[] = $pathItemEntity;
        }


        return $pathItemEntities;
    }

    /**
     * Create an array of Parameter Entity
     *
     * @param  array $parameters
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
     * Create an array of Response Entity
     *
     * @param  array $responses
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

    /**
     * Return an array of Tags if they exist in the Path Item
     *
     * @param  array $tagsName
     * @return Tag[]
     */
    public function getPathItemTags(array $tagsName) : array
    {
        return array_filter($this->tags, function($tag) use ($tagsName) {

            return in_array($tag->getName(), $tagsName);
        });
    }

    /**
     * Add payload tags to an Open Api Document
     *
     * @return void
     */
    public function setTags() : void
    {
        $entityTags = [];

        foreach ($this->tags as $key => $tag) {

            $tag = new Tag($tag);

            $this->document->addTag($tag);
            $entityTags[] = $tag;
        }

        $this->tags = $entityTags;
    }
}