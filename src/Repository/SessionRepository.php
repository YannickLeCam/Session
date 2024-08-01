<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function findInternsNotIn($sessionId){
        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        $queryBuilder = $sub;

        $queryBuilder->select('s')
            ->from('App\Entity\Intern','s')
            ->leftJoin('s.sessions','se')
            ->where('se.id = :id');
        
        $sub = $em->createQueryBuilder();

        $sub->select('st')
            ->from('App\Entity\Intern','st')
            ->where($sub->expr()->notIn('st.id', $queryBuilder->getDQL()))
            ->setParameter('id',$sessionId)
            ->orderBy('st.name')
        ;

        $query = $sub->getQuery();
        return $query->getResult();
    }

    public function findModulesProgramsNotIn($sessionId){

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        $queryBuilder = $sub;

        $queryBuilder->select('s')
            ->from('App\Entity\ModuleProgram','s')
            ->leftJoin('s.programs','se')
            ->where('se.session = :id');
        
        $sub = $em->createQueryBuilder();

        $sub->select('st')
            ->from('App\Entity\ModuleProgram','st')
            ->where($sub->expr()->notIn('st.id', $queryBuilder->getDQL()))
            ->setParameter('id',$sessionId)
        ;

        $query = $sub->getQuery();
        return $query->getResult();
    }

    public function findSessionPassed($userId)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.user = :id')  
            ->andWhere('s.dateEnd < :now')  
            ->setParameter('id', $userId)
            ->setParameter('now', new \DateTime())  
            ->orderBy('s.dateStart', 'ASC')  
            ->getQuery()
            ->getResult();
    }

    public function findSessionInComing($userId)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.user = :id') 
            ->andWhere('s.dateStart > :now') 
            ->setParameter('id', $userId)
            ->setParameter('now', new \DateTime()) 
            ->orderBy('s.dateStart', 'ASC')  
            ->getQuery()
            ->getResult();
    }

    public function findSessionCurrent($userId)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.user = :id')
            ->andWhere('s.dateStart < :now')
            ->andWhere('s.dateEnd > :now')
            ->setParameter('id', $userId)
            ->setParameter('now', new \DateTime())
            ->orderBy('s.dateStart', 'ASC')  
            ->getQuery()
            ->getResult();
    }
    

    //    /**
    //     * @return Session[] Returns an array of Session objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
