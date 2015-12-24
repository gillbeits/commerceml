<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 20/04/15
 * Time: 14:17
 */

namespace CommerceMLParser;

use Symfony\Component\EventDispatcher\Event as BaseClass;

/**
 * Class Event
 * @package CommerceMLParser
 */
class Event extends BaseClass {
    /** @var Parser  */
    protected $parser;

    function __construct()
    {
        $args = func_get_args();
        $this->parser = end($args);
    }

    /**
     * @return Parser
     */
    public function getParser()
    {
        return $this->parser;
    }
}