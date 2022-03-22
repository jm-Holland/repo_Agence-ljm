<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $userRandom = $faker->numberBetween(0, 1);
            if ($userRandom === 1) {
                $user = $this->getReference(UserFixtures::USER_REFERENCE1);
            } else {
                $user = $this->getReference(UserFixtures::USER_REFERENCE2);
            }
            $article = new Article();
            $article
                ->setCaptionImage($faker->words(6, true))
                ->setImage("360x240.png")
                ->setTitle($faker->words(6, true))
                ->setContent($faker->paragraphs(50, true))
                ->setAuthor($user);
            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
