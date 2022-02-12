<?php

namespace App\Tests\Unit\Service;

use App\DTO\Document\AbstractDocument;
use App\DTO\Document\OpenApi;
use PHPUnit\Framework\TestCase;

class OpenApiTest extends TestCase
{
    private AbstractDocument $openApi;

    public function setUp(): void
    {
        $this->openApi = new OpenApi();
    }

    public function testReturnedValues(): void
    {
//        $this->assertIsArray($this->openApi->getDocument());
        $this->assertIsString($this->openApi->toJson());
        $this->assertIsString($this->openApi->toYaml());
    }

    public function tearDown(): void
    {
        unset($this->openApi);
    }
}
