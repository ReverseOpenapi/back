<?php

namespace App\Service\Generator;

use App\Service\Document\V3\AbstractDocument;

/**
 * OpenAPI document generator
 *
 * It generates a OpenAPI document from a specific source
 */
interface GeneratorInterface
{
    /**
     * Retrieve an OpenAPI document from source and generate a document in a specific format
     *
     * @param string $openApiDocumentId database id of the document to generate
     * @return AbstractDocument the generated document
     */
    public function generate(string $openApiDocumentId): AbstractDocument;
}