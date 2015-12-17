<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17.12.15
 * Time: 14:57
 */

namespace CommerceMLParser\Model\Types;


class TaxRate
{
    /** @var string  */
    protected $name;
    /** @var string  */
    protected $rate;

    /**
     * TaxRate constructor.
     * @param \SimpleXMLElement $xml
     */
    public function __construct(\SimpleXMLElement $xml)
    {
        $this->name = (string)$xml->Наименование;
        $this->rate = (string)$xml->Ставка;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }
}
