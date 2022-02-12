<?php

namespace App\Service\Builder;

use App\DTO\Document\AbstractDocument;
use App\Service\Builder\BuilderObject\InfoBuilderObject;
use App\Service\Builder\BuilderObject\InfoBuilderObjectInterface;
use App\Service\Builder\BuilderObject\PathBuilderObject;

interface BuilderInterface
{
    public function getDocument(): AbstractDocument;

    public function buildInfo(InfoBuilderObject $infoBuilderObject): void;

    public function buildPath(PathBuilderObject $pathBuilderObject): void;
}