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
use CommerceMLParser\ORM\Collection;
use CommerceMLParser\ORM\Model;

class Factory {
    /**
     * @var array
     */
    protected static $objects = [
        'КоммерческаяИнформация/Классификатор/Группы/Группа' => [
            'model'         => '\CommerceMLParser\Model\Category',
            'event'         => '\CommerceMLParser\Event\CategoryEvent',
            'collection'    => '\CommerceMLParser\Model\CategoryCollection',
            'child'         => 'Группы/Группа'
        ],
        'КоммерческаяИнформация/Классификатор/Свойства/СвойствоНоменклатуры' => [
            'model'         => '\CommerceMLParser\Model\Property',
            'event'         => '\CommerceMLParser\Event\PropertyEvent',
        ],
        'КоммерческаяИнформация/Каталог/Товары/Товар' => [
            'model'         => '\CommerceMLParser\Model\Product',
            'event'         => '\CommerceMLParser\Event\ProductEvent',
        ],

        'КоммерческаяИнформация/ПакетПредложений/ТипыЦен/ТипЦены' => [
            'model'         => '\CommerceMLParser\Model\PriceType',
            'event'         => '\CommerceMLParser\Event\PriceTypeEvent',
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

        if (!empty(self::$objects[$path]['collection'])) {
            /** @var Collection $collection */
            $collection = new self::$objects[$path]['collection']();
            $collection->add($object);
            $this->addChild($object, $collection, $path, $xml);
        }

        return [isset($collection) ? $collection : $object, self::$objects[$path]];
    }

    /**
     * @param Model $object
     * @param Collection $collection
     * @param string $path
     * @param \SimpleXMLElement $xml
     * @throws NoObjectException
     */
    protected function addChild($object, $collection, $path, $xml)
    {
        if (!empty(self::$objects[$path]['child']) && method_exists($object, 'addChild')) {
            foreach ($xml->xpath(self::$objects[$path]['child']) as $childxml) {
                $child = new self::$objects[$path]['model']($childxml);
                $object->addChild($child);
                $collection->add($child);
                $this->addChild($child, $collection, $path, $childxml);
            }
        }
    }
}