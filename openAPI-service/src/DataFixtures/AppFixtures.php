<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $loader = new \Nelmio\Alice\Loader\NativeLoader();
        $objectSet = $loader->loadFile(__DIR__ . '/OpenApiDocumentFixtures.yaml')->getObjects();
        foreach ($objectSet as $object) {
            $manager->persist($object);
        }

        $manager->flush();
    }
}
