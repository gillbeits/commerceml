<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 21.12.15
 * Time: 15:42
 */

namespace CommerceMLParser\Event;


use CommerceMLParser\Creational\Multiton;
use CommerceMLParser\Event;

class StartEvent extends Event
{
    use Multiton;

    /**
     * @inheritDoc
     */
    protected function __init()
    {
        call_user_func_array('parent::__construct', func_get_args());
    }
}