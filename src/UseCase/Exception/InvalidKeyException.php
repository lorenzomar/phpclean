<?php

/**
 * This file is part of the PhpClean package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace PhpClean\UseCase\Exception;

/**
 * Class InvalidKeyException.
 *
 * @package PhpClean
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    https://github.com/lorenzomar/phpclean
 */
class InvalidKeyException extends \InvalidArgumentException
{
    public function __construct($key, $regex, \Exception $previous = null)
    {
        $message = sprintf("Could not parse key '%s' since it doesn't match with regex '%s'", $key, $regex);

        parent::__construct($message, 0, $previous);
    }
}