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
           ->orderBy('c.numeroChapitre','DESC')
           ->setMaxResults(1)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }

   public function findChapitresByHistoire(Histoires $histoire): array
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.histoires = :histoires')
        ->setParameter('histoires', $histoire)
        ->orderBy('c.numeroChapitre', 'ASC')
        ->getQuery()
        ->getResult();
}
   public function creerChapitre(Histoires $histoire, int $chapPrec)
   {
    $chapitre= new Chapitres();
    $chapitre->setContenu('');
    $chapitre->setHistoires($histoire);
    $chapitre->setNumeroChapitre($chapPrec + 1);
    $em=$this->getEntityManager();
    $em->persist($chapitre);
    $em->flush();

    return $chapitre;
   }

   public function findChapitrePrecedent(Chapitres $chapitre): ?Chapitres
    {
    return $this->createQueryBuilder('c')
        ->andWhere('c.histoires = :histoire')
        ->andWhere('c.numeroChapitre < :numeroChapitre')
        ->setParameter('histoire', $chapitre->getHistoires())
        ->setParameter('numeroChapitre', $chapitre->getNumeroChapitre())
        ->orderBy('c.numeroChapitre', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
}

public function findChapitreSuivant(Chapitres $chapitre): ?Chapitres
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.histoires = :histoire')
        ->andWhere('c.numeroChapitre > :numeroChapitre')
        ->setParameter('histoire', $chapitre->getHistoires())
        ->setParameter('numeroChapitre', $chapitre->getNumeroChapitre())
        ->orderBy('c.numeroChapitre', 'ASC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
}

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