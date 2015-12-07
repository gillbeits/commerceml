<?php

namespace CommerceMLParser\ORM;


class Collection
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
        $this->items = $items;
    }

    /**
     * Add item to collection.
     *
     * @param array|object $item
     * @param string $key
     * @return Collection
     */
    public function add($item, $key = 'id')
    {
        if (is_array($item)) {
            foreach ($item as $i) {
                $this->add($i, $key);
            }
        }
        else {
            if (property_exists($item, $key)) {
                $this->items[$item->{$key}] = $item;
            } else {
                $this->items[] = $item;
            }
        }

        return $this;
    }

    /**
     * Filter collection.
     *
     * @param string $key
     * @param mixed $val
     * @return Collection
     */
    public function filter($key, $condition, $val)
    {
        $result = array();
        foreach($this->items as $i => $item) {
            $filterMethod = 'filter'.ucfirst($key);

            if (method_exists($item, $filterMethod)) {
                $val = $item->{$filterMethod}($condition, $val);
            }

            if (isset($item->{$key})) {

                if ($condition == '=' || $condition == '==') {
                    if ($item->{$key} == $val) {
                        $result[$i] = $item;
                    }
                }

                else if ($condition == '>') {
                    if ($item->{$key} > $val) {
                        $result[$i] = $item;
                    }
                }

                else if ($condition == '>=') {
                    if ($item->{$key} >= $val) {
                        $result[$i] = $item;
                    }
                }

                else if ($condition == '<') {
                    if ($item->{$key} < $val) {
                        $result[$i] = $item;
                    }
                }

                else if ($condition == '<=') {
                    if ($item->{$key} <= $val) {
                        $result[$i] = $item;
                    }
                }

                else if ($condition == '!=') {
                    if ($item->{$key} != $val) {
                        $result[$i] = $item;
                    }
                }

            }
        }

        $called = get_called_class();
        return new $called($result);
    }

    /**
     * Remove item form collection.
     *
     * @param string $index
     * @param string $key
     * @return bool
     */
    public function remove($index, $key = 'id')
    {
        if ($key == 'id') {
            if (isset($this->items[$index])) {
                unset($this->items[$index]);
            }
        }
        else {
            foreach ($this->filter($key, '=', $index)->fetch() as $i => $filtered) {
                unset($this->items[$i]);
            }
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
     * Get first element from collection.
     *
     * @return object
     */
    public function first()
    {
        if (! empty($this->items))
        {
            $firstKey = key($this->items);
            return $this->items[$firstKey];
        }

        return false;
    }

    /**
     * Attach collection to collection.
     *
     * @param Collection $collection
     * @return void
     */
    public function attach($collection)
    {
        $attachMethod = 'attach'.array_pop(explode('\\', get_class($collection)));

        if (method_exists($this, $attachMethod)) {
            $this->{$attachMethod}($collection);
        }

        $this->{$attachMethod}($collection);
    }

    /**
     * Get item by id.
     *
     * @param string $id
     * @return Model
     */
    public function get($id)
    {
        if (isset($this->items[$id])) {
            return $this->items[$id];
        }

        return null;
    }

    /**
     * Check collection for empty.
     */
    public function isEmpty()
    {
        return empty($this->items);
    }
}
