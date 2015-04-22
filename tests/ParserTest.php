<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17/04/15
 * Time: 19:58
 */

namespace CommerceMLParser\Tests;

use CommerceMLParser\BulkEvent;
use CommerceMLParser\Event\CategoryEvent;
use CommerceMLParser\Event\ProductEvent;
use CommerceMLParser\Event\PropertyEvent;
use CommerceMLParser\Event\PriceTypeEvent;
use CommerceMLParser\Event\OfferEvent;
use CommerceMLParser\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Parser
     */
    protected static $Parser;

    public function setUp()
    {
        self::$Parser = new Parser();
    }

    public function tearDown()
    {
        self::$Parser = null;
    }

    /**
     * @test Parser::parse()
     */
    public function parseImportXmlTest()
    {
        self::$Parser->parse(__DIR__ . '/import.xml');
    }

    /**
     * @test Parser::parse()
     */
    public function parseOffersXmlTest()
    {
        self::$Parser->parse(__DIR__ . '/offers.xml');
    }

    /**
     * @test
     * @depends parseImportXmlTest
     */
    public function categoryEventTest()
    {
        $this->expectOutputString('2');
        self::$Parser->addListener('CategoryEvent', function (CategoryEvent $categoryEvent) {
            print count($categoryEvent->getCategory()->fetch());
        });
        self::$Parser->parse(__DIR__ . '/import.xml');
    }

    /**
     * @test
     * @depends parseImportXmlTest
     */
    public function productEventTest()
    {
        $counter = 0;
        self::$Parser->addListener('ProductEvent', function (ProductEvent $productEvent) use (&$counter) {
            $counter++;
        });
        self::$Parser->parse(__DIR__ . '/import.xml');

        $this->assertEquals(6, $counter);
    }

    /**
     * @test
     * @depends parseImportXmlTest
     */
    public function propertyEventTest()
    {
        $counter = 0;
        self::$Parser->addListener('PropertyEvent', function (PropertyEvent $propertyEvent) use (&$counter) {
            $counter++;
        });
        self::$Parser->parse(__DIR__ . '/import.xml');

        $this->assertEquals(5, $counter);
    }

    /**
     * @test
     * @depends parseOffersXmlTest
     */
    public function priceTypeEventTest()
    {
        $counter = 0;
        self::$Parser->addListener('PriceTypeEvent', function (PriceTypeEvent $priceTypeEvent) use (&$counter) {
            $counter++;
        });
        self::$Parser->parse(__DIR__ . '/offers.xml');

        $this->assertEquals(2, $counter);
    }

    /**
     * @test
     * @depends parseOffersXmlTest
     */
    public function offerEventTest()
    {
        $counter = 0;
        self::$Parser->addListener('OfferEvent', function (OfferEvent $offerEvent) use (&$counter) {
            $counter++;
        });
        self::$Parser->parse(__DIR__ . '/offers.xml');

        $this->assertEquals(6, $counter);
    }

    /**
     * @test
     */
    public function parseObjectTest()
    {
        // import.xml objects
        self::$Parser->addListener('ProductEvent', function (ProductEvent $productEvent) {
            //var_dump($productEvent->getProduct());
        });
        self::$Parser->addListener('CategoryEvent', function (CategoryEvent $categoryEvent) {
            //var_dump($categoryEvent->getCategory()->fetch());
        });
        self::$Parser->addListener('PropertyEvent', function (PropertyEvent $propertyEvent) {
            //var_dump($propertyEvent->getProperty());
        });
        self::$Parser->parse(__DIR__ . '/import.xml');

        // offers.xml objects
        self::$Parser->addListener('PriceTypeEvent', function (PriceTypeEvent $priceTypeEvent) {
            //var_dump($priceTypeEvent->getPriceType());
        });
        self::$Parser->addListener('OfferEvent', function (OfferEvent $offerEvent) {
            //var_dump($offerEvent->getOffer());
        });
        self::$Parser->parse(__DIR__ . '/offers.xml');
    }

    /**
     * @test
     * @depends parseImportXmlTest
     */
    public function bulkUploadTest()
    {
        $this->expectOutputString("Count of bulk rows: 1\nCount of elements in category collection: 2\n");
        self::$Parser->addListener('CategoryEvent', function (CategoryEvent $categoryEvent) {
            $categoryEvent->getParser()->addRow('CategoryEvent', $categoryEvent->getCategory());
        });

        self::$Parser->addListener('BulkUpload', function (BulkEvent $bulkEvent) {
            $rows = $bulkEvent->getParser()->getRows($bulkEvent->getEvent());
            switch ($bulkEvent->getEvent()) {
                case 'CategoryEvent':
                    print "Count of bulk rows: " . count($rows) . "\n";
                    print "Count of elements in category collection: " . count($rows[0]->fetch()) . "\n";
                    break;
            }
        });

        self::$Parser->parse(__DIR__ . '/import.xml');
    }


}
