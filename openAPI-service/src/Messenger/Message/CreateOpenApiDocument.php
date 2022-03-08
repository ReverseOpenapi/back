<?php

namespace App\Messenger\Message;

class CreateOpenApiDocument
{
    private string $documentId;

    public function __construct(string $documentId)
    {
        $this->documentId = $documentId;
    }

    public function getDocumentId(): string
    {
        return $this->documentId;
    }
}
