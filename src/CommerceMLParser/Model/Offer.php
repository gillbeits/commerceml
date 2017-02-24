<?php

namespace CommerceMLParser\Model;


class Offer extends Product
{
    /** @var float $quantity */
    protected $quantity;
    protected $prices;
    protected $stock;

    public function __construct(\SimpleXMLElement $xml)
    {
        parent::__construct($xml);

        if ($xml->Количество) {
            $this->quantity = floatval($xml->Количество);
        }
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
