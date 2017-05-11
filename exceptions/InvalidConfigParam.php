<?php
namespace PhpDevil\exceptions;


class InvalidConfigParam extends AbstractException
{
    protected $defaultMessage = 'Invalid configuration parameter';

    protected function getDefaultMessage()
    {
        return parent::getDefaultMessage() . ' ' . $this->param[0] . ' in ' . get_class($this->param[1]);
    }
}