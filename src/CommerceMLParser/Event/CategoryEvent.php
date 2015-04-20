<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 20/04/15
 * Time: 13:26
 */

namespace CommerceMLParser\Event;


use CommerceMLParser\Event;
use Zenwalker\CommerceML\Model\CategoryCollection;

class CategoryEvent extends Event {

    protected $category;

    function __construct(CategoryCollection $category)
    {
        $this->category = $category;
        call_user_func_array('parent::__construct', func_get_args());
    }

    /**
     * @return CategoryCollection
     */
    public function getCategory()
    {
        return $this->category;
    }



}