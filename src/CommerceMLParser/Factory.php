<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 20/04/15
 * Time: 12:33
 */

namespace CommerceMLParser;


use CommerceMLParser\Exception\NoObjectException;
use CommerceMLParser\Exception\NoPathException;
use CommerceMLParser\Model\Interfaces\HasChild;
use CommerceMLParser\ORM\Collection;
use CommerceMLParser\ORM\Model;

class Factory {
    /**
     * @var array
     */
    public static $objects = [
        'КоммерческаяИнформация/Классификатор/Владелец' => [
            'model'         => '\CommerceMLParser\Model\Types\Partner',
            'event'         => '\CommerceMLParser\Event\OwnerEvent',
        ],
        'КоммерческаяИнформация/Классификатор/Группы/Группа' => [
            'model'         => '\CommerceMLParser\Model\Category',
            'event'         => '\CommerceMLParser\Event\CategoryEvent',
            'collection'    => '\CommerceMLParser\Model\CategoryCollection',
            'child'         => 'commerceml:Группы/commerceml:Группа'
        ],
        'КоммерческаяИнформация/Классификатор/Свойства/Свойство' => [
            'model'         => '\CommerceMLParser\Model\Property',
            'event'         => '\CommerceMLParser\Event\PropertyEvent',
        ],
        'КоммерческаяИнформация/Каталог/Товары/Товар' => [
            'model'         => '\CommerceMLParser\Model\Product',
            'event'         => '\CommerceMLParser\Event\ProductEvent',
        ],

        'КоммерческаяИнформация/ПакетПредложений/Владелец' => [
            'model'         => '\CommerceMLParser\Model\Types\Partner',
            'event'         => '\CommerceMLParser\Event\OwnerEvent',
        ],
        'КоммерческаяИнформация/ПакетПредложений/ТипыЦен/ТипЦены' => [
            'model'         => '\CommerceMLParser\Model\PriceType',
            'event'         => '\CommerceMLParser\Event\PriceTypeEvent',
        ],
        'КоммерческаяИнформация/ПакетПредложений/Склады/Склад' => [
            'model'         => '\CommerceMLParser\Model\Warehouse',
            'event'         => '\CommerceMLParser\Event\WarehouseEvent',
        ],
        'КоммерческаяИнформация/ПакетПредложений/Предложения/Предложение' => [
            'model'         => '\CommerceMLParser\Model\Offer',
            'event'         => '\CommerceMLParser\Event\OfferEvent',
        ]
    ];

    /**
     * @param string $path
     * @param \SimpleXMLElement $xml
     * @return array
     * @throws NoObjectException
     * @throws NoPathException
     */
    public function createObject($path, $xml)
    {
        if (empty(self::$objects[$path]['model'])) {
            throw new NoPathException($path);
        }
        if (!class_exists(self::$objects[$path]['model'])) {
            throw new NoObjectException(self::$objects[$path]['model']);
        }
        $object = new self::$objects[$path]['model']($xml);

        if (!empty(self::$objects[$path]['child']) && $object instanceof HasChild && !empty(self::$objects[$path]['collection']) && class_exists(self::$objects[$path]['collection'])) {
            /** @var Collection $collection */
            $collection = new self::$objects[$path]['collection']();
            $collection->add($object);
            $this->addChild($object, $path, $xml);
        }

        return [isset($collection) ? $collection : $object, self::$objects[$path]];
    }

    /**
     * @param HasChild $object
     * @param string $path
     * @param \SimpleXMLElement $xml
     * @throws NoObjectException
     */
    protected function addChild(HasChild $object, $path, $xml)
    {
        foreach ($xml->getDocNamespaces() as $strPrefix => $strNamespace) {
            if (strlen($strPrefix) == 0) {
                $strPrefix = "commerceml";
            }
            $xml->registerXPathNamespace($strPrefix, $strNamespace);
        }
        if(!$xml->getDocNamespaces()){
            $xml->registerXPathNamespace("commerceml", "commerceml");
        }
        foreach ($xml->xpath(self::$objects[$path]['child']) as $childxml) {
            $child = new self::$objects[$path]['model']($childxml);
            $object->addChild($child);
            $this->addChild($child, $path, $childxml);
        }
    }
}
