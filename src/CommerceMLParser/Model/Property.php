<?php namespace CommerceMLParser\Model;

use Zenwalker\CommerceML\Model\Property as PropertyParent;

class Property extends PropertyParent
{
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
     * @var bool $isUsed;
     */
    public $isUsed;

    /**
     * @param SimpleXMLElement $xml
     * @return void
     */
    public function loadImport($xml)
    {
        parent::loadImport($xml);

        $this->description = (string) $xml->Описание;
        $this->isRequired = (string) $xml->Обязательное === 'true';
        $this->isList = (string) $xml->Множественное === 'true';
        $this->type = (string) $xml->ТипЗначений;
        $this->isUsed = (string) $xml->ИспользованиеСвойства === 'true';
    }


}
