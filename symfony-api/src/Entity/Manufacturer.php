<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Manufacturer
 *
 * @ORM\Table(name="manufacturer")
 * @ORM\Entity
 */
class Manufacturer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150, nullable=false)
     */
    private $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Manufacturer
     */
    public function setName(string $name): Manufacturer
    {
        $this->name = $name;
        return $this;
    }

}
