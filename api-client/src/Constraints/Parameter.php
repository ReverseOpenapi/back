<?php

namespace App\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Compound;


#[Attribute(Attribute::TARGET_PROPERTY)]
class Parameter extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\Type(type: 'array'),
            new Assert\Collection([
                'name'              => [
                    new Assert\NotBlank,
                    new Assert\Type(type: 'string'),
                ],
                'required'          => [
                    new Assert\NotBlank,
                    new Assert\Type(type: 'bool'),
                ],
                'description'       => new Assert\Type(type: 'string'),
                'location'          => [
                    new Assert\NotBlank,
                    new Assert\Choice(['query', 'header', 'path', 'cookie']),
                ],
                'parameterSchema'   => [
                    new Assert\NotBlank,
                    new Assert\Type(type: 'array'),
                    new Assert\Collection(
                        fields: [
                            'type' => [
                                new Assert\NotBlank,
                                new Assert\Type(type: 'string'),
                                new Assert\Choice(['string', 'integer', 'boolean', 'number'])
                            ]
                        ],
                        allowMissingFields: false
                    ),
                ],
            ])
        ];
    }
}