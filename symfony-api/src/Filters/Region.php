<?php


namespace App\Filters;


use Doctrine\DBAL\Types\Types;

class Region extends QueryFilter implements FilterContract
{

    public function handle($value): void
    {
        $str = [];
        foreach (explode(',', $value) as $k => $item) {
            $str[] = 'r.name = :reg' . $k;
            $this->query->setParameter(':reg' . $k, $item, Types::STRING);
        }
        $str = implode(' OR ', $str);
        $this->query->andWhere('(' . $str . ')');
    }
}
