<?php

namespace App\Modules\MailRuWeather\Infrastructure\Dbal\Repository;

use App\Modules\MailRuWeather\Infrastructure\Dbal\Entity\MailRuWeather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MailRuWeatherRepository extends ServiceEntityRepository
{
    public function __construct (
        private readonly ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager,
    ){
        parent::__construct($registry, MailRuWeather::class);
    }

    public function save(MailRuWeather $entity): int
    {
        //@todo временннный варимнт
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity->getId();
    }
}