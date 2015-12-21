<?php


class ImportParserTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /** @var  \CommerceMLParser\Parser */
    protected $parser;

    protected function _before()
    {
        $this->parser = \CommerceMLParser\Parser::getInstance();
    }

    protected function _after()
    {
    }

    public function testParser()
    {
        $this->parser->addListener('ProductEvent', [$this, 'ProductEvent']);
        $this->parser->addListener('CategoryEvent', [$this, 'CategoryEvent']);
        $this->parser->addListener('OfferEvent', [$this, 'OfferEvent']);
        $this->parser->addListener('PropertyEvent', [$this, 'PropertyEvent']);
        $this->parser->addListener('ProductEventStart', [$this, 'StartEvent']);
        $this->parser->addListener('CategoryEventStart', [$this, 'StartEvent']);
        $this->parser->parse(dirname(__FILE__) . '/../../example/import___b815e2db-7a65-4265-9241-5f0c4f0565a7.xml');
        $this->parser->parse(dirname(__FILE__) . '/../../example/1/import___6b163182-d760-4302-b5fb-4c1d76d8eb85.xml');
//        $this->parser->parse(dirname(__FILE__) . '/../../example/offers___f0bab95c-14a6-4141-9746-6650b65f1191.xml');
        exit;
    }

    public function ProductEvent(\CommerceMLParser\Event\ProductEvent $event, $eventName)
    {
        var_dump($eventName);
    }

    public function CategoryEvent(\CommerceMLParser\Event\CategoryEvent $event, $eventName)
    {
        var_dump($eventName);
    }

    public function OfferEvent(\CommerceMLParser\Event\OfferEvent $event, $eventName)
    {
    }

    public function PropertyEvent(\CommerceMLParser\Event\PropertyEvent $event, $eventName)
    {
        var_dump($eventName);
    }

    public function StartEvent(\CommerceMLParser\Event\StartEvent $event, $eventName)
    {
        var_dump($eventName);
    }
}