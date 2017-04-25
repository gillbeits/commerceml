<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 23.12.15
 * Time: 12:37
 */

namespace CommerceMLParser\Model\Types;

use CommerceMLParser\Model\Interfaces\IdModel;
use CommerceMLParser\ORM\Model;

/**
 * Class WarehouseStock
 * @package CommerceMLParser\Model\Types
 *
 * xsd:complexType name="ОстаткиПоСкладам"
 */
class WarehouseStock extends Model implements IdModel
{
    /** @var string ИдСклада */
    protected $id;
    /** @var int КоличествоНаСкладе */
    protected $quantity;

    /**
     * @inheritDoc
     */
    public function __construct(\SimpleXMLElement $xml)
    {
        parent::__construct($xml);
        $this->id = (string)$xml->attributes()->ИдСклада;
        $this->quantity = (string)$xml->attributes()->КоличествоНаСкладе;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
