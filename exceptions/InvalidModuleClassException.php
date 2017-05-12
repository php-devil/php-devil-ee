<?php
namespace PhpDevil\exceptions;

class InvalidModuleClassException extends AbstractException
{
    protected $defaultMessage = 'Module class not found';
}