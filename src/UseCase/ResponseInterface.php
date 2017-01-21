<?php

/**
 * This file is part of the PhpClean package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace PhpClean\UseCase;

/**
 * Interface ResponseInterface.
 *
 * @package PhpClean
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    https://github.com/lorenzomar/phpclean
 */
interface ResponseInterface extends MessageInterface
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR   = 'error';

    /**
     * setAsSuccess.
     *
     * @return static
     */
    public function setAsSuccess();

    /**
     * setAsError.
     *
     * @return static
     */
    public function setAsError();

    /**
     * isSuccess.
     *
     * @return bool
     */
    public function isSuccess();

    /**
     * isError.
     *
     * @return bool
     */
    public function isError();

    /**
     * hasError.
     *
     * @param string $key
     * @param string $code
     *
     * @return mixed
     */
    public function hasError($key, $code);

    /**
     * setError.
     *
     * @param string $key
     * @param string $code
     * @param array  $meta
     *
     * @return static
     */
    public function setError($key, $code, array $meta = []);

    /**
     * getError.
     *
     * @param string $key
     * @param string $code
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getError($key, $code, $default = null);

    /**
     * hasOneError.
     *
     * @param array $alternatives list of [key => code] or [key => [codes]]
     *
     * @return mixed
     */
    public function hasOneError(array $alternatives);

    /**
     * hasAllErrors.
     *
     * @param array $alternatives list of list of [key => code] or [key => [codes]]
     *
     * @return mixed
     */
    public function hasAllErrors(array $alternatives);
}