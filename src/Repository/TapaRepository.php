<?php

namespace App\Repository;

use App\Entity\Tapa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tapa>
 *
 * @method Tapa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tapa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tapa[]    findAll()
 * @method Tapa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TapaRepository extends ServiceEntityRepository
{

    public function pageTapas($numTapas=3, $pagina=1){
        
        $tapas = $this->createQueryBuilder('t')
        ->where('t.top = 1')
        ->setFirstResult($numTapas*($pagina-1))
        ->setMaxResults($numTapas)
        ->getQuery();
        return $tapas->getResult();
    }
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tapa::class);
    }

    public function add(Tapa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tapa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Tapa[] Returns an array of Tapa objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tapa
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
