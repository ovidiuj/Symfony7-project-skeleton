<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\InMemoryUser;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private ContainerBagInterface $containerBag
    ){}

    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->setEmail($this->containerBag->get('admin.email'));
         $user->setPassword($this->passwordEncoder->hashPassword($user, $this->containerBag->get('admin.password')));
         $user->setRoles([User::ROLE_ADMIN]);
         $user->setStatus(User::STATUS_ACTIVE);
         $user->setUsername($this->containerBag->get('admin.username'));

         $manager->persist($user);

        $manager->flush();

        echo $this->containerBag->get('admin.password');
    }
}
