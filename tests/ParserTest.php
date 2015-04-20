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
    public function parseTest()
    {
        self::$Parser->parse(__DIR__ . '/import.xml');
    }

    /**
     * @test
     * @depends parseTest
     */
    public function eventTest()
    {
        $this->expectOutputString('2');
        self::$Parser->addListener('CategoryEvent', function (CategoryEvent $categoryEvent) {
            print count($categoryEvent->getCategory()->fetch());
        });
        self::$Parser->parse(__DIR__ . '/import.xml');
    }

    /**
     * @test
     */
    public function productEventTest()
    {
        self::$Parser->addListener('ProductEvent', function (ProductEvent $productEvent) {
            var_dump($productEvent->getProduct());
        });
        self::$Parser->parse(__DIR__ . '/import.xml');
    }

    /**
     * @test
     * @depends parseTest
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
