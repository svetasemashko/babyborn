<?php

namespace App\Repository;

use App\Entity\Kid;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
        return $this->createQueryBuilder('k')
            ->leftJoin('k.state', 's')
            ->andWhere('k.dateOfBirth < :date')
            ->andWhere('s INSTANCE OF :newborns')
            ->setParameter('date', $date)
            ->setParameter('newborns', $this->getEntityManager()->getClassMetadata(
                'App\Entity\States\Kid\Newborn'
            ))
            ->getQuery()
            ->getResult();
    }

    public function findAllByMinAge(): Collection
    {
        $qb = $this->createQueryBuilder('k');

        $subQb = $this->createQueryBuilder('kid');

        $kids = $subQb
            ->having(
                $subQb->expr()->in(
                    'kid.dateOfBirth',
                    $qb->select($qb->expr()->max('k.dateOfBirth'))->getDQL()
                )
            )
            ->getQuery()
            ->getResult();


        return new ArrayCollection($kids);
    }
}
