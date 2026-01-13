<?php

namespace App\Repository;

use App\Entity\Histoires;
use App\Entity\User;
use App\Enum\StatutHistoire;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Histoires>
 */
class HistoiresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Histoires::class);
    }


    
        public function troisDernièresHistoires(int $limit = 3): array
    {   
        return $this->createQueryBuilder('h')
            ->leftJoin('h.chapitres', "c")
            ->addSelect('c')
            ->andWhere('h.statut= :statut')
            ->setParameter('statut',"En cours de redaction") // à changer "en cours de redaction doit être changer pour "Publié"
            ->orderBy('h.datePublication', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

     public function trouverHistoires(): array
    {   
        return $this->createQueryBuilder('h')
            ->leftJoin('h.chapitres', "c")
            ->addSelect('c')
            ->andWhere('h.statut= :statut')
            ->setParameter('statut',"En cours de redaction") // à changer "en cours de redaction doit être changer pour "Publié"
            ->orderBy('h.datePublication', 'DESC')
            ->getQuery()
            ->getResult();
    }


    public function creerHistoire(string $titre, User $user)
    {
       $histoire = new Histoires();
      
       $histoire->setTitre($titre);
       $histoire->setStatut(StatutHistoire::ENCOURS);
       $histoire->setUser($user);
       $em=$this->getEntityManager();
       $em->persist($histoire);
       $em->flush();

    return $histoire;
    }

    public function findHistoireById($id)
    {

        return $this->createQueryBuilder('h')
            ->andWhere('h.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult()
            ;
    }

    
//    /**
//     * @return Histoires[] Returns an array of Histoires objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Histoires
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
