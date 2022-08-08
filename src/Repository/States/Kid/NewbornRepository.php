<?php

namespace App\Repository\States\Kid;

use App\Entity\States\Kid\Newborn;
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
}
