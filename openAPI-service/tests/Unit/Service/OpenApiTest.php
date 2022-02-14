<?php

namespace App\Tests\Unit\Service;

use App\Service\Document\V3\AbstractDocument;
use App\Service\Document\V3\OpenApi;
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
        $this->assertIsString($this->openApi->toJson());
        $this->assertIsString($this->openApi->toYaml());
    }

    public function tearDown(): void
    {
        unset($this->openApi);
    }
}
