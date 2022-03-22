<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        $service = new Service();
        $service
            ->setCaptionImage("Webdesign")
            ->setImage("picto_design.png")
            ->setTitle("Webdesign")
            ->setContent($faker->paragraphs(30, true))
            ->setDescription($faker->words(30, true));
        $manager->persist($service);

        $service = new Service();
        $service
            ->setCaptionImage("Développement")
            ->setImage("picto_dev.png")
            ->setTitle("Développement")
            ->setContent($faker->paragraphs(30, true))
            ->setDescription($faker->words(30, true));
        $manager->persist($service);

        $service = new Service();
        $service
            ->setCaptionImage("Hébergement")
            ->setImage("picto_hebergement.png")
            ->setTitle("Hébergement")
            ->setContent($faker->paragraphs(30, true))
            ->setDescription($faker->words(30, true));
        $manager->persist($service);

        $service = new Service();
        $service
            ->setCaptionImage("Rédactionnel")
            ->setImage("picto_redac.png")
            ->setTitle("Rédactionnel")
            ->setContent($faker->paragraphs(30, true))
            ->setDescription($faker->words(30, true));
        $manager->persist($service);

        $service = new Service();
        $service
            ->setCaptionImage("Référencement")
            ->setImage("picto_seo.png")
            ->setTitle("Référencement")
            ->setContent($faker->paragraphs(30, true))
            ->setDescription($faker->words(30, true));
        $manager->persist($service);

        $manager->flush();
    }
}
