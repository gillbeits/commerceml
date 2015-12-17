<?php

namespace CommerceMLParser\Model;


class Offer extends Product
{
    /** @var int $quantity */
    protected $quantity;
    protected $prices;
    protected $stock;

    public function __construct(\SimpleXMLElement $xml)
    {
        parent::__construct($xml);
    }
}
