<?php

namespace CommerceMLParser\Model;


use CommerceMLParser\Model\Interfaces\IdModel;
use CommerceMLParser\ORM\Model;

class Property extends Model implements IdModel
{
    /** @var string */
    protected $id;
    /** @var string */
    protected $name;
    /** @var array */
    protected $values = array();
    /** @var string */
    protected $description;
    /** @var bool */
    protected $isRequired;
    /** @var bool */
    protected $isList;
    /** @var string */
    protected $type;
    /** @var bool ; */
    protected $isUsed;

    /**
     * Property constructor.
     * @param \SimpleXMLElement|null $xml
     */
    public function __construct(\SimpleXMLElement $xml = null)
    {
        parent::__construct($xml);
        if (null === $xml) return;

        $this->id = (string)$xml->Ид;
        $this->name = (string)$xml->Наименование;
        $valueType = (string)$xml->ТипЗначений;
        if ($valueType == 'Справочник' && $xml->ВариантыЗначений) {
            foreach ($xml->ВариантыЗначений->Справочник as $value) {
                $id = (string)$value->ИдЗначения;
                $this->values[$id] = (string)$value->Значение;
            }
        }
        $this->description = (string)$xml->Описание;
        $this->isRequired = (string)$xml->Обязательное === 'true';
        $this->isList = (string)$xml->Множественное === 'true';
        $this->type = (string)$xml->ТипЗначений;
        $this->isUsed = (string)$xml->ИспользованиеСвойства === 'true';
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return boolean
     */
    public function isIsRequired()
    {
        return $this->isRequired;
    }

    /**
     * @return boolean
     */
    public function isIsList()
    {
        return $this->isList;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return boolean
     */
    public function isIsUsed()
    {
        return $this->isUsed;
    }
}
