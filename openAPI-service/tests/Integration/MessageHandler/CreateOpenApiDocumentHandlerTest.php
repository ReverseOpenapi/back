<?php

namespace App\Tests\Integration\MessageHandler;

use App\Entity\OpenApiDocument;
use App\Messenger\Message\CreateOpenApiDocument;
use Doctrine\ORM\EntityManagerInterface;
use Gaufrette\Filesystem;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateOpenApiDocumentHandlerTest extends WebTestCase
{
    private MessageBusInterface $bus;

    private EntityManagerInterface $entityManager;

    /**
     * directory that holds test generated openapi document
     */
    private string $directory;

    public function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $this->bus = static::getContainer()->get(MessageBusInterface::class);
        $this->directory = static::getContainer()->get(KernelInterface::class)->getProjectDir() . '/var/tests';
        if (!file_exists($this->directory)) {
            mkdir($this->directory);
        }
    }

    public function testHandlerIsSuccessful(): void
    {
        $openApiDocument = $this->entityManager->getRepository(OpenApiDocument::class)->findOneBy([]);
        $this->bus->dispatch(new CreateOpenApiDocument($openApiDocument->getId()));

        $this->assertJsonFileEqualsJsonFile(
            $this->directory . '/../../tests/Fixtures/openapi.json',
            $this->directory . '/document/' . $openApiDocument->getId() . '.json'
        );
    }

    public function tearDown(): void
    {
        $filesystem = static::getContainer()->get(Filesystem::class);

        foreach ($filesystem->keys() as $key) {
            $filesystem->getAdapter()->delete($key);
        }

        rmdir($this->directory);
        unset($this->bus, $this->directory);
    }
}
