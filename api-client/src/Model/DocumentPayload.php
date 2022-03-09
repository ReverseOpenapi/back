<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;
use App\Constraints\{Tags, Paths};

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


    public function __construct(array $data = []) {

        if (count($data)) {
            $this->title = $data['title'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->version = $data['version'] ?? null;
            $this->tags = $data['tags'] ?? null;
            $this->paths = $data['paths'] ?? null;
        }
    }
}