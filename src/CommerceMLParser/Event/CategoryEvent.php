<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 20/04/15
 * Time: 13:26
 */

namespace CommerceMLParser\Event;


use CommerceMLParser\Event;
use CommerceMLParser\Model\Category;
use CommerceMLParser\Model\CategoryCollection;
use CommerceMLParser\ORM\Collection;

class CategoryEvent extends Event {

    /** @var CategoryCollection|Category[]  */
    protected $categories;

    function __construct(CategoryCollection $categories)
    {
        $this->categories = $categories;
        call_user_func_array('parent::__construct', func_get_args());
    }

    /**
     * @return CategoryCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return CategoryCollection|Category[]
     */
    public function getFlatCategories()
    {
        $collectionClass = get_class($this->categories);
        /** @var Collection $collection */
        $collection = new $collectionClass;
        $recursiveIterator = function (CategoryCollection $categories) use ($collection, &$recursiveIterator) {
            /** @var Category $category */
            foreach ($categories as $category) {
                $collection->add($category);
                $recursiveIterator($category->getChilds());
            }
        };
        $recursiveIterator($this->categories);
        return $collection;
    }
}