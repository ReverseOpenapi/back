<?php

namespace App\Service\Generator;

use App\DTO\Document\AbstractDocument;

interface GeneratorInterface
{
    public function generate(string $openApiDocumentId): AbstractDocument;
}