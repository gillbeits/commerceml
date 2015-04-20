<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 20/04/15
 * Time: 12:23
 */

namespace CommerceMLParser;


use CommerceMLParser\Event;

class BulkEvent extends Event {
    protected $event;

    function __construct($event)
    {
        $this->event = $event;
        call_user_func_array('parent::__construct', func_get_args());
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }
}