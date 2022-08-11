<?php

namespace App\Repository;

use App\Entity\Kid;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Kid>
 *
 * @method Kid|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kid|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kid[]    findAll()
 * @method Kid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kid::class);
    }

    public function add(Kid $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Kid $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param DateTime $date Date to become infant
     *
     * @return Kid[] Returns an array of Kids objects
     */
    public function findByDateOfBecameInfant(DateTime $date): array
    {
        $infantQb = $this->createQueryBuilder('i')
            ->select('i.id')
            ->leftJoin('i.state', 's')
            ->andWhere('s INSTANCE OF :infant_class')
            ->setParameter('infant_class', $this->getEntityManager()->getClassMetadata(
                'App\Entity\States\Kid\Infant'
            ))
        ;

        $kidQb = $this->createQueryBuilder('k');

        $kidQb
            ->andWhere('k.dateOfBirth < :date')
            ->andWhere($kidQb->expr()->notIn('k.id', ':infants'))
            ->setParameter('date', $date)
//            TODO Refactoring
            ->setParameter('infants', $infantQb->getQuery()->getArrayResult())
        ;

        return $kidQb->getQuery()->getResult();
    }
}
