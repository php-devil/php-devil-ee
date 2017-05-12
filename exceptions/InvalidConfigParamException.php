<?php
namespace PhpDevil\exceptions;

class InvalidConfigParamException extends AbstractException
{
    protected $defaultMessage = 'Invalid configuration parameter';

    public function getDefaultMessage()
    {
        return $this->defaultMessage . ' ' . $this->param[0] . ' in ' . get_class($this->param[1]);
    }
}