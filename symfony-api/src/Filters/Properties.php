<?php


namespace App\Filters;


use Doctrine\DBAL\Types\Types;

class Properties extends QueryFilter implements FilterContract
{

    public function handle($value): void
    {
        $str = [];
        foreach (explode(',', $value) as $k => $item) {
            $str[] = 'pr.name = :pr' . $k;
            $this->query->setParameter(':pr'.$k, $item, Types::STRING);
        }
        $str = implode(' OR ', $str);

        $this->query->andWhere('('.$str.')');
    }
}
