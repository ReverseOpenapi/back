<?php

namespace App\Service\Hydrator;

interface HydratorInterface
{
    public function hydrateFromObject(object $object, object $objectToHydrate): object;
}