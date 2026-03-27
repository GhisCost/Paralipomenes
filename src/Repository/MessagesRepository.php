<?php

namespace App\Repository;

use App\Entity\Messages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Messages>
 */
class MessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Messages::class);
    }

//    /**
//     * @return Messages[] Returns an array of Messages objects
//     */
   public function findMessageRecus($id): array
   {
       return $this->createQueryBuilder('m')
           ->andWhere('m.destinataire = :dest')
           ->setParameter('dest', $id)
           ->orderBy('m.dateEnvoi', 'DESC')
           ->getQuery()
           ->getResult()
       ;
   }

     public function findMessageEnvoyer($id): array
   {
       return $this->createQueryBuilder('m')
           ->andWhere('m.expediteur = :exp')
           ->setParameter('exp', $id)
           ->orderBy('m.dateEnvoi', 'DESC')
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Messages
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
