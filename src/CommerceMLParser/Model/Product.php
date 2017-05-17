<?php

namespace CommerceMLParser\Model;


use CommerceMLParser\Model\Interfaces\IdModel;
use CommerceMLParser\Model\Types\BaseUnit;
use CommerceMLParser\Model\Types\Partner;
use CommerceMLParser\Model\Types\ProductCharacteristic;
use CommerceMLParser\Model\Types\PropertyValue;
use CommerceMLParser\Model\Types\RequisiteValue;
use CommerceMLParser\Model\Types\TaxRate;
use CommerceMLParser\ORM\Collection;
use CommerceMLParser\ORM\Model;
use CommerceMLParser\Parser;

class Product extends Model implements IdModel
{
    /** @var string */
    protected $id;
    /** @var string */
    protected $name;
    /** @var string */
    protected $description;
    /** @var Collection|string[]  */
    protected $categories;
    /** @var Collection|RequisiteValue[]  */
    protected $requisites;
    /** @var Collection|PropertyValue[]  */
    protected $properties;
    /** @var string */
    protected $sku;
    /** @var string */
    protected $barcode;
    /** @var Collection|ProductCharacteristic[]  */
    protected $characteristics;
    /** @var Collection|BaseUnit[] */
    protected $baseUnit;
    /** @var Collection|TaxRate[]  */
    protected $taxRate;
    /** @var Collection|string[]  */
    protected $images;
    /** @var Collection|Partner[] */
    protected $manufacturer;

    /**
     * Class constructor.
     * @param \SimpleXMLElement $xml
     */
    public function __construct(\SimpleXMLElement $xml = null)
    {
        parent::__construct($xml);
        if (null === $xml) return;

        $this->categories = new Collection();
        $this->requisites = new Collection();
        $this->properties = new Collection();
        $this->manufacturer = new Collection();
        $this->baseUnit = new Collection();

        $this->characteristics = new Collection();
        $this->images = new Collection();
        $this->taxRate = new Collection();

        $this->id = (string)$xml->Ид;
        $this->name = (string)$xml->Наименование;
        $this->description = (string)$xml->Описание;
        $this->sku = (string)$xml->Артикул;
        $this->barcode = (string)$xml->Штрихкод;

        if ($xml->Группы) {
            foreach ($xml->Группы->Ид as $categoryId) {
                $this->categories->add((string)$categoryId);
            }
        }

        if ($xml->ЗначенияРеквизитов) {
            foreach ($xml->ЗначенияРеквизитов->ЗначениеРеквизита as $value) {
                $this->requisites->add(new RequisiteValue($value));
            }
        }

        if ($xml->ЗначенияСвойств) {
            foreach ($xml->ЗначенияСвойств->ЗначенияСвойства as $prop) {
                $this->properties->add(new PropertyValue($prop));
            }
        }

        if ($xml->Картинка) {
            $dirName = dirname(Parser::getInstance()->getCurrentFile()->getRealPath());
            foreach ($xml->Картинка as $image) {
                if (file_exists($path = realpath($dirName . DIRECTORY_SEPARATOR . (string)$image))) {
                    $this->images->add($path);
                }
            }
        }

        if ($xml->Изготовитель) {
            foreach ($xml->Изготовитель as $manufacture) {
                $this->manufacturer->add(new Partner($manufacture));
            }
        }

        if ($xml->ХарактеристикиТовара) {
            foreach ($xml->ХарактеристикиТовара->ХарактеристикаТовара as $value) {
                $this->characteristics->add(new ProductCharacteristic($value));
            }
        }

        if ($xml->БазоваяЕдиница) {
            foreach ($xml->БазоваяЕдиница as $baseItem) {
                $this->baseUnit->add(new BaseUnit($baseItem));
            }
        }

        if ($xml->СтавкиНалогов) {
            foreach ($xml->СтавкиНалогов->СтавкаНалога as $value) {
                $this->taxRate->add(new TaxRate($value));
            }
        }
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Collection|\string[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return Types\RequisiteValue[]|Collection
     */
    public function getRequisites()
    {
        return $this->requisites;
    }

    /**
     * @return Types\PropertyValue[]|Collection
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @return Types\ProductCharacteristic[]|Collection
     */
    public function getCharacteristics()
    {
        return $this->characteristics;
    }

    /**
     * @return BaseUnit
     */
    public function getBaseUnit()
    {
        return $this->baseUnit;
    }

    /**
     * @return Types\TaxRate[]|Collection
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @return Collection|\string[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return Partner
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }
}
