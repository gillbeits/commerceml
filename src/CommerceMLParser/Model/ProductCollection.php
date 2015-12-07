<?php

namespace CommerceMLParser\Model;

use CommerceMLParser\ORM\Collection;

class ProductCollection extends Collection
{
    /**
     * Translate price types id to string.
     *
     * @param PriceTypeCollection $priceTypeCollection
     * @return void
     */
    public function attachPriceTypeCollection($priceTypeCollection)
    {
        foreach ($this->fetch() as $product) {
            foreach ($product->price as $id => &$price) {
                $type = $priceTypeCollection->getType($id);
                if ($type) $price['type'] = $type;
            }
        }
    }

    /**
     * Translate properties id to string.
     *
     * @param PropertyCollection $propertyCollection
     * @return void
     */
    public function attachPropertyCollection($propertyCollection)
    {
        foreach ($this->fetch() as $product) {
            foreach($product->properties as $propId => &$value) {
                $value['value'] = $propertyCollection->getValue($propId, $value['valueId']);
                $value['name'] = $propertyCollection->getName($propId);
            }
        }
    }

}
