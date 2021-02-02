<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findEmprunts()
    {
        return $this->createQueryBuilder('c')
            ->where('c.emprunt > 0')
            ->orderBy('c.emprunt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findMonnaies()
    {
        return $this->createQueryBuilder('c')
            ->where('c.monnaie > 0')
            ->orderBy('c.monnaie', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findClientsByPrenomOrNom($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.nom = :val')
            ->setParameter('val', $value)
            ->orWhere('c.prenom = :val')
            ->setParameter('val', $value)
            ->orderBy('c.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Client[] Returns an array of Client objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
