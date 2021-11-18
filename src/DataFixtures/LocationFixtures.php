<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Repository\SystemRepository;
use App\Service\DataForSeo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    private DataForSeo $dataForSeo;
    private SystemRepository $systemRepository;

    public function __construct(
        DataForSeo       $dataForSeo,
        SystemRepository $systemRepository
    )
    {
        $this->systemRepository = $systemRepository;
        $this->dataForSeo = $dataForSeo;
    }

    public function load(ObjectManager $manager): void
    {
        $systems = $this->systemRepository->findActiveAll();
        foreach ($systems as $system) {
            $locations = $this->dataForSeo->getLocations($system->getKey());
            echo "Loading ".$system->getName()." system locations ...\n";
            foreach ($locations as $location) {
                $entity = new Location();
                $entity
                    ->setSystem($system)
                    ->setLocationCode($location['location_code'])
                    ->setLocationName($location['location_name'])
                    ->setLocationCodeParent($location['location_code_parent'])
                    ->setCountryIsoCode($location['country_iso_code'])
                    ->setLocationType($location['location_type'])
                    ->setCreatedAt();

                $manager->persist($entity);
            }
            $manager->flush();
            echo "Loaded ".count($locations). " locations\n";
        }
    }

    public function getDependencies(): array
    {
        return [
            SystemFixtures::class
        ];
    }
}
