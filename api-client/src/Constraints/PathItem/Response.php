<?php

namespace App\Constraints\PathItem;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Response extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Type(type: 'array'),
            new Assert\Collection([
                "httpStatusCode"    => [
                    new Assert\NotBlank,
                    new Assert\Type(type: 'integer')
                ],
                "description"       => new Assert\Optional(new Assert\Type(type: 'string')),
                "content"           => new Assert\Optional(new Assert\Type(type: 'array'))
            ])
        ];
    }
}