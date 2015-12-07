<?php

namespace CommerceMLParser\Model;


use CommerceMLParser\ORM\Model;

class Property extends Model
{
    /**
     * @var string $id
     */
    public $id;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var array $values
     */
    public $values = array();

    /**
     * @var string $description
     */
    public $description;

    /**
     * @var bool $isRequired
     */
    public $isRequired;

    /**
     * @var bool $isList
     */
    public $isList;

    /**
     * @var string $type
     */
    public $type;

    /**
     * @var bool $isUsed ;
     */
    public $isUsed;

    /**
     * @param \SimpleXMLElement|null $importXml
     * @return \CommerceMLParser\Model\Property
     */
    public function __construct($importXml = null)
    {
        if (!is_null($importXml)) {
            $this->loadImport($importXml);
        }
    }

    /**
     * @param \SimpleXMLElement $xml
     * @return void
     */
    public function loadImport($xml)
    {
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
     * @param string $valueId
     * @return null|string
     */
    public function getValue($valueId)
    {
        if (isset($this->values[$valueId])) {
            return $this->values[$valueId];
        }

        return null;
    }

}
