<?php

namespace CommerceMLParser\Model\Types;

use CommerceMLParser\ORM\Model;

class Contact extends Model
{
    /** @var string */
    protected $type;
    /** @var string */
    protected $value;
    /** @var string */
    protected $comment;

    /**
     * @param \SimpleXMLElement $xml
     * @return Contact
     */
    public function __construct(\SimpleXMLElement $xml = null)
    {
        parent::__construct($xml);
        if (!is_null($xml)) {
            $this->type = (string) $xml->Тип;
            $this->value = (string) $xml->Значение;
            $this->comment = null;
            if($xml->Комментарий){
                $this->comment = (string) $xml->Комментарий;
            }
        }
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
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

}
