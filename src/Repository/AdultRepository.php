<?php

namespace App\Repository;

use App\Entity\Adult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adult>
 *
 * @method Adult|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adult|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adult[]    findAll()
 * @method Adult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adult::class);
    }

    public function add(Adult $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Adult $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllWithKids(): Collection
    {
        $adults = $this
            ->createQueryBuilder('a')
            ->innerJoin('a.kid', 'k')
            ->getQuery()
            ->getResult();

        return new ArrayCollection($adults);
    }
}
