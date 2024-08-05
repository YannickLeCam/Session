<?php

namespace App\Repository;

use App\Entity\Intern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Intern>
 */
class InternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intern::class);
    }

    public function findSessionsNotIn($internId){
        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        $queryBuilder = $sub;

        $queryBuilder->select('s')
            ->from('App\Entity\Session','s')
            ->leftJoin('s.interns','se')
            ->where('se.id = :id');
        
        $sub = $em->createQueryBuilder();

        $sub->select('st')
            ->from('App\Entity\Session', 'st')
            ->where($sub->expr()->notIn('st.id', $queryBuilder->getDQL()))
            ->andWhere('st.dateStart >= :today') 
            ->setParameter('id', $internId)
            ->setParameter('today', new \DateTime('today'))
            ->orderBy('st.name');
        ;

        $query = $sub->getQuery();
        return $query->getResult();
    }
    //    /**
    //     * @return Intern[] Returns an array of Intern objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Intern
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
