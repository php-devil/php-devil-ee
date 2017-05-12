<?php
namespace PhpDevil\exceptions;

class InvalidComponentClassException extends AbstractException
{
    protected $defaultMessage = 'Component class not found';
}