<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17.12.15
 * Time: 12:47
 */

namespace CommerceMLParser\Model\Types;


use phpDocumentor\Reflection\DocBlock\Type\Collection;

class Address
{
    /** @var  string */
    protected $name;
    /** @var  string */
    protected $comment;
    /** @var  Collection|Address[] */
    protected $addresses;

    /**
     * Address constructor.
     *
     * @param \SimpleXMLElement $xml
     */
    public function __construct(\SimpleXMLElement $xml = null)
    {
        if (null === $xml) return;

        $this->addresses = new Collection();

        $this->name = (string)$xml->Представление;
        $this->comment = (string)$xml->Комментарий;
        if ($xml->АдресноеПоле) {
            foreach ($xml->АдресноеПоле as $address) {
                $this->addresses->add(new AddressType($address));
            }
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
     * @return Collection|Address[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}