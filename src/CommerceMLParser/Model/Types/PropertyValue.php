<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17.12.15
 * Time: 14:50
 */

namespace CommerceMLParser\Model\Types;


use CommerceMLParser\Model\Interfaces\IdModel;

final class PropertyValue extends AbstractValue implements IdModel
{
    /** @var string  */
    protected $id;

    /**
     * PropertyValue constructor.
     * @param \SimpleXMLElement $xml
     */
    public function __construct(\SimpleXMLElement $xml)
    {
        parent::__construct($xml);
        $this->id = (string)$xml->Ид;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
