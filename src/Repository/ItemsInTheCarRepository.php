<?php

namespace App\Repository;

use App\Entity\ItemsInTheCar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItemsInTheCar>
 *
 * @method ItemsInTheCar|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemsInTheCar|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemsInTheCar[]    findAll()
 * @method ItemsInTheCar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemsInTheCarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemsInTheCar::class);
    }

    public function save(ItemsInTheCar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ItemsInTheCar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ItemsInTheCar[] Returns an array of ItemsInTheCar objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ItemsInTheCar
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
