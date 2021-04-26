<?php


namespace App\Filters;


class PriceRange extends QueryFilter implements FilterContract
{

    public function handle($value): void
    {
        foreach (explode(',', $value) as $item) {
            $price = explode('-', $item);
            if (!isset($price[1])) {
                $this->query->orWhere('p.price >= ' . $price[0]);
            } else {
                $this->query->orWhere('p.price BETWEEN ' . $price[0] . ' AND ' . $price[1]);
            }
        }
    }
}
