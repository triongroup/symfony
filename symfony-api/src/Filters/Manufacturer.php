<?php


namespace App\Filters;


use Doctrine\DBAL\Types\Types;

class Manufacturer extends QueryFilter implements FilterContract
{

    public function handle($value): void
    {
        $str = [];
        foreach (explode(',', $value) as $k => $item) {
            $str[] = 'm.name = :man' . $k;
            $this->query->setParameter(':man'.$k, $item, Types::STRING);
        }
        $str = implode(' OR ', $str);

        $this->query->andWhere('('.$str.')');
    }
}
