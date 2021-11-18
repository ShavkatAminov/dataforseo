<?php

namespace App\DataFixtures;


use App\Entity\System;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SystemFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $data = ['Google', 'Bing', 'Yahoo', 'Yandex', 'Baidu'];
        foreach ($data as $name)
        {
            $system = new System();
            $system
                ->setName($name)
                ->setKey(strtolower($name))
                ->setStatus(true)
                ->setCreatedAt();

             $manager->persist($system);
        }
        $manager->flush();
    }
}
