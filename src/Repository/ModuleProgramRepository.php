<?php

namespace App\Repository;

use App\Entity\ModuleProgram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ModuleProgram>
 */
class ModuleProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModuleProgram::class);
    }

    public function findUsersNotIn($moduleId){
        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        $queryBuilder = $sub;

        $queryBuilder->select('s')
            ->from('App\Entity\User','s')
            ->leftJoin('s.modulePrograms','se')
            ->where('se.id = :id');
        
        $sub = $em->createQueryBuilder();

        $sub->select('st')
            ->from('App\Entity\User','st')
            ->where($sub->expr()->notIn('st.id', $queryBuilder->getDQL()))
            ->setParameter('id',$moduleId)
            ->orderBy('st.name')
        ;

        $query = $sub->getQuery();
        return $query->getResult();
    }

    //    /**
    //     * @return ModuleProgram[] Returns an array of ModuleProgram objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ModuleProgram
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
