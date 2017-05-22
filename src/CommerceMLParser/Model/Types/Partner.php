<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17.12.15
 * Time: 12:31
 */

namespace CommerceMLParser\Model\Types;


use CommerceMLParser\Model\Interfaces\IdModel;
use CommerceMLParser\Model\Traits\PartnerProperty;
use CommerceMLParser\Model\Types\Address;
use CommerceMLParser\ORM\Collection;
use CommerceMLParser\ORM\Model;

/**
 * Class Partner
 * @package CommerceMLParser\Model
 *
 * @todo Дописать парсер Агентов
 */
class Partner extends Model implements IdModel
{
    use PartnerProperty;

    /** @var  string */
    protected $id;
    /** @var  string */
    protected $name;
    /** @var  string */
    protected $comment;
    /** @var  Address */
    protected $address;
    /** @var Collection|Contact[]  */
    protected $contacts;
    /** @var array  */
    protected $agents = [];


    public function __construct(\SimpleXMLElement $xml)
    {
        parent::__construct($xml);
        $this->id = (string)$xml->Ид;
        $this->name = (string)$xml->Наименование;
        $this->comment = (string)$xml->Комментарий;
        if ($xml->Адрес) {
            $this->address = new Address($xml->Адрес);
        }
        $this->contacts = new Collection();
        if ($xml->Контакты) {
            foreach ($xml->Контакты->Контакт as $value) {
                $this->contacts->add(new Contact($value));
            }
        }

    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }

}
