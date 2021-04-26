<?php


namespace App\Filters;


use Doctrine\ORM\QueryBuilder;

abstract class QueryFilter
{
    /**
     * @var QueryBuilder
     */
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
}
