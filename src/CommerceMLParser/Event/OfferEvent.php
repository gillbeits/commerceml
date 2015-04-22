<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 20/04/15
 * Time: 14:14
 */

namespace CommerceMLParser\Event;


use CommerceMLParser\Event;
use CommerceMLParser\Model\Offer;

class OfferEvent extends Event {
    protected $offer;

    function __construct(Offer $offer)
    {
        $this->offer = $offer;
        call_user_func_array('parent::__construct', func_get_args());
    }

    /**
     * @return Offer
     */
    public function getOffer()
    {
        return $this->offer;
    }


}