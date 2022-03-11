<?php

namespace App\Constraints\PathItem;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;


#[Attribute(Attribute::TARGET_PROPERTY)]
class RequestBody extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Type(type: 'array'),
            new Assert\Collection([
                'description'   => new Assert\Optional(new Assert\Type(type: 'string')),
                'required'      => [
                    new Assert\NotBlank,
                    new Assert\Type(type: 'bool')
                ],
                'content'       =>  [
                    new Assert\NotBlank,
                    new Assert\Type(type: 'array'),
                ]
            ]),
        ];
    }
}