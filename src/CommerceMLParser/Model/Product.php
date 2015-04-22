<?php namespace CommerceMLParser\Model;

use Zenwalker\CommerceML\Model\Product as ProductParent;

class Product extends ProductParent
{
    /**
     * @var string $code
     */
    public $code;

    /**
     * @var string $barcode
     */
    public $barcode;

    /**
     * @var array $characteristics
     */
    public $characteristics = array();

    /**
     * @var array $baseUnit
     */
    public $baseUnit = array();

    /**
     * @var array $taxRate
     */
    public $taxRate = array();

    /**
     * Load primary data from import.xml.
     *
     * @param SimpleXMLElement $xml
     * @return void
     */
    public function loadImport($xml)
    {
        parent::loadImport($xml);

        $this->code = (string) $xml->Артикул;
        $this->barcode = (string) $xml->ШтрихКод;

        if ($xml->ХарактеристикиТовара) {
            foreach ($xml->ХарактеристикиТовара->ХарактеристикаТовара as $value) {
                $id = (string) $value->Ид;
                $this->characteristics[$id] = array(
                    'name' => (string) $value->Наименование,
                    'value' => (string) $value->Значение
                );
            }
        }

        if ($xml->БазоваяЕдиница) {
            $this->baseUnit = array(
                'value' => (string) $xml->БазоваяЕдиница,
                'code' => (string) $xml->БазоваяЕдиница['Код'],
                'nameFull' => (string) $xml->БазоваяЕдиница['НаименованиеПолное'],
                'nameShort' => (string) $xml->БазоваяЕдиница['НаименованиеКраткое'],
                'nameInterShort' => (string) $xml->БазоваяЕдиница['МеждународноеСокращение'],
            );
        }

        if ($xml->СтавкиНалогов) {
            foreach ($xml->СтавкиНалогов->СтавкаНалога as $value) {
                $name = (string) $value->Наименование;
                $value = (string) $value->Ставка;

                if ($name == 'НДС') {
                    $this->taxRate['nds'] = $value;
                }
            }
        }

    }

}
