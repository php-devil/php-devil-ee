<?php
namespace PhpDevil\exceptions;

use Exception;

abstract class AbstractException extends \Exception
{
    protected $defaultMessage = 'Error: Exception';
    protected $param = [];

    public function getDefaultMessage()
    {
        return $this->defaultMessage;
    }

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        if (is_array($message)) {
            $this->param = $message;
            $message = $this->getDefaultMessage();
        }
        parent::__construct($message, $code, $previous);
    }
}