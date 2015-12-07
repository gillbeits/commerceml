<?php

namespace CommerceMLParser\Model;

use CommerceMLParser\ORM\Collection;

/**
 * Class CategoryCollection
 * @package CommerceMLParser\Model
 *
 * @method Category[] fetch()
 */
class CategoryCollection extends Collection
{
    /**
     * Attach products to categories.
     *
     * @param ProductCollection $productCollection
     * @return void
     */
    public function attachProductCollection($productCollection)
    {
        foreach ($this->fetch() as $category) {
            $category->attachProducts($productCollection);
        }
    }
}
