<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 20/04/15
 * Time: 14:29
 */

namespace CommerceMLParser\Exception;


class NoPathException extends \Exception {
    /**
     * @param string $path
     * @param \Exception $previous
     */
    public function __construct($path, \Exception $previous = null)
    {
        $message = 'No register path "' . $path . '" in factory';
        parent::__construct($message, null, $previous);
    }
}