<?php

namespace App\Modules\MailRuWeather\Infrastructure\Dbal\Repository;

use App\Modules\MailRuWeather\Infrastructure\Dbal\Entity\MailRuWeather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MailRuWeatherRepository extends ServiceEntityRepository
{
    public function __construct(
        private readonly ManagerRegistry        $registry,
        private readonly EntityManagerInterface $entityManager,
    )
    {
        parent::__construct($registry, MailRuWeather::class);
    }

    public function save(MailRuWeather $entity): int
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity->getId();
    }

    /**
     * @return MailRuWeather[]
     * */
    public function getAllByDay(\DateTime $dateTime): array
    {
        $qb = $this->createQueryBuilder('m');
        return $qb
            ->where(
                $qb->expr()->like('m.datetime', ':date'),
            )
            ->orderBy('m.datetime')
            ->setParameter('date', $dateTime->format('Y-m-d') . '%')
            ->getQuery()
            ->getResult();
    }
}