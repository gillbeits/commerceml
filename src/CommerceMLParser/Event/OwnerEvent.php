<?php
/**
 * Created by PhpStorm.
 * User: Andrey Shertsinger <andrey@shertsinger.ru>
 * Date: 20/05/2017
 * Time: 02:07
 */

namespace CommerceMLParser\Event;

use CommerceMLParser\Event;
use CommerceMLParser\Model\Types\Partner;

class OwnerEvent extends Event
{

    protected $partner;

    function __construct(Partner $partner)
    {
        $this->partner = $partner;
        call_user_func_array('parent::__construct', func_get_args());
    }

    /**
     * @return Partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

}
