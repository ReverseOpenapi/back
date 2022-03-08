<?php

namespace App\Tests\Unit\Service;

use App\Service\Document\AbstractDocument;
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
        $this->openApi->setId('b842cac0-cbe1-401e-b4bc-97b39c97cc1d');
        $this->assertIsString($this->openApi->toJson());
        $this->assertIsString($this->openApi->toYaml());
        $this->assertEquals('b842cac0-cbe1-401e-b4bc-97b39c97cc1d', $this->openApi->getId());
    }

    public function tearDown(): void
    {
        unset($this->openApi);
    }
}
