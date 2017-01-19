<?php

/**
 * This file is part of the PhpClean package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace PhpClean;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Class AbstractMessage.
 * @TODO portare tutta la logica nei metodi offsetSet/Unset/....
 * @TODO catchare eccezioini nei metodi get dell'accessor. Vengono sollevate in caso la chiave non esista
 *
 * @package PhpClean
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    https://github.com/lorenzomar/phpclean
 */
abstract class AbstractMessage implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var PropertyAccessorInterface
     */
    protected $accessor;

    /**
     * @var array
     */
    protected $data = [];

    public function __construct(array $data = [], PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->accessor = is_null($propertyAccessor) ? new PropertyAccessor() : $propertyAccessor;

        $this->setMultiple($data);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function count()
    {
        return count($this->data);
    }

    /**
     * setMultiple.
     * Set multiple items
     *
     * @param array $items
     *
     * @return static
     */
    public function setMultiple(array $items)
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * set.
     *
     * @param string $key   The data key
     * @param mixed  $value The data value
     *
     * @return static
     */
    public function set($key, $value)
    {
        $this->accessor->setValue($this->data, $this->prepareKey($key), $value);

        return $this;
    }

    /**
     * get.
     *
     * @param string $key     The data key
     * @param mixed  $default The default value to return if data key does not exist
     *
     * @return mixed The key's value, or the default value
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->accessor->getValue($this->data, $this->prepareKey($key)) : $default;
    }

    /**
     * has.
     *
     * @param string $key The data key
     *
     * @return bool
     */
    public function has($key)
    {
        return !is_null($this->accessor->getValue($this->data, $this->prepareKey($key)));
    }

    public function hasOneOf(array $choices)
    {
        foreach($choices as $choice) {
            if($this->accessor->getValue($this->data, $this->prepareKey($key)))
        }
    }

    /**
     * toArray.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    private function prepareKey($key)
    {
        return "[" . trim($key, '[]') . "]";
    }
}