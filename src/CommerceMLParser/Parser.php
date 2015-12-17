<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 17/04/15
 * Time: 19:47
 */

namespace CommerceMLParser;


use CommerceMLParser\Exception\NoEventException;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class Parser
 * @package CommerceMLParser
 *
 */
class Parser extends EventDispatcher {
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
     * @var static The stored singleton instance
     */
    protected static $instance;

    /**
     * Creates the original or retrieves the stored singleton instance
     * @param Factory $factory
     * @return static
     */
    public static function getInstance(Factory $factory = null)
    {
        if (!static::$instance) {
            static::$instance = (new \ReflectionClass(get_called_class()))
                ->newInstanceWithoutConstructor();
        }
        call_user_func_array([static::$instance, "create"], func_get_args());
        return static::$instance;
    }

    /**
     * The constructor is disabled
     *
     * @throws \RuntimeException if called
     */
    public function __construct()
    {
        throw new \RuntimeException('You may not explicitly instantiate this object, because it is a singleton.');
    }

    /**
     * Cloning is disabled
     *
     * @throws \RuntimeException if called
     */
    public function __clone()
    {
        throw new \RuntimeException('You may not clone this object, because it is a singleton.');
    }

    /**
     * Unserialization is disabled
     *
     * @throws \RuntimeException if called
     */
    public function __wakeup()
    {
        throw new \RuntimeException('You may not unserialize this object, because it is a singleton.');
    }

    /**
     * Unserialization is disabled
     *
     * @throws \RuntimeException if called
     */
    public function unserialize($serialized_data)
    {
        throw new \RuntimeException('You may not unserialize this object, because it is a singleton.');
    }

    protected function create(Factory $factory = null)
    {
        if (null == $factory) {
            $factory = new Factory();
        }

        $this->xmlReader = new \XMLReader();
        $this->factory = $factory;

        $this->registerPath('КоммерческаяИнформация/Классификатор/Группы/Группа', $this->dispatchObjectCallable());
        $this->registerPath('КоммерческаяИнформация/Классификатор/Свойства/СвойствоНоменклатуры', $this->dispatchObjectCallable());
        $this->registerPath('КоммерческаяИнформация/Каталог/Товары/Товар', $this->dispatchObjectCallable());

        $this->registerPath('КоммерческаяИнформация/ПакетПредложений/ТипыЦен/ТипЦены', $this->dispatchObjectCallable());
        $this->registerPath('КоммерческаяИнформация/ПакетПредложений/Предложения/Предложение', $this->dispatchObjectCallable());
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
            $this->dispatch($event, new $object[1]['event']($object[0], $self));
        };
    }

    /**
     * @return array
     */
    public function getBulkRowsCounter($event)
    {
        return $this->bulk_rows_counter[$event];
    }

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

    protected function read()
    {
        $shop = null;
        $xml = $this->xmlReader;
        while ($xml->read()) {
            if ($xml->nodeType == \XMLReader::END_ELEMENT) {
                array_pop($this->path);
                continue;
            }


            if ($xml->nodeType == \XMLReader::ELEMENT) {
                array_push($this->path, $xml->name);
                $path = implode('/', $this->path);

                if ($xml->isEmptyElement) {
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
                $this->dispatch('BulkUpload', new BulkEvent($event, $this));
            }
        }
    }

    public function addRow($event, $obj)
    {
        $this->bulk_rows[$event][] = $obj;
        @$this->bulk_rows_counter[$event]++;
        if (count($this->bulk_rows[$event]) >= $this->bulk_count) {
            $this->dispatch('BulkUpload', new BulkEvent($event, $this));
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
     */
    public function setBulkCount($bulk_count)
    {
        $this->bulk_count = $bulk_count;
        return $this;
    }
}