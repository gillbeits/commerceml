<?php

namespace CommerceMLParser\Model;

use CommerceMLParser\Model\Interfaces\HasChild;
use CommerceMLParser\Model\Interfaces\IdModel;
use CommerceMLParser\ORM\Collection;
use CommerceMLParser\ORM\Model;

/**
 * Class Category
 * @package CommerceMLParser\Model
 */
class Category extends Model implements IdModel, HasChild
{
    /** @var string $id */
    protected $id;
    /** @var string $name */
    protected $name;
    /** @var string $parent */
    protected $parent;
    /** @var CategoryCollection|Category[]  */
    protected $categories;
    /** @var  PropertyCollection|Property[] */
    protected $properties;

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
        $this->categories = new CategoryCollection();
        $this->properties = new PropertyCollection();
        if ($xml->Свойства) {
            foreach ($xml->Свойства as $property) {
                $this->properties->add(new Property($property));
            }
        }
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
        $this->categories->add($category);
    }

    /**
     * @return Category[]|CategoryCollection
     */
    public function getChilds()
    {
        return $this->categories;
    }

    /**
     * @return Property[]|PropertyCollection
     */
    public function getProperties()
    {
        return $this->properties;
    }

}
