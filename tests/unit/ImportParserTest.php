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
        $this->parser->parse(dirname(__FILE__) . '/../../example/import___6b163182-d760-4302-b5fb-4c1d76d8eb85.xml');
        $this->parser->parse(dirname(__FILE__) . '/../../example/import___b815e2db-7a65-4265-9241-5f0c4f0565a7.xml');
        $this->parser->parse(dirname(__FILE__) . '/../../example/offers___7f304edc-2527-4d3d-b058-6e4ee53de2e0.xml');
        $this->parser->parse(dirname(__FILE__) . '/../../example/offers___f0bab95c-14a6-4141-9746-6650b65f1191.xml');
        $this->parser->parse(dirname(__FILE__) . '/../../example/prices___d66a6b51-ce9c-4e7a-8c7c-25079721107f.xml');
        $this->parser->parse(dirname(__FILE__) . '/../../example/rests___1af6e7b8-a026-4690-9752-1c9d64cb914d.xml');
    }

    public function ProductEvent(\CommerceMLParser\Event\ProductEvent $event)
    {
    }

    public function CategoryEvent(\CommerceMLParser\Event\CategoryEvent $event)
    {
    }

    public function OfferEvent(\CommerceMLParser\Event\OfferEvent $event)
    {
    }

    public function PropertyEvent(\CommerceMLParser\Event\PropertyEvent $event)
    {
    }
}