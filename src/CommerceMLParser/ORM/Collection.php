<?php

namespace CommerceMLParser\ORM;


use CommerceMLParser\Model\Interfaces\IdModel;

class Collection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var array $items
     */
    protected $items = array();

    /**
     * Class constructor.
     *
     * @param array $items
     * @return \CommerceMLParser\ORM\Collection
     */
    public function __construct($items = array())
    {
        $this->add($items);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * @param $callback
     * @return $this
     */
    public function usort($callback) {
        @usort($this->items, $callback);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function first()
    {
        return reset($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function last()
    {
        return end($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        return next($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * @return self
     */
    public function filter(\Closure $p)
    {
        return new static(array_filter($this->items, $p));
    }

    /**
     * Add item to collection.
     *
     * @param array|object $item
     * @return Collection
     */
    public function add($item)
    {
        if (is_array($item) || $item instanceof \Traversable) {
            foreach ($item as $i) {
                $this->add($i);
            }
        }
        else {
            if ($item instanceof IdModel) {
                $this->items[$item->getId()] = $item;
            } else {
                $this->items[] = $item;
            }
        }

        return $this;
    }

    /**
     * @param object $item
     * @return bool|array
     */
    public function has($item){
        return array_search($item, $this->items);
    }

    /**
     * @param object[]|object $items
     * @return $this
     */
    public function replace($items){
        if (is_array($items) || $items instanceof \Traversable) {
            foreach ($items as $item) {
                $this->replace($item);
            }
            return $this;
        }

        $item = $items;

        if (($position = $this->has($item)) !== false) {
            $this->offsetSet($position, $item);
        } else {
            $this->add($item);
        }

        return $this;
    }

    /**
     * @param object[]|object $items
     * @return $this
     */
    public function remove($items){
        if (is_array($items) || $items instanceof \Traversable) {
            foreach ($items as $item) {
                $this->remove($item);
            }
            return $this;
        }

        $item = $items;

        if (($positions = $this->has($item)) !== false) {
            array_splice($this->items, $position, 1);
        }
        return $this;
    }

    /**
     * Return all items as array.
     *
     * @return array
     */
    public function fetch()
    {
        return $this->items;
    }

    /**
     * Check collection for empty.
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]) || array_key_exists($offset, $this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        if (isset($this->items[$offset])) {
            return $this->items[$offset];
        }
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        if (! isset($offset)) {
            return $this->add($value);
        }
        return $this->items[$offset] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
        if (isset($this->items[$offset]) || array_key_exists($offset, $this->items)) {
            $removed = $this->items[$offset];
            unset($this->items[$offset]);

            return $removed;
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Получить элемент по индексу
     *
     * @param $offset
     * @return mixed
     */
    public function get($offset)
    {
        if (isset($this->items[$offset])) {
            return $this->items[$offset];
        }
        return null;
    }
}
