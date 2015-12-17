<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17.12.15
 * Time: 12:47
 */

namespace CommerceMLParser\Model\Types;


use CommerceMLParser\Model\Types\AddressType;

class Address
{
    /** @var  string */
    protected $name;
    /** @var  string */
    protected $comment;
    /** @var  Address */
    protected $address;

    /**
     * Address constructor.
     *
     * @param \SimpleXMLElement $xml
     */
    public function __construct(\SimpleXMLElement $xml = null)
    {
        if (null === $xml) return;

        $this->comment = (string)$xml->Представление;
        if ($xml->АдресноеПоле) {
            $this->address = new AddressType($xml->АдресноеПоле);
        }
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
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}