<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17/04/15
 * Time: 19:47
 */

namespace CommerceMLParser;


use CommerceMLParser\Creational\Singleton;
use CommerceMLParser\Event\ProductEvent;
use CommerceMLParser\Event\StartEvent;
use CommerceMLParser\Exception\NoEventException;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class Parser
 * @package CommerceMLParser
 *
 * @method static Parser getInstance(Factory $factory = null)
 */
class Parser extends EventDispatcher {
    use Singleton;

    /** @var \XMLReader  */
    protected $xmlReader;
    /** @var Factory  */
    protected $factory;
    /** @var array|callable[]  */
    protected $callable = [];
    /** @var  \SplFileObject */
    protected $currentFile;

    /** @var int  */
    private $bulk_count = 0;
    /** @var array  */
    private $path = [];
    /** @var array  */
    private $bulk_rows = [];
    /** @var array  */
    private $bulk_rows_counter = [];

    /**
     * @param Factory|null $factory
     */
    protected function __init(Factory $factory = null)
    {
        if (null == $factory) {
            $factory = new Factory();
            $this->factory = $factory;
        }

        $this->xmlReader = new \XMLReader();
        // Default parse rules
        foreach ($factory->getObjects() as $path => $object) {
            $this->registerPath($path, $this->dispatchObjectCallable());

            $event = explode('\\', $object['event']);
            $event = end($event);

            $this->addListener($event, function (Event $e, $eventName, EventDispatcher $dispatcher) {
                $_e = StartEvent::getInstance($name = $eventName . 'Start');
                if (!$_e->isPropagationStopped()) {
                    $dispatcher->dispatch($_e, $name);
                    $_e->stopPropagation();
                }
            });
        }
    }

    /**
     * @return callable
     */
    protected function dispatchObjectCallable()
    {
        return function ($object, $self) {
            if (!class_exists($object[1]['event'])) {
                throw new NoEventException($object[1]);
            }
            $event = explode('\\', $object[1]['event']);
            $event = end($event);
            $this->dispatch(new $object[1]['event']($object[0], $self), $event);
        };
    }

    /**
     * @return array
     */
    public function getBulkRowsCounter($event)
    {
        return $this->bulk_rows_counter[$event];
    }

    /**
     * @param $file
     * @throws Exception\NoObjectException
     * @throws Exception\NoPathException
     */
    public function parse($file)
    {
        $this->currentFile = new \SplFileObject($file);
        $this->path = [];

        $this->xmlReader->open($file);
        $this->read();
        $this->xmlReader->close();
    }

    /**
     * @return \SplFileObject
     */
    public function getCurrentFile()
    {
        return $this->currentFile;
    }

    /**
     * @param string $path
     * @param callable|callback $callable
     * @return $this
     */
    public function registerPath($path, $callable)
    {
        $this->callable[$path] = $callable;
        return $this;
    }

    /**
     * @throws Exception\NoObjectException
     * @throws Exception\NoPathException
     */
    protected function read()
    {
        $shop = null;
        while ($this->xmlReader->read()) {
            if ($this->xmlReader->nodeType == \XMLReader::END_ELEMENT) {
                array_pop($this->path);
                continue;
            }


            if ($this->xmlReader->nodeType == \XMLReader::ELEMENT) {
                array_push($this->path, $this->xmlReader->name);
                $path = implode('/', $this->path);

                if ($this->xmlReader->isEmptyElement) {
                    array_pop($this->path);
                }

                if (isset($this->callable[$path])) {
                    $object = $this->factory->createObject($path, $this->loadElementXml());
                    call_user_func_array($this->callable[$path], [$object, $this]);
                }
            }
        }

        foreach ($this->bulk_rows as $event => $rows) {
            if (!empty($rows)) {
                $this->dispatch(new BulkEvent($event, $this), 'BulkUpload');
            }
        }
    }

    public function addRow($event, $obj)
    {
        $this->bulk_rows[$event][] = $obj;
        @$this->bulk_rows_counter[$event]++;
        if (count($this->bulk_rows[$event]) >= $this->bulk_count) {
            $this->dispatch(new BulkEvent($event, $this), 'BulkUpload');
            $this->bulk_rows[$event] = [];
        }
    }

    public function getRows($event = null)
    {
        return null!== $event ? $this->bulk_rows[$event] : $this->bulk_rows;
    }

    /**
     * @return \SimpleXMLElement
     */
    protected function loadElementXml()
    {
        $xml = $this->xmlReader->readOuterXml();

        return simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?>' . $xml);
    }

    /**
     * @return int
     */
    public function getBulkCount()
    {
        return $this->bulk_count;
    }

    /**
     * @param int $bulk_count
     * @return Parser
     */
    public function setBulkCount($bulk_count)
    {
        $this->bulk_count = $bulk_count;
        return $this;
    }

    /**
     * @return Factory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}