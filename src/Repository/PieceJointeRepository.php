<?php

namespace App\Repository;

use App\Entity\Corrections;
use App\Entity\Messages;
use App\Entity\PieceJointe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PieceJointe>
 */
class PieceJointeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PieceJointe::class);
    } 

    public function creerPieceJointe(Messages $message, Corrections $correction)
    {
        $pieceJointe= new PieceJointe();
        $pieceJointe->setMessage($message);
        $pieceJointe->setCorrection($correction);
        $em=$this->getEntityManager();
        $em->persist($pieceJointe);
        $em->flush();

    }

    public function findPieceJointeByMessage(Messages $message){

        return $this->createQueryBuilder('p')
            ->andWhere('p.message = :mess')
            ->setParameter('mess', $message)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}



//    /**
//     * @return PieceJointe[] Returns an array of PieceJointe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PieceJointe
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }