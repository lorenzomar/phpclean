<?php

/**
 * This file is part of the PhpClean package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace PhpClean\UseCase;

use Symfony\Component\PropertyAccess\Exception\AccessException;
use Symfony\Component\PropertyAccess\Exception\InvalidArgumentException;
use Symfony\Component\PropertyAccess\Exception\UnexpectedTypeException;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Class AbstractMessage.
 *
 * @package PhpClean
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    https://github.com/lorenzomar/phpclean
 */
abstract class AbstractMessage implements MessageInterface
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
        $this->accessor = is_null($propertyAccessor) ? new PropertyAccessor(false, true) : $propertyAccessor;

        $this->setMultiple($data);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    public function offsetExists($offset)
    {
        try {
            $this->accessor->getValue($this->data, $this->prepareKey($offset));

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @inheritdoc
     *
     * @throws InvalidArgumentException If the property path is invalid
     * @throws AccessException          If a property/index does not exist or is not public
     * @throws UnexpectedTypeException  If a value within the path is neither object nor array
     */
    public function offsetGet($offset)
    {
        return $this->accessor->getValue($this->data, $this->prepareKey($offset));
    }

    /**
     * @inheritdoc
     *
     * @return static
     *
     * @throws InvalidArgumentException If the property path is invalid
     * @throws AccessException          If a property/index does not exist or is not public
     * @throws UnexpectedTypeException  If a value within the path is neither object nor array
     */
    public function offsetSet($offset, $value)
    {
        $this->accessor->setValue($this->data, $this->prepareKey($offset), $value);

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return static
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);

        return $this;
    }

    public function count()
    {
        return count($this->data);
    }

    public function keys()
    {
        return array_keys($this->data);
    }

    public function set($key, $value)
    {
        return $this->offsetSet($key, $value);
    }

    public function setMultiple(array $data)
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function get($key, $default = null)
    {
        try {
            return $this->offsetGet($key);
        } catch (\Exception $e) {
            return $default;
        }

    }

    public function has($key)
    {
        return $this->offsetExists($key);
    }

    public function hasOne(array $alternatives)
    {
        foreach ($alternatives as $alternative) {
            if ($this->has($alternative)) {
                return true;
            }
        }

        return false;
    }

    public function hasAll(array $alternatives)
    {
        foreach ($alternatives as $alternative) {
            if (!$this->has($alternative)) {
                return false;
            }
        }

        return true;
    }

    public function isEmpty()
    {
        return (bool)$this->count();
    }

    public function filter(callable $p)
    {
        return array_filter($this->data, $p);
    }

    public function map(callable $function)
    {
        return array_map($function, $this->data);
    }

    public function toArray()
    {
        return $this->data;
    }

    protected function prepareKey($key)
    {
        return "[" . trim($key, '[]') . "]";
    }
}