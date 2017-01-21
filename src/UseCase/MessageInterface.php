<?php

/**
 * This file is part of the PhpClean package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace PhpClean\UseCase;

/**
 * Interface MessageInterface.
 *
 * @package PhpClean
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    https://github.com/lorenzomar/phpclean
 */
interface MessageInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * keys.
     *
     * @return array
     */
    public function keys();

    /**
     * set.
     *
     * @param string $key   The data key
     * @param mixed  $value The data value
     *
     * @return static
     */
    public function set($key, $value);

    /**
     * get.
     *
     * @param string $key     The data key
     * @param mixed  $default The default value to return if data key does not exist
     *
     * @return mixed The key's value, or the default value
     */
    public function get($key, $default = null);

    /**
     * has.
     *
     * @param string $key The data key
     *
     * @return bool
     */
    public function has($key);

    /**
     * hasOneOf.
     *
     * @param array $alternatives
     *
     * @return bool
     */
    public function hasOne(array $alternatives);

    /**
     * hasAllOf.
     *
     * @param array $alternatives
     *
     * @return bool
     */
    public function hasAll(array $alternatives);

    /**
     * isEmpty.
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * filter.
     * Returns all the elements of this collection that satisfy the predicate p. The order of the elements is preserved.
     *
     * @param callable $p
     *
     * @return mixed
     */
    public function filter(callable $p);

    /**
     * map.
     * Applies the given function to each element in the collection and returns a new collection with the elements
     * returned by the function.
     *
     * @param callable $function
     *
     * @return mixed
     */
    public function map(callable $function);

    /**
     * toArray.
     *
     * @return array
     */
    public function toArray();
}