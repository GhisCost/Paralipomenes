<?php

namespace App\Repository;

use App\Entity\Chapitres;
use App\Entity\Histoires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chapitres>
 */
class ChapitresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chapitres::class);
    }



   public function findLastChapitreByHistoire(Histoires $histoire): ?Chapitres
   {
       return $this->createQueryBuilder('c')
           ->andWhere('c.histoires = :histoires')
           ->setParameter('histoires', $histoire)
           ->orderBy('c.id','DESC')
           ->setMaxResults(1)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
   //    /**
//     * @return Chapitres[] Returns an array of Chapitres objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
}
