<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 18.12.15
 * Time: 11:38
 */

namespace CommerceMLParser\Model\Interfaces;


interface HasChild
{
    function addChild($object);
    function getChilds();
}