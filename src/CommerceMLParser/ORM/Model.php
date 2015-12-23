<?php

namespace CommerceMLParser\ORM;


abstract class Model
{
    /** @var \SimpleXMLElement  */
    protected $_xml;

    public function __construct(\SimpleXMLElement $simpleXMLElement = null)
    {
        $this->_xml = $simpleXMLElement;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function getXml()
    {
        return $this->_xml;
    }
}
