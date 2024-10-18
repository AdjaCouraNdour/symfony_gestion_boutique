<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    //    /**
    //     * @return Client[] Returns an array of Client objects
    //     */
    //    public function paginateClient(int $page ,int $limit ,String $telephone): Paginator
    //    {
    //        $query = $this->createQueryBuilder('c')
    //            ->setFirstResult(( $page - 1 ) * $limit)
    //            ->setMaxResults($limit)
    //            ->orderBy('c.id', 'ASC')
    //            ->getQuery();
    //         return new Paginator($query);
    //    }

public function paginateClient(int $page, int $limit, string $telephone = null): Paginator
{
    $queryBuilder = $this->createQueryBuilder('c')
        ->setFirstResult(($page - 1) * $limit)
        ->setMaxResults($limit) 
        ->orderBy('c.id', 'ASC'); 
    if ($telephone) {
        $queryBuilder->andWhere('c.telephone LIKE :telephone')
                     ->setParameter('telephone', '%' . $telephone . '%'); 
    }
    $query = $queryBuilder->getQuery();
    return new Paginator($query);
}


    //    public function findOneBySomeField($value): ?Client
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
