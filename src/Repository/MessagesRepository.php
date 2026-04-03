<?php

namespace App\Repository;

use App\Entity\Messages;
use App\Entity\User;
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
            ->andWhere('m.envoyer= :env')
            ->setParameter('env', true)
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
            ->andWhere('m.envoyer= :env')
            ->setParameter('exp', $id)
            ->setParameter('env', true)
            ->orderBy('m.dateEnvoi', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function creerMessage(User $expe, User $desti)
    {
        $message = new Messages();
        $message->setContenu('');
        $message->setDestinataire($desti);
        $message->setExpediteur($expe);
        $message->setEnvoyer(false);
        $em = $this->getEntityManager();
        $em->persist($message);
        $em->flush();

        return $message;

    }


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