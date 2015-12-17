<?php

namespace CommerceMLParser\Model;

use CommerceMLParser\Model\Interfaces\IdModel;
use CommerceMLParser\ORM\Collection;
use CommerceMLParser\ORM\Model;

/**
 * Class Category
 * @package CommerceMLParser\Model
 */
class Category extends Model implements IdModel
{
    /** @var string $id */
    protected $id;
    /** @var string $name */
    protected $name;
    /** @var string $parent */
    protected $parent;

    /**
     * Create instance from file.
     *
     * @param \SimpleXMLElement $xml
     */
    public function __construct(\SimpleXMLElement $xml = null)
    {
        if (null === $xml) return;
        $this->id = (string) $xml->Ид;
        $this->name = (string) $xml->Наименование;
    }


    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children category.
     *
     * @param Category $category
     * @return void
     */
    public function addChild($category)
    {
        $category->parent = $this->id;
    }

    /**
     * Add products to category.
     * 
     * @param Collection $products
     * @return void
     */
    public function attachProducts($products)
    {
        $this->products = array();
        foreach ($products->fetch() as $product) {
            if (array_key_exists($this->id, $product->categories)) {
                $this->products[$product->id] = $product;
            }
        }
    }
}
