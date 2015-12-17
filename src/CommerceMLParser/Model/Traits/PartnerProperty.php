<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17.12.15
 * Time: 12:39
 */

namespace CommerceMLParser\Model\Traits;


use CommerceMLParser\Model\Types\Address;

/**
 * Class PartnerProperty
 * @package CommerceMLParser\Model\Traits
 *
 * @todo Дописать парсер Руководителя и Счетов
 */
trait PartnerProperty
{
    /** @var  string */
    protected $officialName;
    /** @var Address  */
    protected $partnerAddress;
    /** @var  string */
    protected $inn;
    /** @var  string */
    protected $kpp;
    /** @var string  */
    protected $mainActivity;
    /** @var  string */
    protected $egrpo;
    /** @var  string */
    protected $okvd;
    /** @var  string */
    protected $okdp;
    /** @var  string */
    protected $okopf;
    /** @var  string */
    protected $okfs;
    /** @var  string */
    protected $okpo;
    /** @var  \DateTime */
    protected $registerDate;
    protected $head;
    protected $bankAccounts;

    /**
     * PartnerProperty constructor.
     *
     * @param \SimpleXMLElement $xml
     */
    public function __construct(\SimpleXMLElement $xml)
    {
        $this->officialName = (string)$xml->ОфициальноеНаименование;
        $this->partnerAddress = new Address($xml->ЮридическийАдрес);
        $this->inn = (string)$xml->ИНН;
        $this->kpp = (string)$xml->КПП;
        $this->mainActivity = (string)$xml->ОсновнойВидДеятельности;
        $this->egrpo = (string)$xml->ЕГРПО;
        $this->okvd = (string)$xml->ОКВЭД;
        $this->okdp = (string)$xml->ОКДП;
        $this->okopf = (string)$xml->ОКОПФ;
        $this->okfs = (string)$xml->ОКФС;
        $this->okpo = (string)$xml->ОКПО;
        $this->registerDate = new \DateTime((string)$xml->ДатаРегистрации);
    }
}