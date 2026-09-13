<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param string[] $identifiers
     * 
     * @return Product[]
     */
    public function getProducts(array $identifiers): array
    {
        $uuids = \array_map(
            fn(string $id) => Uuid::fromString($id)->toBinary(),
            $identifiers
        );

        return $this->createQueryBuilder('p')
            ->andWhere('p.id IN (:ids)')
            ->setParameter('ids', $uuids, ArrayParameterType::STRING)
            ->getQuery()
            ->getResult();
    }
}
