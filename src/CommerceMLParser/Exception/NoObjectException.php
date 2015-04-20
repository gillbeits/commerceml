<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 20/04/15
 * Time: 13:03
 */

namespace CommerceMLParser\Exception;


use Exception;

/**
 * Class NoObjectException
 * @package CommerceMLParser\Exception
 */
class NoObjectException extends Exception {
    /**
     * @param string $className
     * @param Exception $previous
     */
    public function __construct($className, Exception $previous = null)
    {
        $message = 'No object "' . $className . '" in factory exists';
        parent::__construct($message, null, $previous);
    }
}