<?php
namespace PhpDevil\web;
use PhpDevil\base\Module;

class Application extends Module
{
    /**
     * Зарезервированные имена контейнеров, доступных на данном уровне
     * @return array
     */
    protected static function getAllowedContainers()
    {
        return ['components', 'models', 'controllers', 'modules'];
    }
}