<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 20/04/15
 * Time: 14:14
 */

namespace CommerceMLParser\Event;


use CommerceMLParser\Event;
use CommerceMLParser\Model\PriceType;

class PriceTypeEvent extends Event {

    protected $priceType;

    function __construct(PriceType $priceType)
    {
        $this->priceType = $priceType;
        call_user_func_array('parent::__construct', func_get_args());
    }

    /**
     * @return PriceType
     */
    public function getPriceType()
    {
        return $this->priceType;
    }

}