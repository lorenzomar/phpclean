<?php

/**
 * This file is part of the PhpClean package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace PhpClean\UseCase;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Class Response.
 *
 * @package PhpClean
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    https://github.com/lorenzomar/phpclean
 */
class Response extends AbstractMessage implements ResponseInterface
{
    /**
     * @var string
     */
    private $status;

    public function __construct(
        array $data = [],
        $status = 'success',
        PropertyAccessorInterface $propertyAccessor = null
    ) {
        parent::__construct($data, $propertyAccessor);

        if ($status === static::STATUS_ERROR) {
            $this->setAsError();
        } else {
            $this->setAsSuccess();
        }
    }

    public function setAsError()
    {
        $this->status = static::STATUS_ERROR;

        return $this;
    }

    public function setAsSuccess()
    {
        $this->status = static::STATUS_SUCCESS;

        return $this;
    }

    public function isError()
    {
        return $this->status === static::STATUS_ERROR;
    }

    public function isSuccess()
    {
        return $this->status === static::STATUS_SUCCESS;
    }

    public function hasError($key, $code)
    {
        if (!$this->isError() || !$this->has($key)) {
            return false;
        }

        foreach ($this->get($key, []) as $error) {
            if ($error['code'] === $code) {
                return true;
            }
        }

        return false;
    }

    public function setError($key, $code, array $meta = [])
    {
        $this->setAsError();

        $v   = $this->get($key, []);
        $v[] = [
            'code' => $code,
            'meta' => $meta,
        ];

        return $this->set($key, $v);
    }

    public function getError($key, $code, $default = null)
    {
        if (!$this->hasError($key, $code)) {
            return false;
        }

        foreach ($this->get($key, []) as $error) {
            if ($error['code'] === $code) {
                return $error;
            }
        }

        return $default;
    }

    public function hasOneError(array $alternatives)
    {
        foreach ($alternatives as $key => $errorCodes) {
            $errorCodes = is_array($errorCodes) ? $errorCodes : [$errorCodes];

            foreach ($errorCodes as $errorCode) {
                if ($this->hasError($key, $errorCode)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function hasAllErrors(array $alternatives)
    {
        foreach ($alternatives as $key => $errorCodes) {
            $errorCodes = is_array($errorCodes) ? $errorCodes : [$errorCodes];

            foreach ($errorCodes as $errorCode) {
                if (!$this->hasError($key, $errorCode)) {
                    return false;
                }
            }
        }

        return true;
    }
}