<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 20/04/15
 * Time: 14:16
 */

namespace CommerceMLParser\Event;


use CommerceMLParser\Event;
use CommerceMLParser\Model\Property;

class PropertyEvent extends Event {

    protected $property;

    function __construct(Property $property)
    {
        $this->property = $property;
        call_user_func_array('parent::__construct', func_get_args());
    }

    /**
     * @return Property
     */
    public function getProperty()
    {
        return $this->property;
    }

}