<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    /**
     * Cette fonction est utilisée pour filtrer les voitures selon les critères
     */
    public function filterCars(array $filters): QueryBuilder
    {
        $qb = $this->createQueryBuilder('c');

        if (isset($filters['brand'])) {
            $qb->andWhere('c.brand = :brand')
                ->setParameter('brand', $filters['brand']);
        }

        if (isset($filters['engineType'])) {
            $qb->andWhere('c.engineType = :engineType')
                ->setParameter('engineType', $filters['engineType']);
        }

        if (isset($filters['year'])) {
            $qb->andWhere('c.year = :year')
                ->setParameter('year', $filters['year']);
        }

        if (isset($filters['mileage'])) {
            $qb->andWhere('c.mileage <= :mileage')
                ->setParameter('mileage', $filters['mileage']);
        }

        if (isset($filters['price'])) {
            $qb->andWhere('c.price <= :price')
                ->setParameter('price', $filters['price']);
        }

        return $qb;
    }
}
