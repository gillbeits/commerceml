<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 20/04/15
 * Time: 14:14
 */

namespace CommerceMLParser\Event;


use CommerceMLParser\Event;
use Zenwalker\CommerceML\Model\Product;

class ProductEvent extends Event {
    protected $product;

    function __construct(Product $product)
    {
        $this->product = $product;
        call_user_func_array('parent::__construct', func_get_args());
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }


}