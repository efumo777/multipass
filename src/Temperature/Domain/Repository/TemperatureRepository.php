<?php

namespace App\Temperature\Domain\Repository;

use App\Temperature\Domain\Entity\Temperature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Temperature>
 *
 * @method Temperature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temperature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temperature[]    findAll()
 * @method Temperature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemperatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temperature::class);
    }

    public function calculateAverageTemperature($rangeFrom, $rangeTill): float
    {
        return $this->createQueryBuilder('temperature')
            ->select('AVG(temperature.temperatureCelsius) as averageTemp')
            ->andWhere('temperature.createdAt >= :rangeFrom')
            ->setParameter('rangeFrom', $rangeFrom)
            ->andWhere('temperature.createdAt <= :rangeTill')
            ->setParameter('rangeTill', $rangeTill)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
//    /**
//     * @return Temperature[] Returns an array of Temperature objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Temperature
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
