<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductProperties
 *
 * @ORM\Table(name="product_properties", uniqueConstraints={@ORM\UniqueConstraint(name="product__property", columns={"product_id", "property_id"})}, indexes={@ORM\Index(name="FK_product_properties_properties", columns={"property_id"}), @ORM\Index(name="IDX_14A46EEC4584665A", columns={"product_id"})})
 * @ORM\Entity
 */
class ProductProperties
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
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var Properties
     *
     * @ORM\ManyToOne(targetEntity="Properties")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     * })
     */
    private $property;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Product
     */
    public function getProduct():Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return ProductProperties
     */
    public function setProduct(Product $product): ProductProperties
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return Properties
     */
    public function getProperty(): Properties
    {
        return $this->property;
    }

    /**
     * @param Properties $property
     * @return ProductProperties
     */
    public function setProperty(Properties $property): ProductProperties
    {
        $this->property = $property;
        return $this;
    }


}
