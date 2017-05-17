<?php
/**
 * Created by PhpStorm.
 * User: Andrey Shertsinger <andrey@shertsinger.ru>
 * Date: 17/05/2017
 * Time: 01:41
 */

namespace CommerceMLParser\Event;


use CommerceMLParser\Event;
use CommerceMLParser\Model\Warehouse;

class WarehouseEvent extends Event {

    protected $warehouse;

    function __construct(Warehouse $priceType)
    {
        $this->warehouse = $priceType;
        call_user_func_array('parent::__construct', func_get_args());
    }

    /**
     * @return Warehouse
     */
    public function getWarehouse()
    {
        return $this->warehouse;
    }

}
