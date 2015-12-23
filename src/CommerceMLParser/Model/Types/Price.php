<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 23.12.15
 * Time: 12:26
 */

namespace CommerceMLParser\Model\Types;


use CommerceMLParser\Model\Interfaces\IdModel;
use CommerceMLParser\ORM\Model;

class Price extends Model implements IdModel
{
    /** @var  string ИдТипаЦены */
    protected $id;
    /** @var string Представление */
    protected $showing;
    /** @var  float ЦенаЗаЕдиницу */
    protected $price;
    /** @var  string Валюта */
    protected $currency;

    /**
     * @inheritDoc
     */
    public function __construct(\SimpleXMLElement $xml)
    {
        parent::__construct($xml);
        $this->id = (string)$xml->ИдТипаЦены;
        $this->showing = (string)$xml->Представление;
        $this->price = (string)$xml->ЦенаЗаЕдиницу;
        $this->currency = (string)$xml->Валюта;
    }

    /**
     * @return string
     */
    public function getShowing()
    {
        return $this->showing;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * ИдТипаЦены
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
