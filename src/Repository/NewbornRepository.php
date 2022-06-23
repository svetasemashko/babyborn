<?php

namespace App\Repository;

use App\Entity\Newborn;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Newborn>
 *
 * @method Newborn|null find($id, $lockMode = null, $lockVersion = null)
 * @method Newborn|null findOneBy(array $criteria, array $orderBy = null)
 * @method Newborn[]    findAll()
 * @method Newborn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewbornRepository extends ServiceEntityRepository
{
    public const TIME_FROM_BIRTH = '-2 month';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Newborn::class);
    }

    public function add(Newborn $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Newborn $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param DateTime $date Date to become infant
     *
     * @return Newborn[] Returns an array of Newborn objects
     */
    public function findByDateOfBecameInfant(DateTime $date): array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.dateOfBirth < :date')
            ->andWhere('i.newborn IS NULL')
            ->leftJoin('n.infant', 'i')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
    }
}
