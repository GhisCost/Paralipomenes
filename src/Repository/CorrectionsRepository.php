<?php

namespace App\Repository;

use App\Entity\Corrections;
use App\Enum\StatutCorrection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\Chapitres;
use App\Entity\Histoires;


/**
 * @extends ServiceEntityRepository<Corrections>
 */
class CorrectionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Corrections::class);
    }

    
    public function creerCorrection(User $user, Chapitres $chapitre, Histoires $histoire)
    {
       $correction = new Corrections();
      
       $correction->setStatut(StatutCorrection::ENCOURS);
       $correction->setUser($user);
       $correction->setChapitres($chapitre);
       $correction->setContenu($chapitre->getContenu());
       $correction->setHistoire($histoire);
       
       $em=$this->getEntityManager();
       $em->persist($correction);
       $em->flush();

    return $correction;
    }

    public function findCorrectionByHistoire($id_histoire): array
   {
       return $this->createQueryBuilder('c')
           ->andWhere('c.Histoire= :id_histoire')
           ->setParameter('id_histoire', $id_histoire)
           ->orderBy('c.id', 'ASC')
           ->setMaxResults(1)
           ->getQuery()
           ->getResult()
       ;
   }


   public function findCorrectionSuivante(int $id, Histoires $histoire): ?Corrections
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.histoire = :histoire')
        ->andWhere('c.id > :id')
        ->setParameter('histoire', $histoire)
        ->setParameter('id', $id)
        ->orderBy('c.id', 'ASC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
}

public function findCorrectionPrecedente(int $id, Histoires $histoire): ?Corrections
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.histoire = :histoire')
        ->andWhere('c.id < :id')
        ->setParameter('histoire', $histoire)
        ->setParameter('id', $id)
        ->orderBy('c.id', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
}

}




//    /**
//     * @return Corrections[] Returns an array of Corrections objects
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

//    public function findOneBySomeField($value): ?Corrections
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

