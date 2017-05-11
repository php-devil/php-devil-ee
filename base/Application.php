<?php
namespace PhpDevil\base;
use PhpDevil\abstractions\AbstractApplication;

class Application extends AbstractApplication
{
    final public function __construct(array $config = null)
    {
        $this->configureFromArray($config);
    }
}