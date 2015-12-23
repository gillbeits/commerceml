<?php

namespace CommerceMLParser\Model;

use CommerceMLParser\Model\Interfaces\IdModel;
use CommerceMLParser\ORM\Model;

class PriceType extends Model implements IdModel
{
    /** @var string */
    protected $id;
    /** @var string */
    protected $type;
    /** @var string */
    protected $currency;

    /**
     * @param \SimpleXMLElement $xml
     * @return PriceType
     */
    public function __construct(\SimpleXMLElement $xml = null)
    {
        parent::__construct($xml);
        if (!is_null($xml)) {
            $this->id = (string) $xml->Ид;
            $this->type = (string) $xml->Наименование;
            $this->currency = (string) $xml->Валюта;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }


}
