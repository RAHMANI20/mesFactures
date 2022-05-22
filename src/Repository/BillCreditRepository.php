<?php

namespace App\Repository;

use App\Entity\BillCredit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BillCredit|null find($id, $lockMode = null, $lockVersion = null)
 * @method BillCredit|null findOneBy(array $criteria, array $orderBy = null)
 * @method BillCredit[]    findAll()
 * @method BillCredit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillCreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BillCredit::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BillCredit $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(BillCredit $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findMaxNumerotation(){
        $qb = $this->createQueryBuilder('d');
        $qb->select('max(d.numerotation)');
        $qb->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    // /**
    //  * @return BillCredit[] Returns an array of BillCredit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BillCredit
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
