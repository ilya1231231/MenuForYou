<?php

namespace App\Modules\MailRuWeather\Infrastructure\Dbal\Repository;

use App\Modules\MailRuWeather\Infrastructure\Dbal\Entity\HourlyMailRuWeather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class HourlyMailRuWeatherRepository extends ServiceEntityRepository implements IHourlyMailRuWeatherRepository
{
    public function __construct (
        private readonly ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager,
    ){
        parent::__construct($registry, HourlyMailRuWeather::class);
    }

    public function save(HourlyMailRuWeather $entity): int
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity->getId();
    }
}