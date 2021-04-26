<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductProperties;
use App\Filters\FilterBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    protected $query;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function initProducts()
    {
        $this->query = $this->createQueryBuilder('p')
            ->leftJoin('p.manufacturer', 'm')
            ->leftJoin('p.region', 'r')
            ->leftJoin('p.properties', 'pp')
            ->leftJoin('pp.property', 'pr');

        return $this;
    }

    public function applyFilters($filters)
    {
        $filter = new FilterBuilder($this->query, $filters);

        return $filter->apply();
    }

}
