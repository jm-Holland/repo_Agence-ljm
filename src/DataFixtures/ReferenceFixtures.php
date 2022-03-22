<?php

namespace App\DataFixtures;

use App\Entity\Reference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ReferenceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $imageRandom = $faker->numberBetween(0, 4);
            if ($imageRandom === 0) {
                $image = "296x443.png";
                $imageHeight = 443;
            } elseif ($imageRandom === 1) {
                $image = "328x300.png";
                $imageHeight = 300;
            } elseif ($imageRandom === 2) {
                $image = "400x320.png";
                $imageHeight = 320;
            } elseif ($imageRandom === 3) {
                $image = "423x282.png";
                $imageHeight = 282;
            } elseif ($imageRandom === 4) {
                $image = "464x308.png";
                $imageHeight = 308;
            }
            $reference = new Reference();
            $reference
                ->setLink($faker->url)
                ->setName($faker->words(6, true))
                ->setCustomer($faker->company)
                ->setMission($faker->paragraphs(30, true))
                ->setImageHeight($imageHeight)
                ->setCaptionImage($faker->words(6, true))
                ->setImage($image);
            $manager->persist($reference);
        }

        $manager->flush();
    }
}
