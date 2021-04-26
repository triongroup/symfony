<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="manufacturer_id", columns={"manufacturer_id"}), @ORM\Index(name="price", columns={"price"}), @ORM\Index(name="region_id", columns={"region_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name = '';

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $price = 0.00;

    /**
     * @var string
     *
     * @ORM\Column(name="base_price", type="string", length=50, nullable=false)
     */
    private $basePrice = '';

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     * })
     */
    private $region;

    /**
     * @var Manufacturer
     *
     * @ORM\ManyToOne(targetEntity="Manufacturer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="manufacturer_id", referencedColumnName="id")
     * })
     */
    private $manufacturer;

    /**
     * @var ProductProperties
     *
     * @ORM\OneToMany(targetEntity="ProductProperties", mappedBy="product")
     * })
     */
    private $properties;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
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
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasePrice(): string
    {
        return $this->basePrice;
    }

    /**
     * @param string $basePrice
     * @return Product
     */
    public function setBasePrice(string $basePrice): Product
    {
        $this->basePrice = $basePrice;
        return $this;
    }

    /**
     * @return Region|null
     */
    public function getRegion(): ?Region
    {
        return $this->region;
    }

    /**
     * @param Region $region
     * @return Product
     */
    public function setRegion(Region $region): Product
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return Manufacturer|null
     */
    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    /**
     * @param Manufacturer $manufacturer
     * @return Product
     */
    public function setManufacturer(Manufacturer $manufacturer): Product
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @return ProductProperties
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param ProductProperties $properties
     * @return Product
     */
    public function setProperties(ProductProperties $properties): Product
    {
        $this->properties = $properties;
        return $this;
    }

}
