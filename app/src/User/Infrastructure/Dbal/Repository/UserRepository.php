<?php

namespace App\User\Infrastructure\Dbal\Repository;

use App\User\Domain\IUserDomainRepository;
use App\User\Domain\UserDomain;
use App\User\Infrastructure\Dbal\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, IUserDomainRepository
{

    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct (
        ManagerRegistry $registry,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
    ){
        parent::__construct($registry, User::class);
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // TODO: Implement upgradePassword() method.
    }

    public function create(UserDomain $userDomain): int
    {
        $user = new User();
        $user->setEmail($userDomain->getEmail());
        $user->setPassword($userDomain->getPassword());
        $user->setRoles($userDomain->getRoles());

        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user->getId();
    }
}