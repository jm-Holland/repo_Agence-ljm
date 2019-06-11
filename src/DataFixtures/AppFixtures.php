<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {


        // Add users
        $user = new User();
        $user->setUsername("Luke")
            ->setPassword($this->passwordEncoder->encodePassword($user, 'Password'));
        $manager->persist($user);


        $user1 = new User();
        $user1->setUsername("jm")
            ->setPassword($this->passwordEncoder->encodePassword($user, 'Password'));
        $manager->persist($user1);

        $manager->flush();
    }
}
