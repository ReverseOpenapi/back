<?php

namespace App\Messenger\Message;

class CreateOpenApiTests
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
