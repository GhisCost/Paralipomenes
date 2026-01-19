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

   


   public function creerChapitre(Histoires $histoire)
   {
    $chapitre= new Chapitres();
    $chapitre->setContenu('');
    $chapitre->setHistoires($histoire);
    $em=$this->getEntityManager();
    $em->persist($chapitre);
    $em->flush();

    return $chapitre;
   }

   public function findChapitrePrecedent(Chapitres $chapitre): ?Chapitres
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.histoires = :histoire')
        ->andWhere('c.id < :id')
        ->setParameter('histoire', $chapitre->getHistoires())
        ->setParameter('id', $chapitre->getId())
        ->orderBy('c.id', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
}


public function findChapitreSuivant(Chapitres $chapitre): ?Chapitres
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.histoires = :histoire')
        ->andWhere('c.id > :id')
        ->setParameter('histoire', $chapitre->getHistoires())
        ->setParameter('id', $chapitre->getId())
        ->orderBy('c.id', 'ASC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
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
