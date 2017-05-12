<?php
namespace PhpDevil\abstractions;

class AbstractApplication extends AbstractModule
{
    /**
     * Конфигурационный массив модулей
     * @return array
     */
    public static function modules()
    {
        if (($config = static::getConfig()) && isset($config['data']['modules'])) {
            return $config['data']['modules'];
        } else {
            return [];
        }
    }
}