<?php

namespace App\Repository;

use App\Entity\AbstractKid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AbstractKid>
 *
 * @method AbstractKid|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractKid|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractKid[]    findAll()
 * @method AbstractKid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractKid::class);
    }

    public function add(AbstractKid $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AbstractKid $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
