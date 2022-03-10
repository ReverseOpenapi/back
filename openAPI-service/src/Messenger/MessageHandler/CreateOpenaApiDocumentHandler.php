<?php

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\CreateOpenApiDocument;
use App\Service\Generator\GeneratorInterface;
use Gaufrette\Filesystem;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateOpenaApiDocumentHandler implements MessageHandlerInterface
{
    private Filesystem $filesystem;

    private GeneratorInterface $generator;

    public function __construct(Filesystem $filesystem, GeneratorInterface $generator)
    {
        $this->filesystem = $filesystem;
        $this->generator = $generator;
    }

    public function __invoke(CreateOpenApiDocument $message)
    {
        $document = $this->generator->generate($message->getDocumentId());
        $this->filesystem->write('document/' .$document->getId() . '.json', $document->toJson(), true);
    }
}

