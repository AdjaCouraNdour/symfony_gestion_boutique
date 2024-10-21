<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Dto\UserSearchDto;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }
    public function paginateUser(int $page, int $limit): Paginator
    {
        $query = $this->createQueryBuilder('c')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit) 
            ->orderBy('c.id', 'ASC') 
            ->getQuery();
        return new Paginator($query);

        // if ($login) {
        //     $queryBuilder->andWhere('c.login LIKE :login')
        //                 ->setParameter('login', '%' . $login . '%'); 
        // }
        // $query = $queryBuilder->getQuery();
    }

    public function findUserBy(UserSearchDto $userSearchDto ,int $page, int $limit): Paginator
       {
        $query = $this->createQueryBuilder('c');
        if (!empty($userSearchDto->login)) {
            $query->andWhere('c.login = :login')
                  ->setParameter('login', $userSearchDto->login); 
        }
        // if (!empty($userSearchDto->surname)) {
        //     $query->andWhere('c.surname = :surname')
        //           ->setParameter('surname', $userSearchDto->surname); 
        // }

        $query->orderBy('c.id', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit) 
            ->getQuery()
            ->getResult()
           ;
        return new Paginator($query);

       }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
