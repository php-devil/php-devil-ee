<?php
namespace PhpDevil\exceptions;

class InvalidComponentClassException extends AbstractException
{
    protected $defaultMessage = 'Components class not found';
}