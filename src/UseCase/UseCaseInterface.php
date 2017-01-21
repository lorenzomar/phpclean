<?php

/**
 * This file is part of the PhpClean package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace PhpClean\UseCase;

/**
 * Interface UseCaseInterface.
 *
 * @package PhpClean
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    https://github.com/lorenzomar/phpclean
 */
interface UseCaseInterface
{
    public function __invoke(RequestInterface $request, ResponseInterface $response);
}