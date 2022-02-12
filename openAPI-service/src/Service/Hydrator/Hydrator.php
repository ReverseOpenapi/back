<?php

namespace App\Service\Hydrator;

class Hydrator implements HydratorInterface
{
    public function hydrateFromObject(object $object, object $objectToHydrate): object
    {
        $reflection = new \ReflectionClass($object);
        foreach ($reflection->getProperties() as $reflectionProperty) {
            $property = $reflectionProperty->getName();
            $setter = 'set'.$property;
            if (method_exists($objectToHydrate, $setter) && $reflectionProperty->getValue($object)) {
                try {
                    $objectToHydrate->$setter($reflectionProperty->getValue($object));
                } catch (\TypeError $e) {

                }
            }
        }

        return $objectToHydrate;
    }
}