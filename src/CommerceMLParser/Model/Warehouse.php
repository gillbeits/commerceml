<?php
/**
 * Created by PhpStorm.
 * User: Andrey Shertsinger <andrey@shertsinger.ru>
 * Date: 17/05/2017
 * Time: 01:41
 */

namespace CommerceMLParser\Model;

use CommerceMLParser\Model\Interfaces\IdModel;
use CommerceMLParser\ORM\Model;

class Warehouse extends Model implements IdModel
{
    /** @var string */
    protected $id;
    /** @var string */
    protected $name;

    /**
     * @param \SimpleXMLElement $xml
     * @return Warehouse
     */
    public function __construct(\SimpleXMLElement $xml = null)
    {
        parent::__construct($xml);
        if (!is_null($xml)) {
            $this->id = (string) $xml->Ид;
            $this->name = (string) $xml->Наименование;
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

}
