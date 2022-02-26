<?php

namespace App\MessageHandler;

use App\Message\CreateOpenApiDocument;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateOpenaApiDocumentHandler implements MessageHandlerInterface
{
    public function __invoke(CreateOpenApiDocument $message)
    {
        // TODO: generate document and store it somewhere
        dump('Will create document for id '.$message->getDocumentId());
    }
}
