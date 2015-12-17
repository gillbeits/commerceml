<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17.12.15
 * Time: 13:16
 */

namespace CommerceMLParser\Model\Types;


class BaseUnit
{
    /** @var string  */
    protected $value;
    /** @var string  */
    protected $code;
    /** @var string  */
    protected $nameFull;
    /** @var string  */
    protected $nameShort;
    /** @var string  */
    protected $nameInterShort;

    public function __construct(\SimpleXMLElement $xml) {
        $this->value = (string)$xml;
        $this->code = (string)$xml['Код'];
        $this->nameFull = (string)$xml['НаименованиеПолное'];
        $this->nameShort = (string)$xml['НаименованиеКраткое'];
        $this->nameInterShort = (string)$xml['МеждународноеСокращение'];
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getNameFull()
    {
        return $this->nameFull;
    }

    /**
     * @return string
     */
    public function getNameShort()
    {
        return $this->nameShort;
    }

    /**
     * @return string
     */
    public function getNameInterShort()
    {
        return $this->nameInterShort;
    }

    function __toString()
    {
        return $this->value;
    }
}