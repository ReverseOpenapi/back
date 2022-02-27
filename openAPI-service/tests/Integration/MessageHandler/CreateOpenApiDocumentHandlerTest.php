<?php

namespace App\Tests\Integration\MessageHandler;

use App\Message\CreateOpenApiDocument;
use Gaufrette\Filesystem;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateOpenApiDocumentHandlerTest extends WebTestCase
{
    private MessageBusInterface $bus;

    /**
     * directory that holds test generated openapi document
     */
    private string $directory;

    public function setUp(): void
    {
        self::bootKernel();
        $this->bus = static::getContainer()->get(MessageBusInterface::class);
        $this->directory = static::getContainer()->get(KernelInterface::class)->getProjectDir() . '/var/tests';
        if (!file_exists($this->directory)) {
            mkdir($this->directory);
        }
    }

    public function testHandlerIsSuccessful(): void
    {
        $this->bus->dispatch(new CreateOpenApiDocument(1));

        $this->assertJsonFileEqualsJsonFile(
            $this->directory . '/../../tests/fixtures/openapi.json',
            $this->directory . '/b842cac0-cbe1-401e-b4bc-97b39c97cc1d/openapi.json'
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
