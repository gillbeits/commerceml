<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17.12.15
 * Time: 14:52
 */

namespace CommerceMLParser\Model\Types;


abstract class AbstractValue
{
    /** @var  string */
    protected $name;
    /** @var  string */
    protected $value;

    public function __construct(\SimpleXMLElement $xml)
    {
        $this->name = (string)$xml->Наименование;
        $this->value = (string)$xml->Значение;
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
    public function getValue()
    {
        return $this->value;
    }
}