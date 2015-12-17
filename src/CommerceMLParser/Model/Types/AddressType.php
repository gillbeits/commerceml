<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17.12.15
 * Time: 12:51
 */

namespace CommerceMLParser\Model\Types;

/**
 * Class AddressType
 * @package CommerceMLParser\Model\Types
 *
 * @todo Сделать парсер адреса
 */
class AddressType
{
    /** @var  string */
    protected $postalCode;
    /** @var  string */
    protected $country;
    /** @var  string */
    protected $region;
    /** @var  string */
    protected $area;
    /** @var  string */
    protected $city;
    /** @var  string */
    protected $street;
    /** @var  string */
    protected $build;
    /** @var  string */
    protected $housing;
    /** @var  string */
    protected $flat;

    /**
     * AddressType constructor.
     * @param \SimpleXMLElement $xml
     */
    public function __construct(\SimpleXMLElement $xml)
    {
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * @return string
     */
    public function getHousing()
    {
        return $this->housing;
    }

    /**
     * @return string
     */
    public function getFlat()
    {
        return $this->flat;
    }
}