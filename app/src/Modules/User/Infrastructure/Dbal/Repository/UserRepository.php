<?php

namespace App\Modules\User\Infrastructure\Dbal\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use App\Modules\User\Domain\IUserDomainRepository;
use App\Modules\User\Domain\UserDomain;
use App\Modules\User\Infrastructure\Dbal\Entity\User;

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