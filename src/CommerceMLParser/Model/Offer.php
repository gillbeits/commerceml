<?php

namespace CommerceMLParser\Model;

use CommerceMLParser\ORM\Model;


class Offer extends Model
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
     * @var string $code
     */
    public $code;

    /**
     * @var string $barcode
     */
    public $barcode;

    /**
     * @var array $baseUnit
     */
    public $baseUnit = array();

    /**
     * @var int $quantity
     */
    public $quantity;

    /**
     * @var array $price
     */
    public $price = array();

    /**
     * Class constructor.
     *
     * @param string [$offersXml]
     */
    public function __construct($offersXml = null)
    {
        $product = new Product($offersXml, $offersXml);

        $this->id = $product->id;
        $this->name = $product->name;
        $this->code = $product->code;
        $this->barcode = $product->barcode;
        $this->baseUnit = $product->baseUnit;
        $this->quantity = $product->quantity;
        $this->price = $product->price;
    }
}
