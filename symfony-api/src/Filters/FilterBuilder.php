<?php


namespace App\Filters;


use Doctrine\ORM\QueryBuilder;

class FilterBuilder
{
    /**
     * @var QueryBuilder
     */
    protected $query;
    protected $filters;

    public function __construct($query, $filters)
    {
        $this->query = $query;
        $this->filters = $filters;
    }

    public function apply()
    {
        if ($this->filters) {
            foreach ($this->filters as $name => $value) {
                $normailizedName = ucfirst($name);
                $class = "App\\Filters\\{$normailizedName}";

                if (!class_exists($class)) {
                    continue;
                }

                if ($value !== '') {
                    (new $class($this->query))->handle($value);
                } else {
                    (new $class($this->query))->handle();
                }
            }
        }

        return $this->query;
    }

}
