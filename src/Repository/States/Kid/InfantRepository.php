<?php

namespace App\Repository\States\Kid;

use App\Entity\States\Kid\Infant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Infant>
 *
 * @method Infant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Infant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Infant[]    findAll()
 * @method Infant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Infant::class);
    }

    public function add(Infant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Infant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
