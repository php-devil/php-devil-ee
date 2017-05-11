<?php
namespace PhpDevil\web;
use PhpDevil\base\Module;

class Application extends Module
{
    public static function getDefaultModuleClass()
    {
        return \PhpDevil\web\Module::class;
    }

    /**
     * Зарезервированные имена контейнеров, доступных на данном уровне
     * @return array
     */
    protected static function getAllowedContainers()
    {
        return ['components', 'models', 'controllers', 'modules'];
    }
}