<?php

namespace CommerceMLParser\Model;

use CommerceMLParser\ORM\Collection;
use CommerceMLParser\ORM\Model;

/**
 * Class Category
 * @package CommerceMLParser\Model
 */
class Category extends Model
{
    /**
     * @var string $id
     */
    public $id;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $parent
     */
    public $parent;

    /**
     * Create instance from file.
     *
     * @param null $importXml
     * @return Category
     */
    public function __construct($importXml = null)
    {
        if (! is_null($importXml)) {
            $this->loadImport($importXml);
        }
    }

    /**
     * Load category data from import.xml.
     *
     * @param \SimpleXMLElement $xml
     * @return void
     */
    public function loadImport($xml)
    {
        $this->id = (string) $xml->Ид;

        $this->name = (string) $xml->Наименование;
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
