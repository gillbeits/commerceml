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


class Factory {
    /**
     * @var array
     */
    protected static $objects = [
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
     * @return array
     */
    public function getObjects()
    {
        return static::$objects;
    }

    /**
     * @param string $path
     * @param \SimpleXMLElement $xml
     * @return array
     * @throws NoObjectException
     * @throws NoPathException
     */
    public function createObject($path, $xml)
    {
        if (empty(static::$objects[$path]['model'])) {
            throw new NoPathException($path);
        }
        if (!class_exists(static::$objects[$path]['model'])) {
            throw new NoObjectException(static::$objects[$path]['model']);
        }
        $object = new static::$objects[$path]['model']($xml);

        if (!empty(static::$objects[$path]['child']) && $object instanceof HasChild && !empty(static::$objects[$path]['collection']) && class_exists(static::$objects[$path]['collection'])) {
            /** @var Collection $collection */
            $collection = new static::$objects[$path]['collection']();
            $collection->add($object);
            $this->addChild($object, $path, $xml);
        }

        return [isset($collection) ? $collection : $object, static::$objects[$path]];
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
        foreach ($xml->xpath(static::$objects[$path]['child']) as $childxml) {
            $child = new static::$objects[$path]['model']($childxml);
            $object->addChild($child);
            $this->addChild($child, $path, $childxml);
        }
    }
}
